<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
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
     * Show the admin login form.
     *
     * @return View
     */
    public function login(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Authenticate admin and redirect to admin panel.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function loginSubmit(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($request->only(['email', 'password']))) {
            return redirect()->route('admin.panel')->with('success', 'Logged in successfully.');
        };
        return back()->with('error', 'Wrong credentials.');
    }

    /**
     * Show the forget password form.
     *
     * @return View
     */
    public function forgetPassword(): View
    {
        return view('admin.auth.forget_password');
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
            'email' => 'required|email|exists:admins,email',
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
                ['token' => $token, 'admin' => 'admin'],
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
        return view('admin.auth.reset_password', compact('token'));
    }

    /**
     * Handle password reset submission and update admin password.
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

        $adminRecord = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if (!$adminRecord) {
            return back()->with('error', 'Invalid credentials.');
        };
        if ($adminRecord->created_at < Carbon::now()->subMinutes(60)) {
            return back()->with('error', 'Link is expired. Please request again.');
        };

        $admin = Admin::where('email', $adminRecord->email)->first();
        if (!$admin) {
            return back()->with('error', 'Admin not found.');
        };

        try {
            DB::transaction(function () use ($admin, $request, $adminRecord) {
                $admin->update([
                    'password' => Hash::make($request->password),
                ]);
                DB::table('password_reset_tokens')->where('email', $adminRecord->email)->delete();
            });
            return redirect()->route('admin.login')->with('success', 'Password changed successfully.');
        } catch(\Exception) {
            return back()->with('error', 'Operation failed. Please try again.');
        };
    }

    /**
     * Log out the admin and invalidate session.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
