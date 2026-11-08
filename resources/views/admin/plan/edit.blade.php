@extends('admin.layouts.master')

@section('content')

    <x-admin_navbar />
    <x-admin_sidebar />

    <div class="main-content">

        <section class="section">

            {{-- رأس الصفحة --}}
            <div class="section-header d-flex justify-content-between align-items-center">

                <h1>
                    تعديل العرض
                </h1>

                <div class="ml-auto">
                    <a href="{{ route('admin.plans.index') }}"
                       class="btn btn-primary">

                        <i class="fas fa-arrow-right ml-2"></i>
                        العودة إلى العروض

                    </a>
                </div>

            </div>

            <div class="section-body">

                <div class="row">

                    <div class="col-12">

                        <div class="card shadow-sm">

                            <div class="card-header">
                                <h4 class="mb-0">
                                    تعديل تفاصيل العرض
                                </h4>
                            </div>

                            <div class="card-body">

                                <form action="{{ route('admin.plans.update', $plan->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('PUT')

                                    {{-- الحقول مخفية لأن العرض لا يعتمد الصور والفيديوهات --}}
                                    <input type="hidden"
                                           name="allowed_photos"
                                           value="0">

                                    <input type="hidden"
                                           name="allowed_videos"
                                           value="0">

                                    {{-- اسم العرض والسعر --}}
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group mb-4">

                                                <label for="name">
                                                    اسم العرض
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text"
                                                       id="name"
                                                       name="name"
                                                       class="form-control"
                                                       value="{{ old('name', $plan->name) }}"
                                                       placeholder="مثال: العرض الأساسي"
                                                       required>

                                                @error('name')
                                                    <small class="text-danger d-block mt-1">
                                                        {{ $message }}
                                                    </small>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-4">

                                                <label for="price">
                                                    سعر العرض
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="number"
                                                       id="price"
                                                       name="price"
                                                       class="form-control"
                                                       value="{{ old('price', $plan->price) }}"
                                                       min="0"
                                                       step="0.01"
                                                       placeholder="أدخل سعر العرض"
                                                       required>

                                                <small class="text-muted">
                                                    اكتب السعر من دون فواصل أو رموز.
                                                </small>

                                                @error('price')
                                                    <small class="text-danger d-block mt-1">
                                                        {{ $message }}
                                                    </small>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>

                                    {{-- مدة العرض وعدد العقارات --}}
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group mb-4">

                                                <label for="allowed_days">
                                                    مدة العرض بالأيام
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="number"
                                                       id="allowed_days"
                                                       name="allowed_days"
                                                       class="form-control"
                                                       value="{{ old('allowed_days', $plan->allowed_days) }}"
                                                       min="-1"
                                                       placeholder="مثال: 30"
                                                       required>

                                                <small class="text-muted">
                                                    اكتب -1 إذا كانت المدة غير محدودة.
                                                </small>

                                                @error('allowed_days')
                                                    <small class="text-danger d-block mt-1">
                                                        {{ $message }}
                                                    </small>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-4">

                                                <label for="allowed_properties">
                                                    عدد العقارات المسموح بها
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="number"
                                                       id="allowed_properties"
                                                       name="allowed_properties"
                                                       class="form-control"
                                                       value="{{ old('allowed_properties', $plan->allowed_properties) }}"
                                                       min="-1"
                                                       placeholder="مثال: 10"
                                                       required>

                                                <small class="text-muted">
                                                    اكتب -1 للسماح بعدد غير محدود.
                                                </small>

                                                @error('allowed_properties')
                                                    <small class="text-danger d-block mt-1">
                                                        {{ $message }}
                                                    </small>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>

                                    {{-- العقارات المميزة --}}
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group mb-4">

                                                <label for="allowed_featured_properties">
                                                    عدد العقارات المميزة
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="number"
                                                       id="allowed_featured_properties"
                                                       name="allowed_featured_properties"
                                                       class="form-control"
                                                       value="{{ old('allowed_featured_properties', $plan->allowed_featured_properties) }}"
                                                       min="-1"
                                                       placeholder="مثال: 3"
                                                       required>

                                                <small class="text-muted">
                                                    عدد العقارات التي يمكن إبرازها في الموقع.
                                                </small>

                                                @error('allowed_featured_properties')
                                                    <small class="text-danger d-block mt-1">
                                                        {{ $message }}
                                                    </small>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>

                                    {{-- ملاحظة --}}
                                    <div class="alert alert-info mt-2">

                                        <i class="fas fa-info-circle ml-2"></i>

                                        <strong>ملاحظة:</strong>
                                        القيمة
                                        <strong>-1</strong>
                                        تعني أن المدة أو العدد غير محدود.

                                    </div>

                                    {{-- أزرار التحكم --}}
                                    <div class="mt-4">

                                        <button type="submit"
                                                class="btn btn-primary">

                                            <i class="fas fa-save ml-2"></i>
                                            حفظ التعديلات

                                        </button>

                                        <a href="{{ route('admin.plans.index') }}"
                                           class="btn btn-light mr-2">

                                            إلغاء

                                        </a>

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
