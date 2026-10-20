<?php

namespace App\Http\Controllers\Front\Agent;

use Carbon\Carbon;
use App\Models\Agent;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    /**
     * Show the agent registration form.
     *
     * @return View
     */
    public function register(): View
    {
        return view('front.agent.auth.register');
    }

    /**
     * Handle agent registration and send email verification.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function registerSubmit(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:agents,email',
            'company' => 'required|string',
            'designation' => 'required|string',
            'phone' => ['required', 'digits:10', 'unique:agents,phone', 'regex:/^09[0-9]{8}$/'],
            'password' => 'required|min:6|confirmed',
        ], [
            'phone.digits' => 'رقم الهاتف يجب أن يكون 10 أرقام، مثال: 0930000000',
            'phone.regex' => 'رقم الهاتف يجب أن يبدأ بـ 09، مثال: 0930000000',
        ]);

        $token = Str::random(64);
        $agent = Agent::create([
            'name' => ucwords($request->name),
            'email' => $request->email,
            'company' => ucwords($request->company),
            'designation' => ucwords($request->designation),
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'token' => $token,
        ]);
        try {
            Mail::send(
                'email.register_email',
                ['token' => $token, 'agent' => $agent],
                function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Email Verification');
            });
            return back()->with('success', 'Verification email has been sent to your email address.');
        } catch (\Exception) {
            $agent->forceDelete();
            return back()->with('error', 'Failed to send verification email. Please try again later.');
        };
    }

    /**
     * Verify agent email using token and activate account.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function registerVerify(Request $request): RedirectResponse
    {
        $agent = Agent::where('token', $request->token)->first();
        if (!$agent) {
            return redirect()->route('agent.register')->with('error', 'Invalid credentials.');
        };
        $agent->update([
            'token' => '',
            'status' => 1,
        ]);
        return redirect()->route('agent.login')->with('success', 'Email verification completed. Please log in.');
    }

    /**
     * Show the agent login form.
     *
     * @return View
     */
    public function login(): View
    {
        return view('front.agent.auth.login');
    }

    /**
     * Authenticate agent and redirect to dashboard.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function loginSubmit(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:agents,email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1,
        ];
        if (Auth::guard('agent')->attempt($credentials)) {
            return redirect()->route('agent.dashboard')->with('success', 'Logged in successfully.');
        } else {
            return back()->with('error', 'Invalid password or email not verified.');
        };
    }

    /**
     * Show the forget password form.
     *
     * @return View
     */
    public function forgetPassword(): View
    {
        return view('front.agent.auth.forget_password');
    }

    /**
     * Handle password reset request and send reset email.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function forgetPasswordSubmit(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:agents,email',
        ]);

        $alreadyExists = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('created_at', '>', Carbon::now()->subMinutes(60))
            ->exists();
        if ($alreadyExists) {
            return back()->with('error', 'Reset password email has already been sent to your email address.');
        };

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('created_at', '<', Carbon::now()->subMinutes(60))
            ->delete();

        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        try {
            Mail::send(
                'email.reset_password',
                ['token' => $token, 'agent' => 'agent'],
                function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });
            return back()->with('success', 'Reset password email has been sent to your email address.');
        } catch (\Exception) {
            Db::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->with('error', 'Failed to send Reset password email. Please try again later.');
        };
    }

    /**
     * Show the password reset form with token.
     *
     * @param string $token
     * @return View
     */
    public function resetPassword(string $token): View
    {
        return view('front.agent.auth.reset_password', compact('token'));
    }

    /**
     * Handle password reset submission and update user password.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function resetPasswordSubmit(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);

        $agentRecord = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if (!$agentRecord) {
            return back()->with('error', 'Invalid credentials.');
        };
        if ($agentRecord->created_at < Carbon::now()->subMinutes(60)) {
            return back()->with('error', 'Link is expired. Please request again.');
        };

        $agent = Agent::where('email', $agentRecord->email)->first();
        if (!$agent) {
            return back()->with('error', 'Agent not found.');
        };

        try {
            DB::transaction(function () use ($agent, $request, $agentRecord) {
                $agent->update([
                    'password' => Hash::make($request->password),
                ]);
                DB::table('password_reset_tokens')->where('email', $agentRecord->email)->delete();
            });
            return redirect()->route('agent.login')->with('success', 'Password changed successfully.');
        } catch(\Exception) {
            return back()->with('error', 'Operation failed. Please try again.');
        };
    }

    /**
     * Log out the user and invalidate session.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('agent')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }
}
