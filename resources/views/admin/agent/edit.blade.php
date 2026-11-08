@extends('admin.layouts.master')

@section('content')

    <x-admin_navbar />
    <x-admin_sidebar />

    <div class="main-content">

        <section class="section">

            {{-- رأس الصفحة --}}
            <div class="section-header d-flex justify-content-between align-items-center">

                <h1>
                    تعديل بيانات الوكيل
                </h1>

                <div class="ml-auto">
                    <a href="{{ route('admin.agents.index') }}"
                       class="btn btn-primary">

                        <i class="fas fa-arrow-right ml-2"></i>
                        العودة إلى الوكلاء

                    </a>
                </div>

            </div>

            <div class="section-body">

                <div class="row">

                    <div class="col-12">

                        <div class="card shadow-sm">

                            <div class="card-header">
                                <h4 class="mb-0">
                                    بيانات الوكيل
                                </h4>
                            </div>

                            <div class="card-body">

                                <form action="{{ route('admin.agents.update', $agent) }}"
                                      method="POST"
                                      enctype="multipart/form-data">

                                    @csrf
                                    @method('PUT')

                                    <div class="row">

                                        {{-- الصورة الحالية --}}
                                        <div class="col-12 mb-4">

                                            <label class="form-label">
                                                الصورة الحالية
                                            </label>

                                            <div>
                                                <img src="{{ $agent->photo
                                                    ? asset('user-images/' . $agent->photo)
                                                    : asset('user-images/default.png') }}"
                                                     alt="صورة الوكيل"
                                                     class="user-photo w_200">
                                            </div>

                                        </div>

                                        {{-- تغيير الصورة --}}
                                        <div class="col-12 mb-4">

                                            <label for="photo" class="form-label">
                                                تغيير الصورة
                                            </label>

                                            <input type="file"
                                                   id="photo"
                                                   name="photo"
                                                   class="form-control"
                                                   accept="image/*">

                                            <small class="text-muted">
                                                الصيغ المسموحة: JPG, JPEG, PNG, WEBP — الحجم الأقصى 2MB.
                                            </small>

                                            @error('photo')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- الاسم --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="name" class="form-label">
                                                الاسم
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text"
                                                   id="name"
                                                   name="name"
                                                   class="form-control"
                                                   value="{{ old('name', $agent->name) }}"
                                                   required>

                                            @error('name')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- البريد --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="email" class="form-label">
                                                البريد الإلكتروني
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="email"
                                                   id="email"
                                                   name="email"
                                                   class="form-control"
                                                   value="{{ old('email', $agent->email) }}"
                                                   required>

                                            @error('email')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- الشركة --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="company" class="form-label">
                                                الشركة
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text"
                                                   id="company"
                                                   name="company"
                                                   class="form-control"
                                                   value="{{ old('company', $agent->company) }}"
                                                   required>

                                            @error('company')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- رقم الهاتف --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="phone" class="form-label">
                                                رقم الهاتف
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="tel"
                                                   id="phone"
                                                   name="phone"
                                                   class="form-control"
                                                   value="{{ old('phone', $agent->phone) }}"
                                                   placeholder="0930000000"
                                                   maxlength="10"
                                                   minlength="10"
                                                   inputmode="numeric"
                                                   pattern="09[0-9]{8}"
                                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                   required>

                                            <small class="text-muted">
                                                مثال: 0930000000 — يجب أن يتكون من 10 أرقام.
                                            </small>

                                            @error('phone')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- المسمى الوظيفي --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="designation" class="form-label">
                                                المسمى الوظيفي
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text"
                                                   id="designation"
                                                   name="designation"
                                                   class="form-control"
                                                   value="{{ old('designation', $agent->designation) }}"
                                                   required>

                                            @error('designation')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- العنوان --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="address" class="form-label">
                                                العنوان
                                            </label>

                                            <input type="text"
                                                   id="address"
                                                   name="address"
                                                   class="form-control"
                                                   value="{{ old('address', $agent->address) }}">

                                            @error('address')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- الدولة --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="country" class="form-label">
                                                الدولة
                                            </label>

                                            <input type="text"
                                                   id="country"
                                                   name="country"
                                                   class="form-control"
                                                   value="{{ old('country', $agent->country) }}">

                                            @error('country')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- المحافظة --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="state" class="form-label">
                                                المحافظة
                                            </label>

                                            <input type="text"
                                                   id="state"
                                                   name="state"
                                                   class="form-control"
                                                   value="{{ old('state', $agent->state) }}">

                                            @error('state')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- المدينة --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="city" class="form-label">
                                                المدينة
                                            </label>

                                            <input type="text"
                                                   id="city"
                                                   name="city"
                                                   class="form-control"
                                                   value="{{ old('city', $agent->city) }}">

                                            @error('city')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- الموقع الإلكتروني --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="website" class="form-label">
                                                الموقع الإلكتروني
                                            </label>

                                            <input type="url"
                                                   id="website"
                                                   name="website"
                                                   class="form-control"
                                                   value="{{ old('website', $agent->website) }}"
                                                   placeholder="https://example.com">

                                            @error('website' )
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- فيسبوك --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="facebook" class="form-label">
                                                Facebook
                                            </label>

                                            <input type="text"
                                                   id="facebook"
                                                   name="facebook"
                                                   class="form-control"
                                                   value="{{ old('facebook', $agent->facebook) }}">

                                            @error('facebook')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- تويتر --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="twitter" class="form-label">
                                                Twitter
                                            </label>

                                            <input type="text"
                                                   id="twitter"
                                                   name="twitter"
                                                   class="form-control"
                                                   value="{{ old('twitter', $agent->twitter) }}">

                                            @error('twitter')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- لينكدإن --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="linkedin" class="form-label">
                                                LinkedIn
                                            </label>

                                            <input type="text"
                                                   id="linkedin"
                                                   name="linkedin"
                                                   class="form-control"
                                                   value="{{ old('linkedin', $agent->linkedin) }}">

                                            @error('linkedin')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- إنستغرام --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="instagram" class="form-label">
                                                Instagram
                                            </label>

                                            <input type="text"
                                                   id="instagram"
                                                   name="instagram"
                                                   class="form-control"
                                                   value="{{ old('instagram', $agent->instagram) }}">

                                            @error('instagram')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- الحالة --}}
                                        <div class="col-md-6 mb-3">

                                            <label for="status" class="form-label">
                                                الحالة
                                                <span class="text-danger">*</span>
                                            </label>

                                            @php
                                                $currentStatus = old(
                                                    'status',
                                                    $agent->getRawOriginal('status')
                                                );
                                            @endphp

                                            <select id="status"
                                                    name="status"
                                                    class="form-control"
                                                    required>

                                                <option value="0"
                                                    {{ (string) $currentStatus === '0' ? 'selected' : '' }}>
                                                    غير فعال
                                                </option>

                                                <option value="1"
                                                    {{ (string) $currentStatus === '1' ? 'selected' : '' }}>
                                                    فعال
                                                </option>

                                                <option value="2"
                                                    {{ (string) $currentStatus === '2' ? 'selected' : '' }}>
                                                    موقوف
                                                </option>

                                            </select>

                                            @error('status')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- السيرة الذاتية --}}
                                        <div class="col-12 mb-3">

                                            <label for="biography" class="form-label">
                                                نبذة عن الوكيل
                                            </label>

                                            <textarea id="biography"
                                                      name="biography"
                                                      class="form-control h_200"
                                                      rows="5">{{ old('biography', $agent->biography) }}</textarea>

                                            @error('biography')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror

                                        </div>

                                        {{-- أزرار الحفظ --}}
                                        <div class="col-12 mt-3">

                                            <button type="submit"
                                                    class="btn btn-primary">

                                                <i class="fas fa-save ml-2"></i>
                                                حفظ التعديلات

                                            </button>

                                            <a href="{{ route('admin.agents.index') }}"
                                               class="btn btn-light mr-2">

                                                إلغاء

                                            </a>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
