<?php

namespace App\Http\Controllers\Front\User;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    /**
     * عرض صفحة التسجيل.
     */
    public function register(): View
    {
        return view('front.user.auth.register');
    }

    /**
     * إنشاء حساب مستخدم جديد وتسجيل دخوله مباشرة.
     */
    public function registerSubmit(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
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
                'regex:/^09[0-9]{8}$/',
                'unique:users,phone',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ], [
            'name.required' => 'يرجى إدخال الاسم.',
            'name.max' => 'الاسم طويل جداً.',

            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.unique' => 'البريد الإلكتروني مستخدم مسبقاً.',

            'phone.required' => 'يرجى إدخال رقم الهاتف.',
            'phone.digits' => 'رقم الهاتف يجب أن يكون 10 أرقام، مثال: 0930000000',
            'phone.regex' => 'رقم الهاتف يجب أن يبدأ بـ 09، مثال: 0930000000',
            'phone.unique' => 'رقم الهاتف مستخدم مسبقاً.',

            'password.required' => 'يرجى إدخال كلمة المرور.',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 6 محارف.',
            'password.confirmed' => 'كلمتا المرور غير متطابقتين.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | إنشاء الحساب وتفعيله مباشرة
        |--------------------------------------------------------------------------
        */
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => 1,
            'token' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | تسجيل دخول المستخدم مباشرة بعد التسجيل
        |--------------------------------------------------------------------------
        */
        Auth::guard('web')->login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('home')
            ->with(
                'success',
                'تم إنشاء حسابك وتسجيل الدخول بنجاح.'
            );
    }

    /**
     * التحقق القديم من البريد الإلكتروني.
     *
     * أبقينا الدالة حتى لا يحدث خطأ إذا كان هناك رابط قديم.
     */
    public function registerVerify(Request $request): RedirectResponse
    {
        $user = User::where(
            'token',
            $request->token
        )->first();

        if (!$user) {
            return redirect()
                ->route('user.register')
                ->with(
                    'error',
                    'رمز التحقق غير صالح.'
                );
        }

        $user->update([
            'token' => null,
            'status' => 1,
        ]);

        return redirect()
            ->route('user.login')
            ->with(
                'success',
                'تم تفعيل الحساب بنجاح. يمكنك تسجيل الدخول الآن.'
            );
    }

    /**
     * عرض صفحة تسجيل الدخول.
     */
    public function login(): View
    {
        return view('front.user.auth.login');
    }

    /**
     * تسجيل دخول المستخدم.
     */
    public function loginSubmit(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'exists:users,email',
            ],

            'password' => [
                'required',
            ],
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.exists' => 'البريد الإلكتروني غير موجود.',
            'password.required' => 'يرجى إدخال كلمة المرور.',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1,
        ];

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()
                ->route('user.dashboard')
                ->with(
                    'success',
                    'تم تسجيل الدخول بنجاح.'
                );
        }

        return back()
            ->withInput($request->only('email'))
            ->with(
                'error',
                'البريد الإلكتروني أو كلمة المرور غير صحيحة، أو أن الحساب غير مفعّل.'
            );
    }

    /**
     * عرض صفحة تعديل الملف الشخصي.
     */
    public function editProfile(User $user): View
    {
        if (Auth::guard('web')->id() !== $user->id) {
            abort(
                403,
                'غير مسموح لك بتعديل هذا الحساب.'
            );
        }

        return view(
            'front.user.auth.edit_profile',
            compact('user')
        );
    }

    /**
     * تحديث الملف الشخصي بدون طلب كلمة المرور القديمة.
     */
    public function editProfileSubmit(
        Request $request,
        User $user
    ): RedirectResponse {
        if (Auth::guard('web')->id() !== $user->id) {
            abort(
                403,
                'غير مسموح لك بتعديل هذا الحساب.'
            );
        }

        $request->validate([
            'name' => [
                'required',
                'string',
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
                'regex:/^09[0-9]{8}$/',
                'unique:users,phone,' . $user->id,
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],
        ], [
            'name.required' => 'يرجى إدخال الاسم.',
            'name.max' => 'الاسم طويل جداً.',

            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.unique' => 'البريد الإلكتروني مستخدم مسبقاً.',

            'phone.required' => 'يرجى إدخال رقم الهاتف.',
            'phone.digits' => 'رقم الهاتف يجب أن يكون 10 أرقام.',
            'phone.regex' => 'رقم الهاتف يجب أن يبدأ بـ 09.',
            'phone.unique' => 'رقم الهاتف مستخدم مسبقاً.',

            'photo.image' => 'الملف المرفوع يجب أن يكون صورة.',
            'photo.mimes' => 'صيغة الصورة يجب أن تكون JPG أو JPEG أو PNG أو WEBP.',
            'photo.max' => 'حجم الصورة يجب ألا يتجاوز 5 ميغابايت.',

            'password.min' => 'كلمة المرور يجب ألا تقل عن 6 محارف.',
            'password.confirmed' => 'كلمتا المرور غير متطابقتين.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // لا يتم تغيير كلمة المرور إذا بقي الحقل فارغاً
        if ($request->filled('password')) {
            $data['password'] = Hash::make(
                $request->password
            );
        }

        /*
        |--------------------------------------------------------------------------
        | رفع صورة جديدة
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            $photoName = time()
                . '_'
                . Str::random(10)
                . '.'
                . $photo->getClientOriginalExtension();

            $uploadPath = public_path('user-images');

            if (!File::exists($uploadPath)) {
                File::makeDirectory(
                    $uploadPath,
                    0755,
                    true
                );
            }

            $photo->move(
                $uploadPath,
                $photoName
            );

            // حذف الصورة القديمة
            if (
                $user->photo &&
                $user->photo !== 'default.png' &&
                File::exists(
                    $uploadPath . '/' . $user->photo
                )
            ) {
                File::delete(
                    $uploadPath . '/' . $user->photo
                );
            }

            $data['photo'] = $photoName;
        }

        $user->update($data);

        return redirect()
            ->route(
                'user.edit.profile',
                $user
            )
            ->with(
                'success',
                'تم تحديث الملف الشخصي بنجاح.'
            );
    }

    /**
     * عرض صفحة نسيت كلمة المرور.
     */
    public function forgetPassword(): View
    {
        return view(
            'front.user.auth.forget_password'
        );
    }

    /**
     * إرسال رابط إعادة تعيين كلمة المرور.
     */
    public function forgetPasswordSubmit(
        Request $request
    ): RedirectResponse {
        $request->validate([
            'email' => [
                'required',
                'email',
                'exists:users,email',
            ],
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.exists' => 'البريد الإلكتروني غير موجود.',
        ]);

        $alreadyExists = DB::table(
            'password_reset_tokens'
        )
            ->where(
                'email',
                $request->email
            )
            ->where(
                'created_at',
                '>',
                Carbon::now()->subMinutes(60)
            )
            ->exists();

        if ($alreadyExists) {
            return back()->with(
                'error',
                'تم إرسال رابط إعادة التعيين مسبقاً. يرجى المحاولة بعد ساعة.'
            );
        }

        DB::table('password_reset_tokens')
            ->where(
                'email',
                $request->email
            )
            ->where(
                'created_at',
                '<',
                Carbon::now()->subMinutes(60)
            )
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
                [
                    'token' => $token,
                    'user' => 'user',
                ],
                function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject(
                        'إعادة تعيين كلمة المرور'
                    );
                }
            );

            return back()->with(
                'success',
                'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.'
            );
        } catch (\Exception $exception) {
            Log::warning(
                'User reset email failed: '
                . $exception->getMessage()
            );

            // عرض الرابط أثناء التجربة المحلية فقط
            if (app()->environment('local')) {
                return back()->with(
                    'success',
                    'رابط إعادة التعيين للتجربة المحلية: '
                    . route(
                        'user.reset.password',
                        $token
                    )
                );
            }

            DB::table('password_reset_tokens')
                ->where(
                    'email',
                    $request->email
                )
                ->delete();

            return back()->with(
                'error',
                'تعذر إرسال رسالة إعادة تعيين كلمة المرور.'
            );
        }
    }

    /**
     * عرض صفحة إعادة تعيين كلمة المرور.
     */
    public function resetPassword(
        string $token
    ): View {
        return view(
            'front.user.auth.reset_password',
            compact('token')
        );
    }

    /**
     * حفظ كلمة المرور الجديدة.
     */
    public function resetPasswordSubmit(
        Request $request
    ): RedirectResponse {
        $request->validate([
            'token' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'min:6',
                'confirmed',
            ],
        ], [
            'token.required' => 'رمز إعادة التعيين غير موجود.',
            'password.required' => 'يرجى إدخال كلمة المرور الجديدة.',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 6 محارف.',
            'password.confirmed' => 'كلمتا المرور غير متطابقتين.',
        ]);

        $userRecord = DB::table(
            'password_reset_tokens'
        )
            ->where(
                'token',
                $request->token
            )
            ->first();

        if (!$userRecord) {
            return back()->with(
                'error',
                'رابط إعادة التعيين غير صالح.'
            );
        }

        if (
            Carbon::parse($userRecord->created_at)
                ->lt(
                    Carbon::now()->subMinutes(60)
                )
        ) {
            return back()->with(
                'error',
                'انتهت صلاحية الرابط. يرجى طلب رابط جديد.'
            );
        }

        $user = User::where(
            'email',
            $userRecord->email
        )->first();

        if (!$user) {
            return back()->with(
                'error',
                'لم يتم العثور على المستخدم.'
            );
        }

        try {
            DB::transaction(
                function () use (
                    $user,
                    $request,
                    $userRecord
                ) {
                    $user->update([
                        'password' => Hash::make(
                            $request->password
                        ),
                    ]);

                    DB::table(
                        'password_reset_tokens'
                    )
                        ->where(
                            'email',
                            $userRecord->email
                        )
                        ->delete();
                }
            );

            return redirect()
                ->route('user.login')
                ->with(
                    'success',
                    'تم تغيير كلمة المرور بنجاح.'
                );
        } catch (\Exception $exception) {
            Log::error(
                'Password reset failed: '
                . $exception->getMessage()
            );

            return back()->with(
                'error',
                'فشلت العملية. يرجى المحاولة مرة أخرى.'
            );
        }
    }

    /**
     * تسجيل خروج المستخدم.
     */
    public function logout(
        Request $request
    ): RedirectResponse {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with(
                'success',
                'تم تسجيل الخروج بنجاح.'
            );
    }
}
