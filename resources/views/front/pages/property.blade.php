@extends('front.layouts.master')

@section('content')
    <style>
        .property-details-page {
            direction: rtl;
            background: #f7f8fa;
            padding: 42px 0 70px;
        }

        .property-details-page .property-breadcrumb {
            color: #777;
            font-size: 14px;
            margin-bottom: 22px;
        }

        .property-details-page .property-breadcrumb a {
            color: #b18a4a;
            text-decoration: none;
        }

        .property-details-page .gallery-card,
        .property-details-page .info-card,
        .property-details-page .content-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(24, 32, 45, .07);
            border: 1px solid #edf0f3;
        }

        .property-details-page .main-photo-wrap {
            position: relative;
            overflow: hidden;
            border-radius: 18px 18px 0 0;
            background: #e9ecef;
        }

        .property-details-page .main-photo {
            display: block;
            width: 100%;
            height: 485px;
            object-fit: cover;
        }

        .property-details-page .photo-labels {
            position: absolute;
            top: 18px;
            right: 18px;
            left: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            pointer-events: none;
        }

        .property-details-page .purpose-label,
        .property-details-page .featured-label {
            display: inline-block;
            color: #fff;
            padding: 8px 15px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .13);
        }

        .property-details-page .purpose-label {
            background: #b18a4a;
        }

        .property-details-page .featured-label {
            background: #202b38;
        }

        .property-details-page .thumbnail-strip {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 14px;
            direction: rtl;
        }

        .property-details-page .thumbnail-button {
            flex: 0 0 86px;
            height: 70px;
            padding: 0;
            border: 2px solid transparent;
            border-radius: 10px;
            overflow: hidden;
            background: transparent;
            cursor: pointer;
        }

        .property-details-page .thumbnail-button.active {
            border-color: #b18a4a;
        }

        .property-details-page .thumbnail-button img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .property-details-page .property-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 18px;
        }

        .property-details-page .property-heading h1 {
            color: #202b38;
            font-size: 28px;
            line-height: 1.45;
            margin: 0 0 8px;
            font-weight: 800;
        }

        .property-details-page .location-line {
            color: #777;
            font-size: 14px;
        }

        .property-details-page .location-line i {
            color: #b18a4a;
            margin-left: 5px;
        }

        .property-details-page .price-box {
            color: #b18a4a;
            font-weight: 800;
            font-size: 25px;
            white-space: nowrap;
            text-align: left;
        }

        .property-details-page .price-box small {
            display: block;
            color: #888;
            font-size: 11px;
            font-weight: 400;
        }

        .property-details-page .info-card,
        .property-details-page .content-card {
            padding: 25px;
            margin-bottom: 22px;
        }

        .property-details-page .info-card h3,
        .property-details-page .content-card h3 {
            color: #202b38;
            font-size: 20px;
            font-weight: 800;
            margin: 0 0 20px;
        }

        .property-details-page .quick-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .property-details-page .quick-stat {
            background: #faf8f3;
            border-radius: 12px;
            padding: 14px 10px;
            text-align: center;
        }

        .property-details-page .quick-stat i {
            color: #b18a4a;
            display: block;
            margin-bottom: 7px;
            font-size: 18px;
        }

        .property-details-page .quick-stat strong {
            display: block;
            color: #202b38;
            font-size: 16px;
        }

        .property-details-page .quick-stat span {
            color: #888;
            font-size: 12px;
        }

        .property-details-page .property-meta {
            border-top: 1px solid #edf0f3;
            padding-top: 16px;
        }

        .property-details-page .meta-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            padding: 8px 0;
            color: #777;
            font-size: 14px;
        }

        .property-details-page .meta-row strong {
            color: #202b38;
            font-weight: 700;
        }

        .property-details-page .agent-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-top: 18px;
            border-top: 1px solid #edf0f3;
        }

        .property-details-page .agent-box img {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            object-fit: cover;
        }

        .property-details-page .agent-box a {
            color: #202b38;
            font-weight: 700;
            text-decoration: none;
        }

        .property-details-page .description {
            color: #666;
            line-height: 2;
            white-space: normal;
        }

        .property-details-page .amenities-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .property-details-page .amenity-item {
            background: #faf8f3;
            border: 1px solid #eee4d2;
            color: #695331;
            border-radius: 20px;
            padding: 7px 13px;
            font-size: 13px;
        }

        .property-details-page .similar-title {
            color: #202b38;
            font-size: 24px;
            font-weight: 800;
            margin: 35px 0 18px;
        }

        .property-details-page .similar-card {
            height: 100%;
            overflow: hidden;
            border-radius: 14px;
            background: #fff;
            border: 1px solid #edf0f3;
            box-shadow: 0 5px 18px rgba(24, 32, 45, .06);
        }

        .property-details-page .similar-card img {
            width: 100%;
            height: 170px;
            object-fit: cover;
        }

        .property-details-page .similar-card-body {
            padding: 14px;
        }

        .property-details-page .similar-card h5 {
            font-size: 16px;
            line-height: 1.5;
            margin: 0 0 8px;
        }

        .property-details-page .similar-card h5 a {
            color: #202b38;
            text-decoration: none;
        }

        .property-details-page .similar-price {
            color: #b18a4a;
            font-weight: 800;
        }

        @media (max-width: 767px) {
            .property-details-page .main-photo {
                height: 300px;
            }

            .property-details-page .property-heading {
                display: block;
            }

            .property-details-page .price-box {
                text-align: right;
                margin-top: 14px;
            }

            .property-details-page .property-heading h1 {
                font-size: 23px;
            }
        }
    </style>

    <main class="property-details-page">
        <div class="container">
            <div class="property-breadcrumb">
                <a href="{{ route('home') }}">الرئيسية</a>
                <span> / </span>
                <span>تفاصيل العقار</span>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="gallery-card">
                        <div class="main-photo-wrap">
                            <img
                                id="mainPropertyImage"
                                class="main-photo"
                                src="{{ asset('property-images/' . $property->featured_photo) }}"
                                alt="{{ $property->name }}"
                            >

                            <div class="photo-labels">
                                <span class="purpose-label">{{ $property->purpose }}</span>
                                @if ($property->is_featured)
                                    <span class="featured-label">مميز</span>
                                @endif
                            </div>
                        </div>

                        <div class="thumbnail-strip">
                            <button
                                type="button"
                                class="thumbnail-button active"
                                onclick="changePropertyImage(this, '{{ asset('property-images/' . $property->featured_photo) }}')"
                            >
                                <img src="{{ asset('property-images/' . $property->featured_photo) }}" alt="الصورة الرئيسية">
                            </button>

                            @if ($property->photos)
                                @foreach ($property->photos as $photo)
                                    <button
                                        type="button"
                                        class="thumbnail-button"
                                        onclick="changePropertyImage(this, '{{ asset('property-images/' . $photo->photo) }}')"
                                    >
                                        <img src="{{ asset('property-images/' . $photo->photo) }}" alt="صورة إضافية للعقار">
                                    </button>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="info-card">
                        <div class="property-heading">
                            <div>
                                <h1>{{ $property->name }}</h1>
                                <div class="location-line">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $property->address }}
                                </div>
                            </div>

                            <div class="price-box">
                                @if (!is_null($property->price) && $property->price !== '')
                                    ${{ number_format((float) $property->price) }}
                                    <small>بالدولار الأمريكي</small>
                                @else
                                    <span style="font-size: 16px;">السعر عند التواصل</span>
                                @endif
                            </div>
                        </div>

                        <div class="quick-stats">
                            <div class="quick-stat">
                                <i class="fas fa-ruler-combined"></i>
                                <strong>{{ $property->size }}</strong>
                                <span>المساحة</span>
                            </div>
                            <div class="quick-stat">
                                <i class="fas fa-bed"></i>
                                <strong>{{ $property->bedroom }}</strong>
                                <span>غرف النوم</span>
                            </div>
                            <div class="quick-stat">
                                <i class="fas fa-bath"></i>
                                <strong>{{ $property->bathroom }}</strong>
                                <span>الحمامات</span>
                            </div>
                            <div class="quick-stat">
                                <i class="fas fa-building"></i>
                                <strong>{{ $property->propertyType?->name ?? '-' }}</strong>
                                <span>النوع</span>
                            </div>
                        </div>

                        <div class="property-meta">
                            <div class="meta-row">
                                <span>الموقع</span>
                                <strong>{{ $property->location?->name ?? '-' }}</strong>
                            </div>
                            <div class="meta-row">
                                <span>الطابق</span>
                                <strong>{{ $property->floor ?? '-' }}</strong>
                            </div>
                            <div class="meta-row">
                                <span>الكراج</span>
                                <strong>{{ $property->garage ?? 0 }}</strong>
                            </div>
                            <div class="meta-row">
                                <span>الشرفة</span>
                                <strong>{{ $property->balcony ?? 0 }}</strong>
                            </div>
                        </div>

                        @if ($property->agent)
                            <div class="agent-box">
                                <img
                                    src="{{ $property->agent->photo ? asset('user-images/' . $property->agent->photo) : asset('user-images/default.png') }}"
                                    alt="{{ $property->agent->name }}"
                                >
                                <div>
                                    <small class="text-muted d-block">المعلن</small>
                                    <a href="{{ route('agent.detail', $property->agent) }}">
                                        {{ $property->agent->name }}
                                    </a>
                                    @if ($property->agent->company)
                                        <small class="text-muted d-block">{{ $property->agent->company }}</small>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    @if ($property->description)
                        <div class="content-card">
                            <h3>وصف العقار</h3>
                            <div class="description">{!! nl2br(e($property->description)) !!}</div>
                        </div>
                    @endif

                    @if ($property->amenities && $property->amenities->isNotEmpty())
                        <div class="content-card">
                            <h3>المزايا والخدمات</h3>
                            <div class="amenities-list">
                                @foreach ($property->amenities as $amenity)
                                    <span class="amenity-item">
                                        <i class="fas fa-check"></i>
                                        {{ $amenity->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if (isset($relatedProperties) && $relatedProperties->isNotEmpty())
                <h3 class="similar-title">عقارات مشابهة</h3>
                <div class="row">
                    @foreach ($relatedProperties as $related)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="similar-card">
                                <a href="{{ route('property.detail', $related->slug) }}">
                                    <img src="{{ asset('property-images/' . $related->featured_photo) }}" alt="{{ $related->name }}">
                                </a>
                                <div class="similar-card-body">
                                    <h5>
                                        <a href="{{ route('property.detail', $related->slug) }}">{{ $related->name }}</a>
                                    </h5>
                                    <div class="similar-price">
                                        @if (!is_null($related->price) && $related->price !== '')
                                            ${{ number_format((float) $related->price) }}
                                        @else
                                            السعر عند التواصل
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    <script>
        function changePropertyImage(button, imageUrl) {
            document.getElementById('mainPropertyImage').src = imageUrl;
            document.querySelectorAll('.thumbnail-button').forEach(function (item) {
                item.classList.remove('active');
            });
            button.classList.add('active');
        }
    </script>
@endsection
