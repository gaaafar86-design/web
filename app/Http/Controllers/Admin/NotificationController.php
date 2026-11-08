<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


class NotificationController extends Controller
{
    public function index(): View
    {
        $admin = Auth::guard('admin')->user();
        $notifications = $admin->notifications()->paginate(20);

        return view('admin.notification.index', compact('notifications'));
    }
    public function deleteAll(): RedirectResponse
{
    DB::table('notifications')->delete();

    return redirect()
        ->route('admin.notifications.index')
        ->with(
            'success',
            'تم حذف جميع الإشعارات بنجاح.'
        );
}


    public function markAsRead(string $id): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();
        $notification = $admin->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();

        $slug = $notification->data['property_slug'] ?? null;
        if ($slug) {
            return redirect()->route('property.detail', $slug);
        }

        return back();
    }

    public function markAllAsRead(): RedirectResponse
    {
        Auth::guard('admin')->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'تم تعليم كل الإشعارات كمقروءة.');
    }
}
