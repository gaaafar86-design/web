<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Show the profile edit form for the authenticated admin.
     *
     * @return View
     */
    public function editProfile(): View
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.dashboard.index', compact('admin'));
    }

    /**
     * Handle profile update submission for the given admin.
     *
     * Validates input, updates profile fields, handles photo upload,
     * and manages sensitive changes like email and password.
     * If email or password changes, sends verification email and logs out the admin.
     *
     * @param Request $request
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function editProfileSubmit(Request $request, Admin $admin): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
            'photo' => 'nullable|image|max:2048',
        ]);

        $updates = [
            'name' => ucwords($request->name),
        ];

        $emailChanged = $request->email !== $admin->email;
        if ($emailChanged) {
            $updates['email'] = $request->email;
        };
        if ($request->filled('password')) {
            $updates['password'] = Hash::make($request->password);
        };
        if ($request->file('photo')) {
            Storage::delete('user-images/' . $admin->photo);
            $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('user-images', $fileName);
            $updates['photo'] = $fileName;
        };

        $admin->update($updates);
        if ($emailChanged || $request->filled('password')) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $message = 'Sensitive credentials were changed. Please log in again.';
            return redirect()->route('admin.login')->with('success', $message);
        };
        return back()->with('success', 'Profile updated successfully.');
    }
}
