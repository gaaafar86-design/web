@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Show Property</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content user-panel">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <x-dashboard/>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Featured Photo</label>
                            <div class="form-group">
                                <img src="{{ asset('property-images/' . $property->featured_photo) }}" alt="Property-image" class="user-photo w-200">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" value="{{ $property->name }}" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price</label>
                            <input type="text" class="form-control" value="${{ number_format($property->price) }}" disabled>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control h-200" disabled>{{ $property->description }}</textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control" value="{{ $property->location->name }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" class="form-control" value="{{ $property->propertyType->name }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Purpose</label>
                            <input type="text" class="form-control" value="{{ $property->purpose }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Bedrooms</label>
                            <input type="number" class="form-control" value="{{ $property->bedroom }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Bathrooms *</label>
                            <input type="number" class="form-control" value="{{ $property->bathroom }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Size (Sqft)</label>
                            <input type="text" class="form-control" value="{{ number_format($property->size) }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Floor</label>
                            <input type="text" class="form-control"  value="{{ number_format($property->floor) }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Garage</label>
                            <input type="number" class="form-control" value="{{ $property->garage }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Balcony</label>
                            <input type="number" class="form-control" value="{{ $property->balcony }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" value="{{ $property->address }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Built Year</label>
                            <input type="number" class="form-control" value="{{ $property->built_year }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Is Featured?</label>
                            <input type="text" class="form-control" value="{{ $property->is_featured ? 'Yes' : 'No' }}" disabled>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Location Map</label>
                            <textarea class="form-control h-150" cols="30" rows="10" disabled>{{ $property->map }}</textarea>
                        </div>
                        @if ($property->amenities->isNotEmpty())
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Amenities</label>
                                <div class="row">
                                    @foreach ($property->amenities as $amenity)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{ $amenity->id }}" disabled
                                                checked>
                                                <label class="form-check-label">
                                                    {{ $amenity->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12 mb-3">
                            <a href="{{ route('agent.properties.edit', $property)}}" class="btn btn-primary" style="background-color: #d92228; border: none; outline: none;">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
