@extends('front.layouts.master')
@section('content')
        <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Videos</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content user-panel mb_50 mt_50">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <x-dashboard/>
                </div>
                <div class="col-lg-9 col-md-12">
                    @php
                        $propertyVideos = $property->videos()->count();
                        $agentPlan = App\Models\AgentPlan::where(
                            'agent_id',
                            Auth::guard('agent')->id(),
                        )
                        ->where('expire_at', '>', now())
                        ->orWhere('expire_at', null)
                        ->first();
                        $currentPlan = $agentPlan->plan;
                        $allowedPropertyVideos = $currentPlan->allowed_videos == -1
                        ? 100000
                        : $currentPlan->allowed_videos
                    @endphp
                    @if ($propertyVideos >= $allowedPropertyVideos)
                        <h4 class="mt-4 text-danger fw-semibold bg-light p-3 rounded border border-danger">You have reached your plan's limit for adding videos for this property.</h4>
                    @else
                        <h4>Add Video</h4>
                        <form action="{{ route('agent.video.gallery.submit', $property) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <input type="text" name="video" class="form-control" placeholder="Youtube Video ID"/>
                                        @error('video')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-sm" value="Submit" />
                                </div>
                            </div>
                        </form>
                    @endif

                    @if ($existingVideos->isNotEmpty())
                        <h4 class="mt-4">Existing Videos</h4>
                        @foreach ($existingVideos as $video)
                            <div class="video-all">
                                <div class="row">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="item item-delete">
                                            <a class="video-button" href="http://www.youtube.com/watch?v={{ $video->video }}">
                                                <img src="http://img.youtube.com/vi/{{ $video->video }}" alt="Property-video"/>
                                                <div class="icon">
                                                    <i class="far fa-play-circle"></i>
                                                </div>
                                                <div class="bg"></div>
                                            </a>
                                        </div>
                                        <form action="{{ route('agent.video.gallery.destroy', $video) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-danger mb_20" onclick="return confirm('Are you sure?');" style="border: none; outline: none;">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h4 class="mt-4 text-danger fw-semibold bg-light p-3 rounded border border-danger">Property has no existing videos.</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
