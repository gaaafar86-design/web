<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAuth
{
    /**
     * التحقق من تسجيل الدخول وحالة حساب المستخدم.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $guard = Auth::guard('web');

        /*
        |--------------------------------------------------------------------------
        | التحقق من تسجيل الدخول
        |--------------------------------------------------------------------------
        */
        if (!$guard->check()) {
            return redirect()
                ->route('user.login')
                ->with(
                    'error',
                    'يرجى تسجيل الدخول أولاً.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | جلب آخر بيانات للمستخدم من قاعدة البيانات
        |--------------------------------------------------------------------------
        */
        $user = $guard->user()->fresh();

        if (!$user) {
            $guard->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('user.login')
                ->with(
                    'error',
                    'لم يتم العثور على حساب المستخدم.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | التحقق من حالة الحساب
        |--------------------------------------------------------------------------
        | القيم المقبولة للحساب المفعّل:
        | 1 - active - enabled - approved - مفعل - مفعّل
        |--------------------------------------------------------------------------
        */
        $status = strtolower(
            trim((string) $user->status)
        );

        $activeStatuses = [
            '1',
            'true',
            'yes',
            'active',
            'enabled',
            'approved',
            'فعال',
            'مفعل',
            'مفعّل',
            'نشط',
            'موافق عليه',
        ];

        /*
        |--------------------------------------------------------------------------
        | إذا كان الحساب غير مفعّل
        |--------------------------------------------------------------------------
        */
        if (!in_array($status, $activeStatuses, true)) {
            $guard->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('user.login')
                ->with(
                    'error',
                    'تم تعطيل حسابك من قبل الإدارة. يرجى التواصل مع المكتب.'
                );
        }

        return $next($request);
    }
}
