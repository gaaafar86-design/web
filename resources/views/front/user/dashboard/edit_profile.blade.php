@extends('front.layouts.master')

@section('content')

    <div dir="rtl">

        <div class="page-top"
             style="background-image: url('{{ asset('website-images/' . $setting->banner) }}')">

            <div class="bg"></div>

            <div class="container">

                <div class="row">

                    <div class="col-md-12">

                        <h2>تعديل الملف الشخصي</h2>

                    </div>

                </div>

            </div>

        </div>

        <div class="page-content user-panel">

            <div class="container">

                <div class="row">

                    <div class="col-lg-3 col-md-12">

                        <x-dashboard />

                    </div>

                    <div class="col-lg-9 col-md-12">

                        <form action="{{ route('user.edit.profile.submit', $user) }}"
                              method="POST"
                              enctype="multipart/form-data"
                              autocomplete="off">

                            @csrf

                            {{-- حقول مخفية لمنع مدير كلمات المرور من التعبئة التلقائية --}}
                            <input type="text"
                                   name="fake_username"
                                   value=""
                                   autocomplete="username"
                                   tabindex="-1"
                                   style="position: absolute; left: -9999px; opacity: 0;">

                            <input type="password"
                                   name="fake_password"
                                   value=""
                                   autocomplete="current-password"
                                   tabindex="-1"
                                   style="position: absolute; left: -9999px; opacity: 0;">

                            <div class="row g-4">

                                {{-- الصورة الحالية --}}
                                <div class="col-md-12">

                                    <label class="form-label fw-bold">
                                        الصورة الحالية
                                    </label>

                                    <div class="mb-3">

                                        <img src="{{ $user->photo
                                            ? asset('user-images/' . $user->photo)
                                            : asset('user-images/default.png') }}"
                                             alt="صورة المستخدم"
                                             class="img-thumbnail rounded-circle"
                                             style="width: 120px; height: 120px; object-fit: cover;">

                                    </div>

                                </div>

                                {{-- رفع صورة جديدة --}}
                                <div class="col-md-12">

                                    <label for="photo" class="form-label">
                                        رفع صورة جديدة
                                    </label>

                                    <input type="file"
                                           name="photo"
                                           id="photo"
                                           class="form-control"
                                           accept="image/*">

                                    @error('photo')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>

                                {{-- الاسم --}}
                                <div class="col-md-6">

                                    <label for="name" class="form-label">
                                        الاسم الكامل *
                                    </label>

                                    <input type="text"
                                           name="name"
                                           id="name"
                                           class="form-control"
                                           value="{{ old('name', $user->name) }}"
                                           autocomplete="name"
                                           required>

                                    @error('name')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>

                                {{-- البريد الإلكتروني --}}
                                <div class="col-md-6">

                                    <label for="email" class="form-label">
                                        البريد الإلكتروني *
                                    </label>

                                    <input type="email"
                                           name="email"
                                           id="email"
                                           class="form-control"
                                           value="{{ old('email', $user->email) }}"
                                           autocomplete="email"
                                           required>

                                    @error('email')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>

                                {{-- كلمة المرور الجديدة --}}
                                <div class="col-md-6">

                                    <label for="password" class="form-label">
                                        كلمة المرور الجديدة
                                    </label>

                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="form-control"
                                           placeholder="اتركها فارغة إذا لا تريد تغييرها"
                                           autocomplete="new-password"
                                           readonly
                                           onfocus="this.removeAttribute('readonly');">

                                    <small class="text-muted">
                                        اترك الحقل فارغاً للإبقاء على كلمة المرور الحالية.
                                    </small>

                                    @error('password')
                                        <small class="text-danger d-block">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>

                                {{-- تأكيد كلمة المرور الجديدة --}}
                                <div class="col-md-6">

                                    <label for="password_confirmation" class="form-label">
                                        تأكيد كلمة المرور الجديدة
                                    </label>

                                    <input type="password"
                                           name="password_confirmation"
                                           id="password_confirmation"
                                           class="form-control"
                                           placeholder="أعد كتابة كلمة المرور الجديدة"
                                           autocomplete="new-password"
                                           readonly
                                           onfocus="this.removeAttribute('readonly');">

                                    @error('password_confirmation')
                                        <small class="text-danger d-block">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>

                                {{-- رقم الهاتف --}}
                                <div class="col-md-12">

                                    <label for="phone" class="form-label">
                                        رقم الهاتف *
                                    </label>

                                    <input type="tel"
                                           name="phone"
                                           id="phone"
                                           class="form-control"
                                           value="{{ old('phone', $user->phone) }}"
                                           placeholder="0930000000"
                                           maxlength="10"
                                           minlength="10"
                                           inputmode="numeric"
                                           pattern="09[0-9]{8}"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                           required>

                                    <small class="text-muted">
                                        مثال: 0930000000
                                    </small>

                                    @error('phone')
                                        <small class="text-danger d-block">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>

                                {{-- زر الحفظ --}}
                                <div class="col-md-12 text-end">

                                    <button type="submit"
                                            class="btn btn-primary px-4">

                                        حفظ التعديلات

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
