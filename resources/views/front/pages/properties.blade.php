@extends('front.layouts.master')

@section('content')

    <div class="page-top"
         style="background-image: url('{{ asset('website-images/pppppp.png') }}')">

        <div class="bg"></div>

        <div class="container">

            <div class="row">

                <div class="col-md-12">

                    <h2>
                        العقارات
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="property-result">

        <div class="container">

            <div class="row">

                {{-- الفلاتر --}}
                <div class="col-lg-4 col-md-12">

                    <div class="property-filter">

                        <form action="{{ route('properties') }}"
                              method="GET">

                            {{-- البحث --}}
                            <div class="widget">

                                <div class="d-flex justify-content-between align-items-center">

                                    <h2>
                                        البحث عن عقار
                                    </h2>

                                    <a href="{{ request()->fullUrlWithQuery([
                                        'title' => null,
                                        'page' => null,
                                    ]) }}"
                                       style="color: #333;"
                                       aria-label="مسح البحث">

                                        <i class="fas fa-times fa-lg"></i>

                                    </a>

                                </div>

                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       placeholder="ابحث باسم العقار..."
                                       value="{{ request('title') }}">

                            </div>

                            {{-- المنطقة --}}
                            <div class="widget">

                                <div class="d-flex justify-content-between align-items-center">

                                    <h2>
                                        المنطقة
                                    </h2>

                                    <a href="{{ request()->fullUrlWithQuery([
                                        'location_id' => null,
                                        'page' => null,
                                    ]) }}"
                                       style="color: #333;"
                                       aria-label="مسح المنطقة">

                                        <i class="fas fa-times fa-lg"></i>

                                    </a>

                                </div>

                                <select name="location_id"
                                        class="form-control select2"
                                        style="width: 100% !important">

                                    <option value="">
                                        اختر المنطقة
                                    </option>

                                    @foreach ($locations as $location)

                                        <option value="{{ $location->id }}"
                                            @selected(
                                                (string) request('location_id')
                                                === (string) $location->id
                                            )>

                                            {{ $location->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            {{-- نوع العقار --}}
                            <div class="widget">

                                <div class="d-flex justify-content-between align-items-center">

                                    <h2>
                                        نوع العقار
                                    </h2>

                                    <a href="{{ request()->fullUrlWithQuery([
                                        'type_id' => null,
                                        'page' => null,
                                    ]) }}"
                                       style="color: #333;"
                                       aria-label="مسح نوع العقار">

                                        <i class="fas fa-times fa-lg"></i>

                                    </a>

                                </div>

                                <select name="type_id"
                                        class="form-control select2"
                                        style="width: 100% !important">

                                    <option value="">
                                        اختر نوع العقار
                                    </option>

                                    @foreach ($propertyTypes as $type)

                                        <option value="{{ $type->id }}"
                                            @selected(
                                                (string) request('type_id')
                                                === (string) $type->id
                                            )>

                                            {{ $type->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            {{-- حالة العقار --}}
                            <div class="widget">

                                <div class="d-flex justify-content-between align-items-center">

                                    <h2>
                                        حالة العقار
                                    </h2>

                                    <a href="{{ request()->fullUrlWithQuery([
                                        'purpose' => null,
                                        'page' => null,
                                    ]) }}"
                                       style="color: #333;"
                                       aria-label="مسح حالة العقار">

                                        <i class="fas fa-times fa-lg"></i>

                                    </a>

                                </div>

                                <select name="purpose"
                                        class="form-control select2"
                                        style="width: 100% !important">

                                    <option value="">
                                        اختر الحالة
                                    </option>

                                    <option value="Available"
                                        @selected(
                                            request('purpose') === 'Available'
                                        )>

                                        متوفر

                                    </option>

                                    <option value="Sold"
                                        @selected(
                                            request('purpose') === 'Sold'
                                        )>

                                        مباع

                                    </option>

                                </select>

                            </div>

                            {{-- المزايا --}}
                            <div class="widget">

                                <div class="d-flex justify-content-between align-items-center">

                                    <h2>
                                        المزايا والخدمات
                                    </h2>

                                    <a href="{{ request()->fullUrlWithQuery([
                                        'amenity' => null,
                                        'page' => null,
                                    ]) }}"
                                       style="color: #333;"
                                       aria-label="مسح المزايا">

                                        <i class="fas fa-times fa-lg"></i>

                                    </a>

                                </div>

                                <select name="amenity[]"
                                        class="form-control select2"
                                        multiple
                                        data-placeholder="اختر المزايا"
                                        style="width: 100% !important">

                                    @foreach ($amenities as $amenity)

                                        <option value="{{ $amenity->id }}"
                                            @selected(
                                                in_array(
                                                    $amenity->id,
                                                    (array) request('amenity', [])
                                                )
                                            )>

                                            {{ $amenity->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                           {{-- غرف النوم --}}
<div class="widget">

    <div class="d-flex justify-content-between align-items-center">

        <h2>
            غرف النوم
        </h2>

        <a href="{{ request()->fullUrlWithQuery([
            'bedroom' => null,
            'page' => null,
        ]) }}"
           style="color: #333;"
           aria-label="مسح غرف النوم">

            <i class="fas fa-times fa-lg"></i>

        </a>

    </div>

    <select name="bedroom"
            class="form-control select2"
            style="width: 100% !important">

        <option value="">
            اختر العدد
        </option>

        @for ($i = 1; $i <= 10; $i++)

            <option value="{{ $i }}"
                @selected((string) request('bedroom') === (string) $i)>

                {{ $i }}

            </option>

        @endfor

    </select>

