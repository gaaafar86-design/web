@extends('front.layouts.master')
@section('content')
        <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $agent->name }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="agent-detail pb_60">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner">
                        <div class="photo">
                            <img src="{{ $agent->photo ? asset('user-images/' . $agent->photo) : asset('user-images/default.png') }}" alt="Agent-image">
                        </div>
                        <div class="detail">
                            <h3>{{ $agent->name }} ({{ $agent->company }})</h3>
                            <h4>{{ $agent->designation }}</h4>
                            <p>{{ $agent->biography }}</p>
                            <div class="contact d-flex justify-content-center">
                                @if ($agent->address)
                                    <div class="item"><i class="fas fa-map-marker-alt"></i> {{ $agent->address }}</div>
                                @endif
                                <div class="item"><i class="fas fa-phone"></i> {{ $agent->phone }}</div>
                                <div class="item"><i class="far fa-envelope"></i><a href="mailto:{{ $agent->email }}" style="color: inherit;"> {{ $agent->email }}</a></div>
                                @if ($agent->website)
                                    @php
                                        $website = Str::startsWith($agent->website, ['http://', 'https://'])
                                            ? $agent->website
                                            : 'https://' . $agent->website;
                                    @endphp
                                    <div class="item"><i class="fas fa-globe"></i><a href="{{ $website }}" target="_blank" style="color: inherit;"> {{ $website }}</a></div>
                                @endif
                            </div>
                            <ul class="agent-detail-ul">
                                @if ($agent->facebook)
                                    <li><a href="{{ $agent->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                                @endif
                                @if ($agent->twitter)
                                    <li><a href="{{ $agent->twitter }}"><i class="fab fa-twitter"></i></a></li>
                                @endif
                                @if ($agent->instagram)
                                    <li><a href="{{ $agent->instagram }}"><i class="fab fa-instagram"></i></a></li>
                                @endif
                                @if ($agent->linkedin)
                                    <li><a href="{{ $agent->linkedin }}"><i class="fab fa-linkedin-in"></i></a></li>
                                @endif
                            </ul>
                        </div>
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
                                    <div class="photo" style="width: 100%">
                                        <img class="main rounded-0" src="{{ asset('property-images/' . $property->featured_photo) }}" alt="Property-image">
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
                                            <div class="address" style="text-align: left">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12 mt_30">
                            {{ $properties->links() }}
                        </div>
                    @else
                        <h4 class="text-danger" style="text-align: center; font-weight: bold;">There is no property available for this agent.</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
