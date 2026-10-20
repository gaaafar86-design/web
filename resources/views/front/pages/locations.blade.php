@extends('front.layouts.master')
@section('content')
        <div class="page-top" style="background-image: url({{ asset('website-images/c111.png') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Locations</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="location pb_40">
        <div class="container">
            <div class="row">
                @if ($locations->isNotEmpty())
                    @foreach ($locations as $location)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="item">
                                <div class="photo">
                                    <a href="{{ route('location.detail', $location->slug) }}"><img src="{{ asset('location-images/' . $location->photo)}}" alt="Location-image"></a>
                                </div>
                                <div class="text">
                                    <h2><a href="{{ route('location.detail', $location->slug) }}">{{ $location->name }}</a></h2>
                                    <h4>({{ $location->properties_count }} Properties)</h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12 mt_30">
                        {{ $locations->links() }}
                    </div>
                @else
                    <h4 class="text-danger mt_150 mb_150" style="text-align: center; font-weight: bold;">Currently there are no locations.</h4>
                @endif
            </div>
        </div>
    </div>
@endsection