</div>

{{-- الحمامات --}}
<div class="widget">

    <div class="d-flex justify-content-between align-items-center">

        <h2>
            الحمامات
        </h2>

        <a href="{{ request()->fullUrlWithQuery([
            'bathroom' => null,
            'page' => null,
        ]) }}"
           style="color: #333;"
           aria-label="مسح الحمامات">

            <i class="fas fa-times fa-lg"></i>

        </a>

    </div>

    <select name="bathroom"
            class="form-control select2"
            style="width: 100% !important">

        <option value="">
            اختر العدد
        </option>

        @for ($i = 1; $i <= 10; $i++)

            <option value="{{ $i }}"
                @selected((string) request('bathroom') === (string) $i)>

                {{ $i }}

            </option>

        @endfor

    </select>

</div>

                            {{-- العقار المميز --}}
                            <div class="widget">

                                <div class="d-flex justify-content-between align-items-center">

                                    <h2>
                                        عقار مميز
                                    </h2>

                                    <a href="{{ request()->fullUrlWithQuery([
                                        'is_featured' => null,
                                        'page' => null,
                                    ]) }}"
                                       style="color: #333;"
                                       aria-label="مسح فلتر العقار المميز">

                                        <i class="fas fa-times fa-lg"></i>

                                    </a>

                                </div>

                                <select name="is_featured"
                                        class="form-control select2"
                                        style="width: 100% !important">

                                    <option value="">
                                        اختر
                                    </option>

                                    <option value="1"
                                        @selected(
                                            (string) request('is_featured')
                                            === '1'
                                        )>

                                        نعم

                                    </option>

                                    <option value="0"
                                        @selected(
                                            (string) request('is_featured')
                                            === '0'
                                        )>

                                        لا

                                    </option>

                                </select>

                            </div>

                            {{-- السعر --}}
                            <div class="widget">

                                <div class="d-flex justify-content-between align-items-center">

                                    <h2>
                                        السعر بالدولار
                                    </h2>

                                    <a href="{{ request()->fullUrlWithQuery([
                                        'min_price' => null,
                                        'max_price' => null,
                                        'page' => null,
                                    ]) }}"
                                       style="color: #333;"
                                       aria-label="مسح فلتر السعر">

                                        <i class="fas fa-times fa-lg"></i>

                                    </a>

                                </div>

                                <div class="row">

                                    <div class="col-6">

                                        <label for="minPrice">
                                            من
                                        </label>

                                        <input type="number"
                                               id="minPrice"
                                               name="min_price"
                                               class="form-control"
                                               min="0"
                                               step="100"
                                               placeholder="بدون حد أدنى"
                                               value="{{ request('min_price') }}">

                                    </div>

                                    <div class="col-6">

                                        <label for="maxPrice">
                                            إلى
                                        </label>

                                        <input type="number"
                                               id="maxPrice"
                                               name="max_price"
                                               class="form-control"
                                               min="0"
                                               step="100"
                                               placeholder="بدون حد أعلى"
                                               value="{{ request('max_price') }}">

                                    </div>

                                </div>

                                <small class="text-muted d-block mt-2">
                                    اترك الحقول فارغة لعرض العقارات بكل الأسعار.
                                </small>

                            </div>

                            {{-- زر البحث --}}
                            <div class="filter-button d-flex gap-2">

    {{-- تطبيق الفلتر --}}
    <button type="submit"
            class="btn btn-primary">

        <i class="fas fa-search"></i>
        تطبيق الفلتر

    </button>

    {{-- إزالة جميع الفلاتر --}}
    <a href="{{ route('properties') }}"
       class="btn btn-outline-danger">

        <i class="fas fa-times"></i>
        إزالة جميع الفلاتر

    </a>

