@extends('front.layouts.master')
@section('content')
        <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Location: {{ $location->name }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="property">
        <div class="container">
            <div class="row">
                @if ($properties->isNotEmpty())
                    @foreach ($properties as $property)
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="item">
                                <div class="photo">
                                    <img class="main" src="{{ asset('property-images/' . $property->featured_photo) }}" alt="Property-image">
                                    <div class="top">
                                        <div class="{{ $property->purpose == 'For Sale' ? 'status-sale' : 'status-rent'}}">
                                                {{ $property->purpose }}
                                        </div>
                                        @if ($property->is_featured)
                                            <div class="featured">
                                                Featured
                                            </div>
                                        @endif
                                    </div>
                                    <div class="price">${{ number_format($property->price) }}</div>
                                    <div class="wishlist">
                                        @php
                                            $loggedIn = Auth::guard('web')->check();
                                            if ($loggedIn) {
                                                $user = Auth::guard('web')->user()->load('wishlist');
                                                $hasWishlisted = $user->hasWishlisted($property);
                                                $wishlistItem = $user->wishlist->firstWhere('property_id', $property->id);
                                            };
                                        @endphp
                                        @if (!$loggedIn || !$hasWishlisted)
                                            <a href="{{ route('user.add.to.wishlist', $property) }}"><i class="far fa-heart"></i></a>
                                        @else
                                            <form action="{{ route('user.remove.from.wishlist', $wishlistItem) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="border: none; background: transparent;">
                                                    <i class="fas fa-heart" style="color: #d92228;">
                                                    </i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="text">
                                    <h3><a href="{{ route('property.detail', $property->slug)}}">{{ $property->name }}</a></h3>
                                    <div class="detail">
                                        <div class="stat">
                                            <div class="i1">{{ $property->size }} sqft</div>
                                            <div class="i2">{{ $property->bedroom }} Bedroom(s)</div>
                                            <div class="i3">{{ $property->bathroom }} Bathroom(s)</div>
                                        </div>
                                        <div class="address">
                                            <i class="fas fa-map-marker-alt"></i> {{ $property->address }}
                                        </div>
                                        <div class="type-location">
                                            <div class="i1">
                                                <i class="fas fa-edit"></i> {{ $property->propertyType->name }}
                                            </div>
                                            <div class="i2">
                                                <i class="fas fa-location-arrow"></i> {{ $property->location->name }}
                                            </div>
                                        </div>
                                        <div class="agent-section">
                                            <img class="agent-photo" src="{{ $property->agent->photo ? asset('user-images/' . $property->agent->photo) : asset('user-images/default.png') }}" alt="Agent-image">
                                            <a href="{{ route('agent.detail', $property->agent) }}">{{ $property->agent->name }} ({{ $property->agent->company }})</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12 mt_30">
                        {{ $properties->links() }}
                    </div>
                @else
                    <h4 class="text-danger mt_200 mb_200" style="text-align: center; font-weight: bold;">There is no property available for this location.</h4>
                @endif
            </div>
        </div>
    </div>

@endsection
