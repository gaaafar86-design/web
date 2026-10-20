@extends('front.layouts.master')
@section('content')
        <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Photos</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content user-panel mt_50 mb_50">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <x-dashboard/>
                </div>
                <div class="col-lg-9 col-md-12">
                    @php
                        $propertyPhotos = $property->photos()->count();
                        $agentPlan = App\Models\AgentPlan::where(
                            'agent_id',
                            Auth::guard('agent')->id(),
                        )
                        ->where('expire_at', '>', now())
                        ->orWhere('expire_at', null)
                        ->first();
                        $currentPlan = $agentPlan->plan;
                        $allowedPropertyPhotos = $currentPlan->allowed_photos == -1
                        ? 100000
                        : $currentPlan->allowed_photos;
                    @endphp
                    @if ($propertyPhotos >= $allowedPropertyPhotos)
                        <h4 class="mt-4 text-danger fw-semibold bg-light p-3 rounded border border-danger">You have reached your plan's limit for adding photos for this property.</h4>
                    @else
                        <h4>Add Photo</h4>
                        <form action="{{ route('agent.photo.gallery.submit', $property) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <input type="file" name="photos[]" multiple/>
                                        @error('photos')
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
                    @if ($existingPhotos->isNotEmpty())
                        <h4 class="mt-4">Existing Photos</h4>
                        <div class="photo-all">
                            <div class="row">
                                @foreach ($existingPhotos as $photo)
                                    <div class="col-md-6 col-lg-3">
                                        <div class="item item-delete">
                                            <a href="{{ asset('property-images/' . $photo->photo)}}" class="magnific">
                                                <img src="{{ asset('property-images/' . $photo->photo)}}" alt="Property-image"/>
                                                <div class="icon">
                                                    <i class="fas fa-plus"></i>
                                                </div>
                                                <div class="bg"></div>
                                            </a>
                                        </div>
                                        <form action="{{ route('agent.photo.gallery.destroy', $photo) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-danger mb_20" onclick="return confirm('Are you sure?');" style="border: none; outline: none;">Delete</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <h4 class="mt-4 text-danger fw-semibold bg-light p-3 rounded border border-danger">Property has no existing photos.</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
