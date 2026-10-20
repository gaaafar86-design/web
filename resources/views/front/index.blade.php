@extends('front.layouts.master')

@section('content')
    <div class="slider" style="background-image: url('{{ asset('website-images/co.png') }}')">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="item">
                        <div class="text">
                            <h2>اعثر على عقار أحلامك</h2>
                            <p>اكتشف العقار المثالي الذي يناسب احتياجاتك.</p>
                        </div>
                        <div class="search-section">
                            <form action="{{ route('properties') }}" method="GET">
                                <div class="inner">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <input type="text" name="title" class="form-control" placeholder="Find Anything ...">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <select name="location_id" class="form-control select2">
                                                    <option value="">Select Location</option>
                                                    @foreach ($locations as $location)
                                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <select name="type_id" class="form-control select2">
                                                    <option value="">Select Type</option>
                                                    @foreach ($propertyTypes as $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="property">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>ملكيات</h2>
                        <p>اكتشف العقارات الرائعة التي ستحبها حتماً</p>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($randomProperties as $property)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        {{-- الضغط على أي مكان في الكرت يفتح صفحة تفاصيل العقار --}}
                        <div
                            class="item property-card"
                            role="link"
                            tabindex="0"
                            style="cursor: pointer;"
                            onclick="window.location.href='{{ route('property.detail', $property->slug) }}'"
                            onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); window.location.href='{{ route('property.detail', $property->slug) }}'; }"
                        >
                            <div class="photo">
                                <img
                                    class="main"
                                    src="{{ asset('property-images/' . $property->featured_photo) }}"
                                    alt="{{ $property->name }}"
                                >

                                <div class="top">
                                    <div class="{{ strtolower($property->purpose) === 'for sale' ? 'status-sale' : 'status-rent' }}">
                                        {{ $property->purpose }}
                                    </div>
                                </div>

                                <div class="price">
                                    @if (!is_null($property->price) && $property->price !== '')
                                        ${{ number_format((float) $property->price) }}
                                    @else
                                        السعر عند التواصل
                                    @endif
                                </div>

                                <div class="wishlist">
                                    @php
                                        $loggedIn = Auth::guard('web')->check();
                                        $hasWishlisted = false;
                                        $wishlistItem = null;

                                        if ($loggedIn) {
                                            $user = Auth::guard('web')->user()->load('wishlist');
                                            $hasWishlisted = $user->hasWishlisted($property);
                                            $wishlistItem = $user->wishlist->firstWhere('property_id', $property->id);
                                        }
                                    @endphp

                                    @if (!$loggedIn || !$hasWishlisted)
                                        <a
                                            href="{{ route('user.add.to.wishlist', $property) }}"
                                            onclick="event.stopPropagation();"
                                            aria-label="Add to wishlist"
                                            style="position: relative; z-index: 3;"
                                        >
                                            <i class="far fa-heart"></i>
                                        </a>
                                    @else
                                        <form
                                            action="{{ route('user.remove.from.wishlist', $wishlistItem) }}"
                                            method="POST"
                                            style="display: inline; position: relative; z-index: 3;"
                                            onclick="event.stopPropagation();"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                onclick="event.stopPropagation();"
                                                aria-label="Remove from wishlist"
                                                style="border: none; background: transparent;"
                                            >
                                                <i class="fas fa-heart" style="color: #d92228;"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div class="text">
                                <h3>
                                    <a
                                        href="{{ route('property.detail', $property->slug) }}"
                                        onclick="event.stopPropagation();"
                                    >
                                        {{ $property->name }}
                                    </a>
                                </h3>

                                <div class="detail">
                                    <div class="stat">
                                        <div class="i1">{{ $property->size }} مساحة</div>
                                        <div class="i2">{{ $property->bedroom }} عدد غرف النوم</div>
                                        <div class="i3">{{ $property->bathroom }} عدد الحمامات</div>
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
                                        <img
                                            class="agent-photo"
                                            src="{{ $property->agent->photo ? asset('user-images/' . $property->agent->photo) : asset('user-images/default.png') }}"
                                            alt="{{ $property->agent->name }}"
                                        >
                                        <a
                                            href="{{ route('agent.detail', $property->agent) }}"
                                            onclick="event.stopPropagation();"
                                        >
                                            {{ $property->agent->name }} ({{ $property->agent->company }})
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="why-choose" style="background-image: url('{{ asset('website-images/co1.jpg') }}')">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>لماذا تختارنا؟</h2>
                        <p>شرح أسباب كوننا الأفضل في مجال العقارات</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($whyChooseUsItems as $item)
                    <div class="col-md-4">
                        <div class="inner">
                            <div class="icon">
                                <i class="{{ $item->icon }}"></i>
                            </div>
                            <div class="text">
                                <h2>{{ $item->title }}</h2>
                                <p>{{ $item->text }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="agent">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>الوكلاء</h2>
                        <p>تعرف على وكلاء العقارات الخبراء لدينا من القائمة التالية</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($agents as $agent)
                    <div class="col-lg-3 col-md-3">
                        <div class="item">
                            <div class="photo">
                                <a href="{{ route('agent.detail', $agent) }}">
                                    <img
                                        src="{{ $agent->photo ? asset('user-images/' . $agent->photo) : asset('user-images/default.png') }}"
                                        alt="{{ $agent->name }}"
                                    >
                                </a>
                            </div>
                            <div class="text">
                                <h2>
                                    <a href="{{ route('agent.detail', $agent) }}">{{ $agent->name }}</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="location pb_40">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>المواقع</h2>
                        <p>اطلع على جميع خصائص المواقع المهمة</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($popularLocations as $location)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="item">
                            <div class="photo">
                                <a href="{{ route('location.detail', $location->slug) }}">
                                    <img src="{{ asset('location-images/' . $location->photo) }}" alt="{{ $location->name }}">
                                </a>
                            </div>
                            <div class="text">
                                <h2>
                                    <a href="{{ route('location.detail', $location->slug) }}">{{ $location->name }}</a>
                                </h2>
                                <h4>({{ $location->properties_count }} Properties)</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="testimonial" style="background-image: url({{ asset('website-images/co2.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="main-header">عملاؤنا السعداء</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-carousel owl-carousel">
                        @foreach ($testimonials as $testimonial)
                            <div class="item">
                                <div class="photo">
                                    <img src="{{ asset('user-images/' . $testimonial->photo) }}" alt="{{ $testimonial->name }}" />
                                </div>
                                <div class="text">
                                    <h4>{{ $testimonial->name }}</h4>
                                    <p>{{ $testimonial->designation }}</p>
                                </div>
                                <div class="description">
                                    <p>{{ $testimonial->comment }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="blog">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>آخر الأخبار</h2>
                        <p>اطلع على آخر أخبارنا من القسم التالي</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="item border rounded">
                            <div class="photo">
                                <img src="{{ asset('blog-images/' . $post->photo) }}" alt="{{ $post->title }}" />
                            </div>
                            <div class="text p_10">
                                <h2>
                                    <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                <div class="short-des" style="height: 150px">
                                    <p>{{ $post->short_description }}</p>
                                </div>
                                <div class="button">
                                    <a href="{{ route('post', $post->slug) }}" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
