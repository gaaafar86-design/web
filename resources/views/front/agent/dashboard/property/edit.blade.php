@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Edit Property</h2>
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
                    <form action="{{ route('agent.properties.update', $property) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Existing Photo</label>
                                <div class="form-group">
                                    <img src="{{ asset('property-images/' . $property->featured_photo) }}" alt="Property-image" class="user-photo w-200">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Change Featured Photo</label>
                                <div class="form-group">
                                    <input type="file" name="featured_photo">
                                    @error('featured_photo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Name *</label>
                                <input type="text" name="name" class="form-control" value="{{ $property->name }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Price *</label>
                                <input type="text" name="price" class="form-control" value="{{ number_format($property->price) }}">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Description</label>
                                <textarea name="description" class="form-control editor">{{ $property->description }}</textarea>
                                @error('description')
                                   <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Location *</label>
                                <select name="location_id" class="form-control select2">
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}" @selected($property->location_id == $location->id)>{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Type *</label>
                                <select name="type_id" class="form-control select2">
                                    @foreach ($propertyTypes as $propertyType)
                                        <option value="{{ $propertyType->id }}" @selected($property->property_type_id == $propertyType->id)>{{ $propertyType->name }}</option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Purpose *</label>
                                <select name="purpose" class="form-control select2">
                                    <option value="for sale" @selected(strtolower($property->purpose) == 'for sale')>For Sale</option>
                                    <option value="for rent" @selected(strtolower($property->purpose) == 'for rent')>For Rent</option>
                                </select>
                                @error('purpose')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Bedrooms *</label>
                                <select name="bedroom" class="form-control select2">
                                    @for ($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}" @selected($property->bedrooom == $i)>{{ $i }}</option>
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
                                        <option value="{{ $i }}" @selected($property->bathroom == $i)>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('bathroom')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Size (Sqft) *</label>
                                <input type="text" name="size" class="form-control" value="{{ number_format($property->size) }}">
                                @error('size')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Floor</label>
                                <input type="text" name="floor" class="form-control"  value="{{ number_format($property->floor) }}">
                                @error('floor')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Garage</label>
                                <input type="number" name="garage" class="form-control" value="{{ $property->garage }}">
                                @error('garage')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Balcony</label>
                                <input type="number" name="balcony" class="form-control" value="{{ $property->balcony }}">
                                @error('balcony')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Address *</label>
                                <input type="text" name="address" class="form-control" value="{{ $property->address }}">
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label">Built Year</label>
                                <input type="number" name="year" class="form-control" value="{{ $property->built_year }}">
                                @error('year')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                @php
                                    $agentId = Auth::guard('agent')->id();
                                    $currentPlan = App\Models\AgentPlan::where('agent_id', $agentId)
                                        ->where('expire_at', '>', Carbon\Carbon::now())
                                        ->orWhere('expire_at', null)
                                        ->first();
                                    $allowedFeaturedPropertiesCount = $currentPlan->plan->allowed_featured_properties;
                                    $allowedFeaturedProperties = $allowedFeaturedPropertiesCount == -1
                                    ? 100000
                                    : $allowedFeaturedPropertiesCount;
                                    $agentFeaturedProperties = App\Models\Property::where('agent_id', $agentId)
                                        ->where('is_featured', 1)
                                        ->count();

                                    $allowedPropertiesCount = $currentPlan->plan->allowed_properties;
                                    $allowedProperties = $allowedPropertiesCount == -1
                                    ? 100000
                                    : $allowedPropertiesCount;
                                    $agentProperties = App\Models\Property::where('agent_id', $agentId)
                                        ->count();
                                @endphp
                                <label for="" class="form-label">Is Featured? *</label>
                                <select name="is_featured" class="form-control select2">
                                    <option value="0" @disabled($agentProperties > $allowedProperties) @selected($property->is_featured == '0')>No</option>
                                    <option value="1" @disabled($agentFeaturedProperties > $allowedFeaturedProperties) @selected($property->is_featured == '1')>Yes</option>
                                </select>
                                @error('is_featured')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Location Map</label>
                                <textarea name="map" class="form-control h-150" cols="30" rows="10">{{ $property->map }}</textarea>
                                @error('map')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Amenities</label>
                                <div class="row">
                                    @foreach ($amenities as $amenity)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                                id="{{ $amenity->id }}" @checked(in_array($amenity->id, $property->amenities->pluck('id')->toArray()))>
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
