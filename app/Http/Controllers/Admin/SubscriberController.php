<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $subscribers = Subscriber::all();
        return view('admin.subscriber.index', compact('subscribers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.subscriber.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'status' => 'required|in:0,1',
        ]);

        if (!$request->status) {
            $token = Str::random(64);
            $subscriber = Subscriber::create([
                'email' => $request->email,
                'token' => $token,
            ]);
            try {
                Mail::send('email.subscriber', ['token' => $token], function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Subscription Verification');
                });
                return redirect()->route('admin.subscribers.index')->with('success', 'Verification email sent successfully.');
            } catch (\Exception) {
                $subscriber->delete();
                back()->with('error', 'Failed to send verification email.');
            };
        };
        Subscriber::create([
            'email' => $request->email,
            'token' => '',
            'status' => 1,
        ]);
        return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subscriber $subscriber
     * @return RedirectResponse
     */
    public function destroy(Subscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();
        return back()->with('success', 'Subscriber deleted successfully.');
    }

    /**
     * Export all the subscribers.
     *
     * @return StreamedResponse
     */
    public function export(): StreamedResponse
    {
        $subscribers = Subscriber::all();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="subscribers.csv"',
        ];
        $columns = ['ID', 'Email', 'Status', 'Created At'];
        $callback = function () use ($subscribers, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($subscribers as $subscriber) {
                fputcsv($file, [
                    $subscriber->id,
                    $subscriber->email,
                    $subscriber->status,
                    $subscriber->created_at,
                ]);
            };
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
