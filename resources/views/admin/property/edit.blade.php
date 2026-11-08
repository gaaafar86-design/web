@extends('admin.layouts.master')

@section('content')

    <x-admin_navbar />
    <x-admin_sidebar />

    <div class="main-content">

        <section class="section">

            <div class="section-header d-flex justify-content-between align-items-center">

                <h1>
                    تعديل العقار
                </h1>

                <a href="{{ route('admin.properties.index') }}"
                   class="btn btn-primary">

                    <i class="fas fa-arrow-left me-2"></i>
                    رجوع

                </a>

            </div>

            <div class="section-body mb_50">

                <div class="col-lg-9 col-md-12">

                    {{-- الصورة الرئيسية الحالية --}}
                    <div class="row">

                        <div class="col-md-12 mb-4">

                            <label class="form-label">
                                الصورة الرئيسية الحالية
                            </label>

                            <div class="form-group">

                                <img src="{{ asset(
                                    'property-images/' .
                                    $property->featured_photo
                                ) }}"
                                     alt="صورة العقار"
                                     class="user-photo w_300">

                            </div>

                        </div>

                    </div>

                    <form action="{{ route(
                        'admin.properties.update',
                        $property
                    ) }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        {{-- تغيير الصورة --}}
                        <div class="row">

                            <div class="col-md-12 mb-3">

                                <label class="form-label">
                                    تغيير الصورة الرئيسية
                                </label>

                                <input type="file"
                                       name="featured_photo"
                                       class="form-control"
                                       accept="image/*">

                                <small class="form-text text-muted">
                                    اترك الحقل فارغاً للاحتفاظ بالصورة الحالية.
                                </small>

                                @error('featured_photo')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                        {{-- الاسم والسعر --}}
                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    اسم العقار *
                                </label>

                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ old(
                                           'name',
                                           $property->name
                                       ) }}">

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
                                       value="{{ old(
                                           'price',
                                           number_format($property->price)
                                       ) }}">

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
                                          class="form-control h_200">{{ old(
                                              'description',
                                              $property->description
                                          ) }}</textarea>

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

                                    @foreach ($locations as $location)

                                        <option value="{{ $location->id }}"
                                            @selected(
                                                old(
                                                    'location_id',
                                                    $property->location_id
                                                ) == $location->id
                                            )>

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

                                    @foreach ($propertyTypes as $propertyType)

                                        <option value="{{ $propertyType->id }}"
                                            @selected(
                                                old(
                                                    'type_id',
                                                    $property->property_type_id
                                                ) == $propertyType->id
                                            )>

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

                                    <option value="Available"
                                        @selected(
                                            old(
                                                'purpose',
                                                $property->purpose
                                            ) === 'Available'
                                        )>

                                        متوفر

                                    </option>

                                    <option value="Sold"
                                        @selected(
                                            old(
                                                'purpose',
                                                $property->purpose
                                            ) === 'Sold'
                                        )>

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
                                            @selected(
                                                old(
                                                    'bedroom',
                                                    $property->bedroom
                                                ) == $i
                                            )>

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
                                            @selected(
                                                old(
                                                    'bathroom',
                                                    $property->bathroom
                                                ) == $i
                                            )>

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
                                       value="{{ old(
                                           'size',
                                           number_format($property->size)
                                       ) }}">

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
                                       value="{{ old(
                                           'floor',
                                           $property->floor !== null
                                               ? number_format($property->floor)
                                               : ''
                                       ) }}">

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
                                       class="form-control"
                                       value="{{ old(
                                           'garage',
                                           $property->garage
                                       ) }}">

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
                                       class="form-control"
                                       value="{{ old(
                                           'balcony',
                                           $property->balcony
                                       ) }}">

                                @error('balcony')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                        {{-- العنوان والسنة والمميز --}}
                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    العنوان *
                                </label>

                                <input type="text"
                                       name="address"
                                       class="form-control"
                                       value="{{ old(
                                           'address',
                                           $property->address
                                       ) }}">

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
                                       value="{{ old(
                                           'year',
                                           $property->built_year
                                       ) }}">

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

                                    <option value="1"
                                        @selected(
                                            old(
                                                'is_featured',
                                                $property->is_featured
                                            ) == 1
                                        )>

                                        نعم

                                    </option>

                                    <option value="0"
                                        @selected(
                                            old(
                                                'is_featured',
                                                $property->is_featured
                                            ) == 0
                                        )>

                                        لا

                                    </option>

                                </select>

                            </div>

                        </div>

                        {{-- حالة النشر والوكيل --}}
                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    حالة النشر *
                                </label>

                                <select name="status"
                                        class="form-control">

                                    <option value="1"
                                        @selected(
                                            old(
                                                'status',
                                                $property->status
                                            ) == 1
                                        )>

                                        منشور ويظهر للزوار

                                    </option>

                                    <option value="0"
                                        @selected(
                                            old(
                                                'status',
                                                $property->status
                                            ) == 0
                                        )>

                                        غير منشور

                                    </option>

                                </select>

                            </div>

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    الوكيل *
                                </label>

                                <select name="agent_id"
                                        class="form-control select2">

                                    @foreach ($agents as $agent)

                                        <option value="{{ $agent->id }}"
                                            @selected(
                                                old(
                                                    'agent_id',
                                                    $property->agent_id
                                                ) == $agent->id
                                            )>

                                            {{ $agent->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                        {{-- الخريطة --}}
                        <div class="row">

                            <div class="col-md-12 mb-3">

                                <label class="form-label">
                                    خريطة الموقع
                                </label>

                                <textarea name="map"
                                          class="form-control h_200">{{ old(
                                              'map',
                                              $property->map
                                          ) }}</textarea>

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
                                                           old(
                                                               'amenities',
                                                               $property->amenities
                                                                   ->pluck('id')
                                                                   ->toArray()
                                                           )
                                                       )
                                                   )>

                                            <label class="form-check-label"
                                                   for="amenity-{{ $amenity->id }}">

                                                {{ $amenity->name }}

                                            </label>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                            @error('amenities')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                        {{-- زر الحفظ --}}
                        <div class="row">

                            <div class="col-md-12"
                                 style="margin: 10px 0;">

                                <button type="submit"
                                        class="btn btn-primary">

                                    حفظ التعديلات

                                </button>

                            </div>

                        </div>

                    </form>

                    {{-- الصور الإضافية --}}
                    @if ($propertyPhotos->isNotEmpty())

                        <div class="row mt-4">

                            <div class="col-md-12">

                                <h4 class="mb-3">
                                    الصور الإضافية الحالية
                                </h4>

                                <div class="row g-3">

                                    @foreach ($propertyPhotos as $photo)

                                        <div class="col-md-6 col-lg-3">

                                            <div class="card shadow-sm">

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
                                                         class="card-img-top">

                                                    <div class="position-absolute top-0 end-0 p-2">

                                                        <i class="fas fa-search-plus text-white bg-dark rounded-circle p-2"></i>

                                                    </div>

                                                </a>

                                                <div class="card-body text-center">

                                                    <form action="{{ route(
                                                        'admin.properties.photo.destroy',
                                                        $photo
                                                    ) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('هل أنت متأكد من حذف هذه الصورة؟');">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="btn btn-sm btn-danger w-100">

                                                            حذف الصورة

                                                        </button>

                                                    </form>

                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    @endif

                    {{-- الفيديوهات الحالية --}}
                    @if ($propertyVideos->isNotEmpty())

                        <div class="row mt-4">

                            <div class="col-md-12">

                                <h4 class="mb-3">
                                    الفيديوهات الحالية
                                </h4>

                                <div class="row g-3">

                                    @foreach ($propertyVideos as $video)

                                        <div class="col-md-6 col-lg-3">

                                            <div class="card shadow-sm">

                                                <a href="https://www.youtube.com/watch?v={{ $video->video }}"
                                                   target="_blank"
                                                   class="position-relative d-block">

                                                    <img src="https://img.youtube.com/vi/{{ $video->video }}/hqdefault.jpg"
                                                         alt="فيديو العقار"
                                                         class="card-img-top">

                                                    <div class="position-absolute top-50 start-50 translate-middle">

                                                        <i class="far fa-play-circle fa-2x text-white bg-dark rounded-circle p-2"></i>

                                                    </div>

                                                </a>

                                                <div class="card-body text-center">

                                                    <form action="{{ route(
                                                        'admin.properties.video.destroy',
                                                        $video
                                                    ) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا الفيديو؟');">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="btn btn-sm btn-danger w-100">

                                                            حذف الفيديو

                                                        </button>

                                                    </form>

                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </section>

    </div>

@endsection
