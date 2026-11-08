@extends('admin.layouts.master')

@section('content')

    <style>
        .property-show-page {
            direction: rtl;
            text-align: right;
        }

        .property-show-page .section-header {
            direction: rtl;
        }

        .property-show-page .form-label {
            display: block;
            font-weight: 600;
            text-align: right;
        }

        .property-show-page .form-control {
            direction: rtl;
            text-align: right;
        }

        .property-show-page textarea {
            resize: vertical;
        }

        .property-featured-image {
            width: 300px;
            max-width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
        }

        .property-gallery-image {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .property-video-image {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .property-show-page .form-check {
            direction: rtl;
            text-align: right;
        }

        .property-show-page .form-check-input {
            float: right;
            margin-left: 8px;
            margin-right: 0;
        }
    </style>

    <x-admin_navbar />
    <x-admin_sidebar />

    <div class="main-content property-show-page">

        <section class="section">

            <div class="section-header d-flex justify-content-between align-items-center">

                <h1>
                    تفاصيل العقار
                </h1>

                <div>

                    <a href="{{ route('admin.properties.index') }}"
                       class="btn btn-primary">

                        <i class="fas fa-arrow-right ms-2"></i>
                        العودة إلى العقارات

                    </a>

                </div>

            </div>

            <div class="section-body mb_50">

                <div class="row">

                    <div class="col-lg-9 col-md-12">

                        {{-- الصورة الرئيسية --}}
                        <div class="col-md-12 mb-4">

                            <label class="form-label">
                                الصورة الرئيسية
                            </label>

                            <div class="form-group">

                                <a href="{{ asset(
                                    'property-images/' .
                                    $property->featured_photo
                                ) }}"
                                   class="magnific">

                                    <img src="{{ asset(
                                        'property-images/' .
                                        $property->featured_photo
                                    ) }}"
                                         alt="صورة العقار"
                                         class="property-featured-image">

                                </a>

                            </div>

                        </div>

                        {{-- اسم العقار --}}
                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    اسم العقار
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $property->name }}"
                                       disabled>

                            </div>

                            {{-- السعر --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    السعر
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="${{ number_format($property->price) }}"
                                       disabled>

                            </div>

                        </div>

                        {{-- الوصف --}}
                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                وصف العقار
                            </label>

                            <textarea class="form-control h_200"
                                      disabled>{{ $property->description }}</textarea>

                        </div>

                        <div class="row">

                            {{-- المنطقة --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    المنطقة
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $property->location->name ?? '-' }}"
                                       disabled>

                            </div>

                            {{-- نوع العقار --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    نوع العقار
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $property->propertyType->name ?? '-' }}"
                                       disabled>

                            </div>

                            {{-- حالة العقار --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    حالة العقار
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $property->purpose === 'Available'
                                           ? 'متوفر'
                                           : 'غير متوفر' }}"
                                       disabled>

                            </div>

                            {{-- غرف النوم --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    عدد غرف النوم
                                </label>

                                <input type="number"
                                       class="form-control"
                                       value="{{ $property->bedroom }}"
                                       disabled>

                            </div>

                            {{-- الحمامات --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    عدد الحمامات
                                </label>

                                <input type="number"
                                       class="form-control"
                                       value="{{ $property->bathroom }}"
                                       disabled>

                            </div>

                            {{-- المساحة --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    المساحة
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ number_format($property->size) }}"
                                       disabled>

                            </div>

                            {{-- الطابق --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    الطابق
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ number_format($property->floor) }}"
                                       disabled>

                            </div>

                            {{-- الكراج --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    عدد مواقف السيارات
                                </label>

                                <input type="number"
                                       class="form-control"
                                       value="{{ $property->garage }}"
                                       disabled>

                            </div>

                            {{-- الشرفة --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    عدد الشرفات
                                </label>

                                <input type="number"
                                       class="form-control"
                                       value="{{ $property->balcony }}"
                                       disabled>

                            </div>

                            {{-- العنوان --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    العنوان
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $property->address }}"
                                       disabled>

                            </div>

                            {{-- سنة البناء --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    سنة البناء
                                </label>

                                <input type="number"
                                       class="form-control"
                                       value="{{ $property->built_year }}"
                                       disabled>

                            </div>

                            {{-- عقار مميز --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    عقار مميز؟
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $property->is_featured
                                           ? 'نعم'
                                           : 'لا' }}"
                                       disabled>

                            </div>

                            {{-- حالة النشر --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    حالة النشر
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $property->status
                                           ? 'منشور'
                                           : 'قيد المراجعة' }}"
                                       disabled>

                            </div>

                        </div>

                        {{-- خريطة الموقع --}}
                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                خريطة الموقع
                            </label>

                            <textarea class="form-control h_200"
                                      disabled>{{ $property->map }}</textarea>

                        </div>

                        {{-- المزايا والخدمات --}}
                        @if ($property->amenities->isNotEmpty())

                            <div class="col-md-12 mb-4">

                                <label class="form-label">
                                    المزايا والخدمات
                                </label>

                                <div class="row">

                                    @foreach ($property->amenities as $amenity)

                                        <div class="col-md-3 mb-2">

                                            <div class="form-check">

                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       checked
                                                       disabled>

                                                <label class="form-check-label">
                                                    {{ $amenity->name }}
                                                </label>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        @endif

                        {{-- معرض الصور --}}
                        @if ($propertyPhotos->isNotEmpty())

                            <h5 class="mt-4">
                                معرض الصور
                            </h5>

                            <div class="photo-all">

                                <div class="row">

                                    @foreach ($propertyPhotos as $photo)

                                        <div class="col-md-6 col-lg-3 mb-3">

                                            <div class="item item-delete">

                                                <a href="{{ asset(
                                                    'property-images/' .
                                                    $photo->photo
                                                ) }}"
                                                   class="magnific">

                                                    <img src="{{ asset(
                                                        'property-images/' .
                                                        $photo->photo
                                                    ) }}"
                                                         alt="صورة العقار"
                                                         class="property-gallery-image">

                                                </a>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        @endif

                        {{-- معرض الفيديو --}}
                        @if ($propertyVideos->isNotEmpty())

                            <h5 class="mt-4">
                                معرض الفيديو
                            </h5>

                            @foreach ($propertyVideos as $video)

                                <div class="video-all mb-3">

                                    <div class="row">

                                        <div class="col-md-6 col-lg-3">

                                            <div class="item item-delete">

                                                <a class="video-button"
                                                   href="https://www.youtube.com/watch?v={{ $video->video }}">

                                                    <img src="https://img.youtube.com/vi/{{ $video->video }}/hqdefault.jpg"
                                                         alt="فيديو العقار"
                                                         class="property-video-image">

                                                </a>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        @endif

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
