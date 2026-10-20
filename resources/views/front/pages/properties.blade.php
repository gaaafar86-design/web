@extends('front.layouts.master')

@section('content')
    <div class="page-top" style="background-image: url({{ asset('website-images/pppppp.png') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>العقارات المتوفرة</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="property-result">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="property-filter">
                        <form action="{{ route('properties') }}" method="GET">
                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Find Anything</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['title' => null, 'page' => null]) }}" style="color: #333;" aria-label="Clear title">
                                        <i class="fas fa-times fa-lg"></i>
                                    </a>
                                </div>
                                <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    placeholder="Search titles..."
                                    value="{{ request('title') }}"
                                />
                            </div>

                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Location</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['location_id' => null, 'page' => null]) }}" style="color: #333;" aria-label="Clear location">
                                        <i class="fas fa-times fa-lg"></i>
                                    </a>
                                </div>
                                <select name="location_id" class="form-control select2" style="width: 100% !important">
                                    <option value="">--- Select ---</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}" @selected((string) request('location_id') === (string) $location->id)>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Type</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['type_id' => null, 'page' => null]) }}" style="color: #333;" aria-label="Clear type">
                                        <i class="fas fa-times fa-lg"></i>
                                    </a>
                                </div>
                                <select name="type_id" class="form-control select2" style="width: 100% !important">
                                    <option value="">--- Select ---</option>
                                    @foreach ($propertyTypes as $type)
                                        <option value="{{ $type->id }}" @selected((string) request('type_id') === (string) $type->id)>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Purpose</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['purpose' => null, 'page' => null]) }}" style="color: #333;" aria-label="Clear purpose">
                                        <i class="fas fa-times fa-lg"></i>
                                    </a>
                                </div>
                                <select name="purpose" class="form-control select2" style="width: 100% !important">
                                    <option value="">--- Select ---</option>
                                    <option value="for rent" @selected(request('purpose') === 'for rent')>For Rent</option>
                                    <option value="for sale" @selected(request('purpose') === 'for sale')>For Sale</option>
                                </select>
                            </div>

                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Amenities</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['amenity' => null, 'page' => null]) }}" style="color: #333;" aria-label="Clear amenities">
                                        <i class="fas fa-times fa-lg"></i>
                                    </a>
                                </div>
                                <select name="amenity[]" class="form-control select2" multiple data-placeholder="-- Select --" style="width: 100% !important">
                                    @foreach ($amenities as $amenity)
                                        <option
                                            value="{{ $amenity->id }}"
                                            @selected(in_array($amenity->id, (array) request('amenity', [])))
                                        >
                                            {{ $amenity->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Bedrooms</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['bedroom' => null, 'page' => null]) }}" style="color: #333;" aria-label="Clear bedrooms">
                                        <i class="fas fa-times fa-lg"></i>
                                    </a>
                                </div>
                                <select name="bedroom" class="form-control select2" style="width: 100% !important">
                                    <option value="">--- Select ---</option>
                                    @for ($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}" @selected((string) request('bedroom') === (string) $i)>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Bathrooms</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['bathroom' => null, 'page' => null]) }}" style="color: #333;" aria-label="Clear bathrooms">
                                        <i class="fas fa-times fa-lg"></i>
                                    </a>
                                </div>
                                <select name="bathroom" class="form-control select2" style="width: 100% !important">
                                    <option value="">--- Select ---</option>
                                    @for ($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}" @selected((string) request('bathroom') === (string) $i)>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Featured</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['is_featured' => null, 'page' => null]) }}" style="color: #333;" aria-label="Clear featured filter">
                                        <i class="fas fa-times fa-lg"></i>
                                    </a>
                                </div>
                                <select name="is_featured" class="form-control select2" style="width: 100% !important">
                                    <option value="">--- Select ---</option>
                                    <option value="1" @selected((string) request('is_featured') === '1')>Yes</option>
                                    <option value="0" @selected((string) request('is_featured') === '0')>No</option>
                                </select>
                            </div>

                            {{-- Optional USD price filter: empty means all prices --}}
                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Price in USD</h2>
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null, 'page' => null]) }}"
                                        style="color: #333;"
                                        aria-label="Clear price filter"
                                    >
                                        <i class="fas fa-times fa-lg"></i>
                                    </a>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <label for="minPrice">From $</label>
                                        <input
                                            type="number"
                                            id="minPrice"
                                            name="min_price"
                                            class="form-control"
                                            min="0"
                                            step="100"
                                            placeholder="No minimum"
                                            value="{{ request('min_price') }}"
                                        >
                                    </div>
                                    <div class="col-6">
                                        <label for="maxPrice">To $</label>
                                        <input
                                            type="number"
                                            id="maxPrice"
                                            name="max_price"
                                            class="form-control"
                                            min="0"
                                            step="100"
                                            placeholder="No maximum"
                                            value="{{ request('max_price') }}"
                                        >
                                    </div>
                                </div>

                                <small class="text-muted d-block mt-2">
                                    Leave both fields empty to show properties at all prices.
                                </small>
                            </div>

                            <div class="filter-button">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-8 col-md-12">
                    <div class="property">
                        <div class="container">
                            <div class="row">
                                @if ($properties->isNotEmpty())
                                    @foreach ($properties as $property)
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="item">
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

                                                        @if ($property->is_featured)
                                                            <div class="featured">Featured</div>
                                                        @endif
                                                    </div>

                                                    <div class="price">
                                                        @if (!is_null($property->price) && $property->price !== '')
                                                            ${{ number_format((float) $property->price) }}
                                                        @else
                                                            Price on request
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
                                                            <a href="{{ route('user.add.to.wishlist', $property) }}" aria-label="Add to wishlist">
                                                                <i class="far fa-heart"></i>
                                                            </a>
                                                        @else
                                                            <form action="{{ route('user.remove.from.wishlist', $wishlistItem) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" style="border: none; background: transparent;" aria-label="Remove from wishlist">
                                                                    <i class="fas fa-heart" style="color: #d92228;"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="text">
                                                    <h3>
                                                        <a href="{{ route('property.detail', $property->slug) }}">
                                                            {{ $property->name }}
                                                        </a>
                                                    </h3>

                                                    <div class="detail">
                                                        <div class="stat">
                                                            <div class="i1">{{ $property->size }} sqft</div>
                                                            <div class="i2">{{ $property->bedroom }} Bedroom(s)</div>
                                                            <div class="i3">{{ $property->bathroom }} Bathroom(s)</div>
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
                                                            <a href="{{ route('agent.detail', $property->agent) }}">
                                                                {{ $property->agent->name }} ({{ $property->agent->company }})
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="col-12 mt_30">
                                        {{ $properties->appends(request()->query())->links() }}
                                    </div>
                                @else
                                    <div class="col-12">
                                        <h4 class="text-danger mt_200 mb_200" style="text-align: center; font-weight: bold;">
                                            No properties match your criteria.
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
