<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | عرض جميع المستخدمين
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $users = User::latest()->get();

        return view('admin.user.index', compact('users'));
    }

    /*
    |--------------------------------------------------------------------------
    | صفحة إنشاء مستخدم
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view('admin.user.create');
    }

    /*
    |--------------------------------------------------------------------------
    | حفظ مستخدم جديد
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'phone' => [
                'required',
                'digits:10',
                'unique:users,phone',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ], [
            'phone.digits' => 'رقم الهاتف يجب أن يكون 10 أرقام، مثال: 0930000000',
            'phone.unique' => 'رقم الهاتف مستخدم مسبقاً.',
            'email.unique' => 'البريد الإلكتروني مستخدم مسبقاً.',
            'password.confirmed' => 'كلمتا المرور غير متطابقتين.',
            'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.',
        ]);

        $fileName = null;

        /*
        |--------------------------------------------------------------------------
        | رفع صورة المستخدم
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('photo')) {
            $fileName = Carbon::now()->format('YmdHisv') . '-' .
                Str::slug(
                    pathinfo(
                        $request->file('photo')->getClientOriginalName(),
                        PATHINFO_FILENAME
                    )
                ) . '.' .
                $request->file('photo')->getClientOriginalExtension();

            $request->file('photo')->storeAs(
                'user-images',
                $fileName
            );
        }

        $token = Str::random(64);

        /*
        |--------------------------------------------------------------------------
        | إنشاء المستخدم
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'photo' => $fileName,
            'token' => $token,
        ]);

        /*
        |--------------------------------------------------------------------------
        | إرسال رسالة التحقق بالبريد
        |--------------------------------------------------------------------------
        */

        try {
            Mail::send(
                'email.register_email',
                [
                    'token' => $token,
                    'adminUser' => $user,
                    'request' => $request,
                ],
                function ($mail) use ($user) {
                    $mail->to($user->email)
                        ->subject('Email Verification');
                }
            );

            return redirect()
                ->route('admin.users.index')
                ->with(
                    'success',
                    'تم إنشاء المستخدم وإرسال رسالة التحقق إلى بريده الإلكتروني.'
                );
        } catch (\Throwable $e) {
            /*
            |--------------------------------------------------------------------------
            | في البيئة المحلية نفعّل المستخدم مباشرة
            |--------------------------------------------------------------------------
            */

            if (app()->environment('local')) {
                $user->update([
                    'token' => null,
                ]);

                return redirect()
                    ->route('admin.users.index')
                    ->with(
                        'success',
                        'تم إنشاء المستخدم بنجاح في البيئة المحلية.'
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | حذف البيانات عند فشل الإيميل على الاستضافة
            |--------------------------------------------------------------------------
            */

            if ($fileName) {
                Storage::delete('user-images/' . $fileName);
            }

            $user->forceDelete();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'فشل إرسال رسالة التحقق، يرجى المحاولة لاحقاً.'
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | صفحة تعديل المستخدم
    |--------------------------------------------------------------------------
    */

    public function edit(User $user): View
    {
        return view('admin.user.edit', compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | تعديل بيانات المستخدم
    |--------------------------------------------------------------------------
    |
    | لا يوجد تعديل لكلمة المرور هنا.
    | الأدمن يستطيع تعديل الاسم والإيميل والهاتف والحالة والصورة فقط.
    |
    */

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],

            'phone' => [
                'required',
                'digits:10',
                'unique:users,phone,' . $user->id,
            ],

            'status' => [
                'required',
                'in:0,1,2',
            ],
        ], [
            'phone.digits' => 'رقم الهاتف يجب أن يكون 10 أرقام، مثال: 0930000000',
            'phone.unique' => 'رقم الهاتف مستخدم مسبقاً.',
            'email.unique' => 'البريد الإلكتروني مستخدم مسبقاً.',
        ]);

        $updates = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'status' => $data['status'],
        ];

        /*
        |--------------------------------------------------------------------------
        | رفع صورة جديدة
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete('user-images/' . $user->photo);
            }

            $fileName = Carbon::now()->format('YmdHisv') . '-' .
                Str::slug(
                    pathinfo(
                        $request->file('photo')->getClientOriginalName(),
                        PATHINFO_FILENAME
                    )
                ) . '.' .
                $request->file('photo')->getClientOriginalExtension();

            $request->file('photo')->storeAs(
                'user-images',
                $fileName
            );

            $updates['photo'] = $fileName;
        }

        /*
        |--------------------------------------------------------------------------
        | حفظ تعديلات المستخدم
        |--------------------------------------------------------------------------
        */

        $user->update($updates);

        /*
        |--------------------------------------------------------------------------
        | إرسال إشعار للمستخدم بعد تعديل بياناته
        |--------------------------------------------------------------------------
        |
        | فشل الإيميل لا يمنع حفظ التعديلات.
        |
        */

        try {
            Mail::send(
                'email.admin_user_edit',
                [
                    'user' => $user,
                    'request' => $request,
                ],
                function ($mail) use ($user) {
                    $mail->to($user->email)
                        ->subject('تم تحديث بيانات حسابك');
                }
            );
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'تم تعديل بيانات المستخدم بنجاح.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | حذف المستخدم
    |--------------------------------------------------------------------------
    */

    public function destroy(User $user): RedirectResponse
    {
        if ($user->photo) {
            Storage::delete('user-images/' . $user->photo);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'تم حذف المستخدم بنجاح.'
            );
    }
}
