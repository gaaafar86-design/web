<?php

namespace App\Http\Controllers\Front\User;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\User;
use App\Models\Agent;
use App\Models\Message;
use App\Models\Property;
use App\Models\Wishlist;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PropertyWishlisted;
use Illuminate\Support\Facades\Notification;

class DashboardController extends Controller
{
    /**
     * Show the profile edit form for the authenticated user.
     *
     * @return View
     */
    public function editProfile(): View
    {
        $user = Auth::guard('web')->user();
        return view('front.user.dashboard.edit_profile', compact('user'));
    }

    /**
     * Handle profile update submission for the given user.
     *
     * Validates input, updates profile fields, handles photo upload,
     * and manages sensitive changes like email and password.
     * If email or password changes, sends verification email and logs out the user.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function editProfileSubmit(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => ['required', 'digits:10', 'regex:/^09[0-9]{8}$/', 'unique:users,phone,' . $user->id],
            'password' => 'nullable|min:6|confirmed',
            'photo' => 'nullable|image|max:2048',
        ], [
            'phone.digits' => 'رقم الهاتف يجب أن يكون 10 أرقام، مثال: 0930000000',
            'phone.regex' => 'رقم الهاتف يجب أن يبدأ بـ 09، مثال: 0930000000',
        ]);

        $emailChanged = $request->email !== $user->email;
        if ($emailChanged) {
            $token = Str::random(64);
            try {
                Mail::send(
                    'email.register_email',
                    ['token' => $token, 'user' => 'user'],
                    function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Email Verification');
                });
                $updates['token'] = $token;
                $updates['status'] = 0;
                $updates['email'] = $request->email;
            } catch (\Exception) {
                return back()->with('error', 'Failed to send verification email. Please try again later.');
            };
        };
        if ($request->filled('password')) {
            $updates['password'] = Hash::make($request->password);
        };

        $fileName = $user->photo;
        if ($request->file('photo')) {
            Storage::delete('user-images/' . $user->photo);
            $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('user-images', $fileName);
        };

        $updates['name'] = ucwords($request->name);
        $updates['phone'] = $request->phone;
        $updates['photo'] = $fileName;
        $user->update($updates);

        if ($emailChanged || $request->filled('password')) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $message = $emailChanged
            ? 'Sensitive credentials were changed. Verification email has been sent to your email address.'
            : 'Sensitive credentials were changed. Please log in again.';
            return redirect()->route('user.login')->with('success', $message);
        };
        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Display the authenticated user's wishlist items.
     *
     * Retrieves all wishlist entries for the currently authenticated user using the `web` guard.
     * The items are ordered by latest first and passed to the dashboard view for rendering.
     *
     * @return View
     */
    public function wishlist(): View
    {
        $wishlistItems = Wishlist::where('user_id', Auth::guard('web')->id())
            ->with('property')
            ->paginate(12);
        return view('front.user.dashboard.wishlist', compact('wishlistItems'));
    }

    /**
     * Add the specified property to the authenticated user's wishlist.
     *
     * Creates a new wishlist entry linking the current user (via `web` guard)
     * to the given property. Redirects back with a success message.
     *
     * @param Property $property
     * @return RedirectResponse
     */
    public function addToWishlist(Property $property): RedirectResponse
    {
        $user = Auth::guard('web')->user();

        $exists = Wishlist::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->exists();

        if ($exists) {
            return back()->with('success', 'العقار موجود مسبقاً في المفضلة.');
        }

        Wishlist::create([
            'property_id' => $property->id,
            'user_id' => $user->id,
        ]);

        $admins = Admin::all();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new PropertyWishlisted($user, $property));
        }

        return back()->with('success', 'تمت إضافة العقار إلى المفضلة.');
    }

    /**
     * Remove the specified wishlist entry.
     *
     * Deletes the wishlist record from the database and redirects back
     * with a success message. Assumes route model binding for the `Wishlist` model.
     *
     * @param Wishlist $wishlist
     * @return RedirectResponse
     */
    public function removeFromWishlist(Wishlist $wishlist): RedirectResponse
    {
        $wishlist->delete();
        return back()->with('success', 'Property deleted from wishlist.');
    }
}
