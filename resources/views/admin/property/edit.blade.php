@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar />
    <x-admin_sidebar />
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between align-items-center">
                <h1>Edit Property</h1>
                <a href="{{ route('admin.properties.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
            <div class="section-body mb_50">
                <div class="col-lg-9 col-md-12">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Existing Featured Photo</label>
                            <div class="form-group">
                                <img src="{{ asset('property-images/' . $property->featured_photo) }}" alt="Property-image" class="user-photo w_300">
                            </div>
                        </div>
                        <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Change Featured Photo</label>
                                    <input type="file" name="featured_photo" class="form-control">
                                    @error('featured_photo') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" name="name" class="form-control" value="{{ $property->name }}">
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price *</label>
                                    <input type="text" name="price" class="form-control" value="{{ number_format($property->price) }}">
                                    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control h_200">{{ $property->description }}</textarea>
                                    @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Location *</label>
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
                                    <label class="form-label">Type *</label>
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
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Bedrooms *</label>
                                    <select name="bedroom" class="form-control select2">
                                        @for ($i = 0; $i <= 10; $i++)
                                            <option value="{{ $i }}" @selected($property->bedroom == $i)>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('bedroom')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Bathrooms *</label>
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
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Floor</label>
                                    <input type="text" name="floor" class="form-control"  value="{{ $property->floor !== null ? number_format($property->floor) : '' }}">
                                    @error('floor')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Garage</label>
                                    <input type="number" name="garage" class="form-control" value="{{ $property->garage }}">
                                    @error('garage')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Balcony</label>
                                    <input type="number" name="balcony" class="form-control" value="{{ $property->balcony }}">
                                    @error('balcony')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Address *</label>
                                    <input type="text" name="address" class="form-control" value="{{ $property->address }}">
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Built Year</label>
                                    <input type="number" name="year" class="form-control" value="{{ $property->built_year }}">
                                    @error('year')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Is Featured?</label>
                                    <select name="is_featured" class="form-control">
                                        <option value="1" @selected(old('is_featured', $property->is_featured) == 1)>Yes</option>
                                        <option value="0" @selected(old('is_featured', $property->is_featured) == 0)>No</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status *</label>
                                    <select name="status" class="form-control">
                                        <option value="1" @selected(old('status', $property->status) == 1)>منشور (يظهر للزوار)</option>
                                        <option value="0" @selected(old('status', $property->status) == 0)>قيد المراجعة</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">الوكيل *</label>
                                    <select name="agent_id" class="form-control select2">
                                        @foreach ($agents as $agent)
                                            <option value="{{ $agent->id }}" @selected(old('agent_id', $property->agent_id) == $agent->id)>{{ $agent->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Location Map</label>
                                    <textarea name="map" class="form-control h_200">{{ $property->map }}</textarea>
                                    @error('map') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Amenities</label>
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
                            <div class="row">
                                <div class="col-md-12" style="margin: 10px 0;">
                                    <button type="submit" class="btn btn-primary">Update Property</button>
                                </div>
                            </div>
                        </form>
                        @if ($propertyPhotos->isNotEmpty())
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h4 class="mb-3">Existing Photos</h4>
                                    <div class="row g-3">
                                        @foreach ($propertyPhotos as $photo)
                                            <div class="col-md-6 col-lg-3">
                                                <div class="card shadow-sm">
                                                    <a href="{{ asset('property-images/' . $photo->photo) }}" class="magnific">
                                                        <img src="{{ asset('property-images/' . $photo->photo) }}" alt="Property-image" class="card-img-top">
                                                        <div class="position-absolute top-0 end-0 p-2">
                                                            <i class="fas fa-search-plus text-white bg-dark rounded-circle p-2"></i>
                                                        </div>
                                                    </a>
                                                    <div class="card-body text-center">
                                                        <form action="{{ route('admin.properties.photo.destroy', $photo) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this photo?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-primary w-100">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($propertyVideos->isNotEmpty())
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h4 class="mb-3">Existing Videos</h4>
                                    <div class="row g-3">
                                        @foreach ($propertyVideos as $video)
                                            <div class="col-md-6 col-lg-3">
                                                <div class="card shadow-sm">
                                                    <a href="https://www.youtube.com/watch?v={{ $video->video }}" target="_blank" class="position-relative d-block">
                                                        <img src="https://img.youtube.com/vi/{{ $video->video }}/hqdefault.jpg" alt="Property-video" class="card-img-top">
                                                        <div class="position-absolute top-50 start-50 translate-middle">
                                                            <i class="far fa-play-circle fa-2x text-white bg-dark rounded-circle p-2"></i>
                                                        </div>
                                                    </a>
                                                    <div class="card-body text-center">
                                                        <form action="{{ route('admin.properties.video.destroy', $video) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this video?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-primary w-100">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