</div>


                        </form>

                    </div>

                </div>

                {{-- العقارات --}}
                <div class="col-lg-8 col-md-12">

                    <div class="property">

                        <div class="container">

                            <div class="row">

                                @if ($properties->isNotEmpty())

                                    @foreach ($properties as $property)

                                        <div class="col-lg-6 col-md-6 col-sm-12">

                                            <div class="item">

                                                <div class="photo">

                                                    <img class="main"
                                                         src="{{ asset(
                                                             'property-images/' .
                                                             $property->featured_photo
                                                         ) }}"
                                                         alt="{{ $property->name }}">

                                                    <div class="top">

                                                        <div class="{{
                                                            $property->purpose === 'Available'
                                                                ? 'status-sale'
                                                                : 'status-rent'
                                                        }}">

                                                            {{ $property->purpose === 'Available'
                                                                ? 'متوفر'
                                                                : 'مباع'
                                                            }}

                                                        </div>

                                                        @if ($property->is_featured)

                                                            <div class="featured">
                                                                مميز
                                                            </div>

                                                        @endif

                                                    </div>

                                                    <div class="price">

                                                        @if (!is_null($property->price)
                                                            && $property->price !== '')

                                                            ${{ number_format(
                                                                (float) $property->price
                                                            ) }}

                                                        @else

                                                            السعر عند التواصل

                                                        @endif

                                                    </div>

                                                    <div class="wishlist">

                                                        @php
                                                            $loggedIn =
                                                                Auth::guard('web')->check();

                                                            $hasWishlisted = false;
                                                            $wishlistItem = null;

                                                            if ($loggedIn) {
                                                                $user = Auth::guard('web')
                                                                    ->user()
                                                                    ->load('wishlist');

                                                                $hasWishlisted =
                                                                    $user->hasWishlisted(
                                                                        $property
                                                                    );

                                                                $wishlistItem =
                                                                    $user->wishlist
                                                                        ->firstWhere(
                                                                            'property_id',
                                                                            $property->id
                                                                        );
                                                            }
                                                        @endphp

                                                        @if (!$loggedIn || !$hasWishlisted)

                                                            <a href="{{ route(
                                                                'user.add.to.wishlist',
                                                                $property
                                                            ) }}"
                                                               aria-label="إضافة إلى المفضلة">

                                                                <i class="far fa-heart"></i>

                                                            </a>

                                                        @else

                                                            <form action="{{ route(
                                                                'user.remove.from.wishlist',
                                                                $wishlistItem
                                                            ) }}"
                                                                  method="POST"
                                                                  style="display: inline;">

                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit"
                                                                        style="
                                                                            border: none;
                                                                            background: transparent;
                                                                        "
                                                                        aria-label="إزالة من المفضلة">

                                                                    <i class="fas fa-heart"
                                                                       style="color: #d92228;">
                                                                    </i>

                                                                </button>

                                                            </form>

                                                        @endif

                                                    </div>

                                                </div>

                                                <div class="text">

                                                    <h3>

                                                        <a href="{{ route(
                                                            'property.detail',
                                                            $property->slug
                                                        ) }}">

                                                            {{ $property->name }}

                                                        </a>

                                                    </h3>

                                                    <div class="detail">

                                                        <div class="stat">

                                                            <div class="i1">
                                                                {{ $property->size }}
                                                                مساحة
                                                            </div>

                                                            <div class="i2">
                                                                {{ $property->bedroom }}
                                                                غرف نوم
                                                            </div>

                                                            <div class="i3">
                                                                {{ $property->bathroom }}
                                                                حمامات
                                                            </div>

                                                        </div>

                                                        <div class="address">

                                                            <i class="fas fa-map-marker-alt"></i>
                                                            {{ $property->address }}

                                                        </div>

                                                        <div class="type-location">

                                                            <div class="i1">

                                                                <i class="fas fa-edit"></i>
                                                                {{ $property->propertyType->name }}

                                                            </div>

                                                            <div class="i2">

                                                                <i class="fas fa-location-arrow"></i>
                                                                {{ $property->location->name }}

                                                            </div>

                                                        </div>

                                                        <div class="agent-section">

                                                            <img class="agent-photo"
                                                                 src="{{ $property->agent->photo
                                                                     ? asset(
                                                                         'user-images/' .
                                                                         $property->agent->photo
                                                                     )
                                                                     : asset(
                                                                         'user-images/default.png'
                                                                     ) }}"
                                                                 alt="{{ $property->agent->name }}">

                                                            <a href="{{ route(
                                                                'agent.detail',
                                                                $property->agent
                                                            ) }}">

                                                                {{ $property->agent->name }}

                                                                @if ($property->agent->company)
                                                                    ({{ $property->agent->company }})
                                                                @endif

                                                            </a>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                    <div class="col-12 mt_30">

                                        {{
                                            $properties
                                                ->appends(request()->query())
                                                ->links()
                                        }}

                                    </div>

                                @else

                                    <div class="col-12">

                                        <h4 class="text-danger mt_200 mb_200"
                                            style="
                                                text-align: center;
                                                font-weight: bold;
                                            ">

                                            لا توجد عقارات مطابقة لخيارات البحث.

                                        </h4>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
