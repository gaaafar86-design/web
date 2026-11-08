@extends('admin.layouts.master')

@section('content')

    <x-admin_navbar />
    <x-admin_sidebar />

    <div class="main-content">

        <section class="section">

            <div class="section-header d-flex justify-content-between align-items-center">

                <h1>
                    إضافة عقار
                </h1>

                <a href="{{ route('admin.properties.index') }}"
                   class="btn btn-primary">

                    <i class="fas fa-arrow-left me-2"></i>
                    رجوع

                </a>

            </div>

            <div class="section-body mb_50">

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                @if (session('error'))

                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>

                @endif

                <div class="col-lg-9 col-md-12">

                    <form action="{{ route('admin.properties.store') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        {{-- الوكيل والصورة الرئيسية --}}
                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    الوكيل *
                                </label>

                                <select name="agent_id"
                                        class="form-control select2">

                                    <option value="">
                                        -- اختر الوكيل --
                                    </option>

                                    @foreach ($agents as $agent)

                                        <option value="{{ $agent->id }}"
                                            @selected(old('agent_id') == $agent->id)>

                                            {{ $agent->name }}
                                            ({{ $agent->phone }})

                                        </option>

                                    @endforeach

                                </select>

                                @error('agent_id')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    الصورة الرئيسية *
                                </label>

                                <input type="file"
                                       name="featured_photo"
                                       class="form-control"
                                       accept="image/*">

                                <small class="form-text text-muted">
                                    الصورة الرئيسية للعقار
                                </small>

                                @error('featured_photo')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                        {{-- الصور الإضافية --}}
                        <div class="row">

                            <div class="col-md-12 mb-3">

                                <label class="form-label">

                                    صور إضافية

                                    <small class="text-muted">
                                        (اختياري)
                                    </small>

                                </label>

                                <input type="file"
                                       name="photos[]"
                                       id="additionalPhotos"
                                       class="form-control"
                                       accept="image/*"
                                       multiple>

                                <small class="form-text text-muted">
                                    يمكنك اختيار عدة صور للعقار أو ترك الحقل فارغاً.
                                </small>

                                @error('photos')
                                    <small class="text-danger d-block">
                                        {{ $message }}
                                    </small>
                                @enderror

                                @error('photos.*')
                                    <small class="text-danger d-block">
                                        {{ $message }}
                                    </small>
                                @enderror

                                <div id="additionalPhotosPreview"
                                     class="row mt-3">
                                </div>

                            </div>

                        </div>

                        {{-- اسم العقار والسعر --}}
                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    اسم العقار *
                                </label>

                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name') }}">

                                @error('name')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    السعر بالدولار *
                                </label>

                                <input type="text"
                                       name="price"
                                       class="form-control"
                                       value="{{ old('price') }}">

                                @error('price')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                        {{-- الوصف --}}
                        <div class="row">

                            <div class="col-md-12 mb-3">

                                <label class="form-label">
                                    وصف العقار
                                </label>

                                <textarea name="description"
                                          class="form-control h_200">{{ old('description') }}</textarea>

                                @error('description')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                        {{-- المنطقة والنوع والحالة --}}
                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    المنطقة *
                                </label>

                                <select name="location_id"
                                        class="form-control select2">

                                    <option value="">
                                        -- اختر المنطقة --
                                    </option>

                                    @foreach ($locations as $location)

                                        <option value="{{ $location->id }}"
                                            @selected(old('location_id') == $location->id)>

                                            {{ $location->name }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('location_id')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    نوع العقار *
                                </label>

                                <select name="type_id"
                                        class="form-control select2">

                                    <option value="">
                                        -- اختر نوع العقار --
                                    </option>

                                    @foreach ($propertyTypes as $propertyType)

                                        <option value="{{ $propertyType->id }}"
                                            @selected(old('type_id') == $propertyType->id)>

                                            {{ $propertyType->name }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('type_id')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    حالة العقار *
                                </label>

                                <select name="purpose"
                                        class="form-control"
                                        required>

                                    <option value="">
                                        اختر حالة العقار
                                    </option>

                                    <option value="Available"
                                        {{ old('purpose') == 'Available'
                                            ? 'selected'
                                            : '' }}>

                                        متوفر

                                    </option>

                                    <option value="Sold"
                                        {{ old('purpose') == 'Sold'
                                            ? 'selected'
                                            : '' }}>

                                        مباع

                                    </option>

                                </select>

                                @error('purpose')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                        {{-- الغرف والحمامات والمساحة --}}
                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    غرف النوم *
                                </label>

                                <select name="bedroom"
                                        class="form-control select2">

                                    @for ($i = 0; $i <= 10; $i++)

                                        <option value="{{ $i }}"
                                            @selected(old('bedroom', 1) == $i)>

                                            {{ $i }}

                                        </option>

                                    @endfor

                                </select>

                                @error('bedroom')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    الحمامات *
                                </label>

                                <select name="bathroom"
                                        class="form-control select2">

                                    @for ($i = 0; $i <= 10; $i++)

                                        <option value="{{ $i }}"
                                            @selected(old('bathroom', 1) == $i)>

                                            {{ $i }}

                                        </option>

                                    @endfor

                                </select>

                                @error('bathroom')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    المساحة *
                                </label>

                                <input type="text"
                                       name="size"
                                       class="form-control"
                                       value="{{ old('size') }}">

                                @error('size')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                        {{-- الطابق والكراج والشرفة --}}
                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    الطابق
                                </label>

                                <input type="text"
                                       name="floor"
                                       class="form-control"
                                       value="{{ old('floor') }}">

                                @error('floor')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    الكراج
                                </label>

                                <input type="number"
                                       name="garage"
                                       min="0"
                                       class="form-control"
                                       value="{{ old('garage') }}">

                                @error('garage')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    الشرفة
                                </label>

                                <input type="number"
                                       name="balcony"
                                       min="0"
                                       class="form-control"
                                       value="{{ old('balcony') }}">

                                @error('balcony')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                        {{-- العنوان وسنة البناء والعقار المميز --}}
                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    العنوان *
                                </label>

                                <input type="text"
                                       name="address"
                                       class="form-control"
                                       value="{{ old('address') }}">

                                @error('address')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    سنة البناء
                                </label>

                                <input type="number"
                                       name="year"
                                       class="form-control"
                                       value="{{ old('year') }}">

                                @error('year')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    عقار مميز؟
                                </label>

                                <select name="is_featured"
                                        class="form-control">

                                    <option value="0"
                                        @selected(old('is_featured', 0) == 0)>

                                        لا

                                    </option>

                                    <option value="1"
                                        @selected(old('is_featured') == 1)>

                                        نعم

                                    </option>

                                </select>

                                @error('is_featured')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                        {{-- حالة النشر --}}
                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    حالة النشر *
                                </label>

                                <select name="status"
                                        class="form-control">

                                    <option value="1"
                                        @selected(old('status', 1) == 1)>

                                        منشور ويظهر للزوار

                                    </option>

                                    <option value="0"
                                        @selected(old('status') === '0')>

                                        غير منشور

                                    </option>

                                </select>

                                @error('status')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                        {{-- الخريطة --}}
                        <div class="row">

                            <div class="col-md-12 mb-3">

                                <label class="form-label">
                                    خريطة الموقع
                                </label>

                                <textarea name="map"
                                          class="form-control h_200">{{ old('map') }}</textarea>

                                @error('map')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                        {{-- المزايا والخدمات --}}
                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                المزايا والخدمات
                            </label>

                            <div class="row">

                                @foreach ($amenities as $amenity)

                                    <div class="col-md-3">

                                        <div class="form-check">

                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="amenities[]"
                                                   value="{{ $amenity->id }}"
                                                   id="amenity-{{ $amenity->id }}"
                                                   @checked(
                                                       in_array(
                                                           $amenity->id,
                                                           old('amenities', [])
                                                       )
                                                   )>

                                            <label class="form-check-label"
                                                   for="amenity-{{ $amenity->id }}">

                                                {{ $amenity->name }}

                                            </label>

                                        </div>

                                    </div>

                                @endforeach

                                @error('amenities')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                        {{-- زر الحفظ --}}
                        <div class="row">

                            <div class="col-md-12"
                                 style="margin: 10px 0;">

                                <button type="submit"
                                        class="btn btn-primary">

                                    إنشاء العقار

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </section>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('additionalPhotos');
            const preview = document.getElementById('additionalPhotosPreview');

            if (!input || !preview) {
                return;
            }

            input.addEventListener('change', function () {
                preview.innerHTML = '';

                Array.from(input.files).forEach(function (file) {
                    if (!file.type.startsWith('image/')) {
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function (event) {
                        const column = document.createElement('div');

                        column.className =
                            'col-6 col-md-3 mb-3';

                        column.innerHTML = `
                            <img
                                src="${event.target.result}"
                                alt="معاينة الصورة"
                                class="img-thumbnail"
                                style="
                                    width: 100%;
                                    height: 120px;
                                    object-fit: cover;
                                "
                            >
                        `;

                        preview.appendChild(column);
                    };

                    reader.readAsDataURL(file);
                });
            });
        });
    </script>

@endsection
