<?php

namespace App\Http\Controllers\Front\Agent;

use App\Models\Plan;
use App\Models\Order;
use App\Models\AgentPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    /**
     * Initiates a payment request for the selected plan via Zibal gateway.
     *
     * - Checks if the agent already has an active plan (not expired or unlimited).
     * - Deletes any expired plans for cleanup.
     * - Sends a payment request to Zibal with merchant and amount details.
     * - Creates a new Order record with the returned track ID.
     * - Redirects the agent to Zibal's payment gateway.
     *
     * If the agent already has an active plan, redirects back with an error.
     * If the payment request fails, redirects back with a connection error.
     *
     * @param Plan $plan
     * @return RedirectResponse
     */
    public function send(Plan $plan): RedirectResponse
    {
        $agentId = Auth::guard('agent')->id();
        $activePlan = AgentPlan::where('agent_id', $agentId)
            ->where('expire_at', '>', now())
            ->orWhere('expire_at', null)
            ->first();

        if ($activePlan) {
            return redirect()->route('agent.dashboard')->with(
                'error',
                'You have already an active plan. For more information please contact support.'
            );
        };
        AgentPlan::where('agent_id', $agentId)
            ->where('expire_at', '<', now())
            ->delete();

        $parameters = array(
            "merchant" => 'zibal',
            "callbackUrl" => config('app.payment_callback_url'),
            "amount" => $plan->price . 0,
        );
        $response = $this->postToZibal('request', $parameters);
        if ($response->result == 100) {
            $startGateWayUrl = "https://gateway.zibal.ir/start/" . $response->trackId;
            Order::create([
                'agent_id' => $agentId,
                'plan_id' => $plan->id,
                'paid_amount' => $plan->price,
                'track_id' => $response->trackId,
            ]);
            return redirect($startGateWayUrl);
        } else {
            return back()->with('error', 'Connection to service failed. Please try again.');
        };
    }

    /**
     * Handles the payment verification callback from Zibal.
     *
     * Workflow:
     * - Checks if the payment was marked successful (`$request->success == 1`).
     * - Sends a verification request to Zibal using the provided `trackId`.
     * - If Zibal confirms the transaction (`result == 100`):
     *   - Retrieves the related order.
     *   - Calculates the plan expiration date based on `allowed_days`.
     *   - Updates the order and creates a new AgentPlan inside a DB transaction.
     *   - Sends a confirmation email to the agent.
     *   - Redirects to the agent dashboard with a success message.
     * - If verification fails or payment was not successful:
     *   - Redirects with appropriate error messages.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function verify(Request $request): RedirectResponse
    {
        if ($request->success == 1) {
            $parameters = array(
                "merchant" => 'zibal',
                "trackId" => $request->trackId,
            );
            $response = $this->postToZibal('verify', $parameters);
            if ($response->result == 100) {
                $order = Order::where('track_id', $request->trackId)->first();
                $expirationDate = $order->plan->allowed_days == -1
                ? null
                : now()->addDays($order->plan->allowed_days);

                try {
                    DB::transaction(function () use ($order, $response, $expirationDate, &$agentPlan) {
                        $order->update([
                            'transaction_id' => $response->refNumber,
                            'status' => 1,
                        ]);
                        $agentPlan = AgentPlan::create([
                            'agent_id' => $order->agent_id,
                            'plan_id' => $order->plan_id,
                            'purchased_at' => now(),
                            'expire_at' => $expirationDate,
                        ]);
                    });
                    Mail::send('email.agent_purchase', ['order' => $order, 'plan' => $agentPlan] , function ($message) {
                        $message->to(Auth::guard('agent')->user()->email);
                        $message->subject('Payment Successful');
                    });
                    return redirect()->route('agent.plan')->with('success', 'Purchase successfull.');
                } catch (\Exception $e) {
                    return redirect()->route('agent.plan')->with('error', 'Something went wrong. Please contact support.');
                };
            } else {
                return redirect()->route('agent.dashboard')->with(
                    'error',
                    'Payment verification failed. Please contact support.'
                );
            };
        } else {
            return redirect()->route('pricing')->with('error', 'Transaction failed. Please try again.');
        };
    }

    /**
     * Sends a POST request to the Zibal payment gateway.
     *
     * Constructs a JSON payload and sends it to the specified Zibal API endpoint.
     * Used for actions like `request`, `verify`, etc.
     *
     * @param string $path
     * @param array $parameters
     * @return object|null
     */
    public function postToZibal(string $path, array $parameters): object|null
    {
        $url = 'https://gateway.zibal.ir/v1/'. $path;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }
}
