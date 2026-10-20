@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Show Property</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.properties.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left m-2"></i>Back</a>
                </div>
            </div>
            <div class="section-body mb_50">
                <div class="col-lg-9 col-md-12">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Featured Photo</label>
                            <div class="form-group">
                                <img src="{{ asset('property-images/' . $property->featured_photo) }}" alt="Property-image" class="user-photo w_300">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $property->name }}" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price</label>
                            <input type="text" name="price" class="form-control" value="${{ number_format($property->price) }}" disabled>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control h_200" disabled>{{ $property->description }}</textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" name="price" class="form-control" value="{{ $property->location->name }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" name="type" class="form-control" value="{{ $property->propertyType->name }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Purpose</label>
                            <input type="text" name="purpose" class="form-control" value="{{ $property->purpose }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Bedrooms</label>
                            <input type="number" name="bedroom" class="form-control" value="{{ $property->bedroom }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Bathrooms</label>
                            <input type="number" name="bathroom" class="form-control" value="{{ $property->bathroom }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Size (Sqft)</label>
                            <input type="number" name="size" class="form-control" value="{{ number_format($property->size) }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Floor</label>
                            <input type="number" name="floor" class="form-control"  value="{{ number_format($property->floor) }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Garage</label>
                            <input type="number" name="garage" class="form-control" value="{{ $property->garage }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Balcony</label>
                            <input type="number" name="balcony" class="form-control" value="{{ $property->balcony }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $property->address }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Built Year</label>
                            <input type="number" name="year" class="form-control" value="{{ $property->built_year }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Is Featured?</label>
                            <input type="text" name="is_featured" class="form-control" value="{{ $property->is_featured ? 'Yes' : 'No' }}" disabled>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Location Map</label>
                            <textarea name="map" class="form-control h_200" disabled>{{ $property->map }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            @if ($property->amenities->isNotEmpty())
                                <label class="form-label">Amenities</label>
                                <div class="row">
                                    @foreach ($property->amenities as $amenity)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}" disabled
                                                checked>
                                                <label class="form-check-label">
                                                    {{ $amenity->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        @if ($propertyPhotos->isNotEmpty())
                            <h5 class="mt-4">Photo Gallery</h5>
                            <div class="photo-all">
                                <div class="row">
                                    @foreach ($propertyPhotos as $photo)
                                        <div class="col-md-6 col-lg-3">
                                            <div class="item item-delete">
                                                <a href="{{ asset('property-images/' . $photo->photo)}}" class="magnific">
                                                    <img src="{{ asset('property-images/' . $photo->photo)}}" alt="Property-image" class="w_200"/>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if ($propertyVideos->isNotEmpty())
                            <h5 class="mt-4">Video Gallery</h5>
                            @foreach ($propertyVideos as $video)
                                <div class="video-all">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-3">
                                            <div class="item item-delete">
                                                <a class="video-button" href="http://www.youtube.com/watch?v={{ $video->video }}">
                                                    <img src="http://img.youtube.com/vi/{{ $video->video }}" alt="Property-video"/>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
