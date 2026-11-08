@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Create Property</h2>
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
                    <form action="{{ route('agent.properties.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Featured Photo *</label>
                                <input class="form-control" type="file" name="featured_photo">
                                @error('featured_photo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Name *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name')}}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Price *</label>
                                <input type="number" name="price" class="form-control" value="{{ old('price')}}">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Description</label>
                                <textarea name="description" class="form-control editor">{{ old('description')}}</textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Location *</label>
                                <select name="location_id" class="form-control select2">
                                    <option selected disabled>--- Select ---</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Type *</label>
                                <select name="type_id" class="form-control select2">
                                    <option selected disabled>--- Select ---</option>
                                    @foreach ($propertyTypes as $propertyType)
                                        <option value="{{ $propertyType->id }}" @selected(old('type_id') == $propertyType->id)>{{ $propertyType->name }}</option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Purpose *</label>
                                <select name="purpose" class="form-control select2">
                                    <option selected disabled>--- Select ---</option>
                                    <option value="for sale" @selected(old('purpose') == 'for sale')>For Sale</option>
                                    <option value="for rent" @selected(old('purpose') == 'for rent')>For Rent</option>
                                </select>
                                @error('purpose')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Bedrooms *</label>
                                <select name="bedroom" class="form-control select2">
                                    @for ($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}" @selected(old('bedroom') == $i)>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('bedroom')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Bathrooms *</label>
                                <select name="bathroom" class="form-control select2">
                                    @for ($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}" @selected(old('bathroom') == $i)>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('bathroom')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Size (Sqft) *</label>
                                <input type="number" name="size" class="form-control" value="{{ old('size')}}">
                                @error('size')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Floor</label>
                                <input type="number" name="floor" class="form-control"  value="{{ old('floor')}}">
                                @error('floor')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Garage</label>
                                <input type="number" name="garage" class="form-control" value="{{ old('garage')}}">
                                @error('garage')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Balcony</label>
                                <input type="number" name="balcony" class="form-control" value="{{ old('balcony')}}">
                                @error('balcony')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Address *</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address')}}">
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Built Year</label>
                                <input type="number" name="year" class="form-control" value="{{ old('year')}}">
                                @error('year')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Is Featured? *</label>
                                <select name="is_featured" class="form-control select2">
                                    <option value="0" @selected(old('is_featured') == 0) @disabled($agentProperties >= $allowedProperties)>No</option>
                                    <option value="1" @selected(old('is_featured') == 1) @disabled($agentFeaturedProperties >= $allowedFeaturedProperties)>Yes</option>
                                </select>
                                @error('is_featured')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Location Map</label>
                                <textarea name="map" class="form-control h-150" cols="30" rows="10">{{ old('map') }}</textarea>
                                @error('map')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @if ($amenities->isNotEmpty())
                                <div class="col-md-12 mb-3">
                                    <label for="" class="form-label">Amenities</label>
                                    <div class="row">
                                        @foreach ($amenities as $amenity)
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="{{ $amenity->id }}" @checked(in_array($amenity->id, old('amenities', [])))>
                                                    <label class="form-check-label" for="{{ $amenity->id }}">
                                                        {{ $amenity->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                        @error('amenities')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12 mb-3">
                                <input type="submit" class="btn btn-primary" value="Submit" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
