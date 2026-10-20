@extends('front.layouts.master')
@section('content')
        <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Agents</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="agent pb_40">
        <div class="container">
            <div class="row">
                @if ($agents->isNotEmpty())
                    @foreach ($agents as $agent)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="item">
                                <div class="photo">
                                    <a href="{{ route('agent.detail', $agent) }}">
                                        <img src="{{ $agent->photo ? asset('user-images/' . $agent->photo) : asset('user-images/default.png')}}" alt="Agent-image">
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
                    <div class="col-12 mt_30">
                        {{ $agents->links() }}
                    </div>
                @else
                    <h4 class="text-danger mt_150 mb_150" style="text-align: center; font-weight: bold;">There are no agents available.</h4>
                @endif
            </div>
        </div>
    </div>
@endsection
