@extends('admin.layouts.master')

@section('content')
    <x-admin_navbar />
    <x-admin_sidebar />

    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between align-items-center">
                <h1>Add Property</h1>
                <a href="{{ route('admin.properties.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>

            <div class="section-body mb_50">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="col-lg-9 col-md-12">
                    <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Agent *</label>
                                <select name="agent_id" class="form-control select2">
                                    <option value="">-- Select Agent --</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}" @selected(old('agent_id') == $agent->id)>
                                            {{ $agent->name }} ({{ $agent->phone }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('agent_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Featured Photo *</label>
                                <input type="file" name="featured_photo" class="form-control" accept="image/*">
                                <small class="form-text text-muted">الصورة الرئيسية للعقار</small>
                                @error('featured_photo') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- الصور الإضافية اختيارية --}}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">
                                    Additional Photos
                                    <small class="text-muted">(Optional)</small>
                                </label>
                                <input
                                    type="file"
                                    name="photos[]"
                                    id="additionalPhotos"
                                    class="form-control"
                                    accept="image/*"
                                    multiple
                                >
                                <small class="form-text text-muted">
                                    يمكنك اختيار عدة صور داخل نفس العقار، أو ترك الحقل فارغاً.
                                </small>
                                @error('photos') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                @error('photos.*') <small class="text-danger d-block">{{ $message }}</small> @enderror

                                <div id="additionalPhotosPreview" class="row mt-3"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price in USD *</label>
                                <input type="text" name="price" class="form-control" value="{{ old('price') }}">
                                @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control h_200">{{ old('description') }}</textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Location *</label>
                                <select name="location_id" class="form-control select2">
                                    <option value="">-- Select --</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('location_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Type *</label>
                                <select name="type_id" class="form-control select2">
                                    <option value="">-- Select --</option>
                                    @foreach ($propertyTypes as $propertyType)
                                        <option value="{{ $propertyType->id }}" @selected(old('type_id') == $propertyType->id)>
                                            {{ $propertyType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Purpose *</label>
                                <select name="purpose" class="form-control select2">
                                    <option value="for sale" @selected(old('purpose', 'for sale') == 'for sale')>For Sale</option>
                                    <option value="for rent" @selected(old('purpose') == 'for rent')>For Rent</option>
                                </select>
                                @error('purpose') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bedrooms *</label>
                                <select name="bedroom" class="form-control select2">
                                    @for ($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}" @selected(old('bedroom', 1) == $i)>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('bedroom') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bathrooms *</label>
                                <select name="bathroom" class="form-control select2">
                                    @for ($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}" @selected(old('bathroom', 1) == $i)>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('bathroom') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Size *</label>
                                <input type="text" name="size" class="form-control" value="{{ old('size') }}">
                                @error('size') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Floor</label>
                                <input type="text" name="floor" class="form-control" value="{{ old('floor') }}">
                                @error('floor') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Garage</label>
                                <input type="number" name="garage" min="0" class="form-control" value="{{ old('garage') }}">
                                @error('garage') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Balcony</label>
                                <input type="number" name="balcony" min="0" class="form-control" value="{{ old('balcony') }}">
                                @error('balcony') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Address *</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Built Year</label>
                                <input type="number" name="year" class="form-control" value="{{ old('year') }}">
                                @error('year') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Is Featured?</label>
                                <select name="is_featured" class="form-control">
                                    <option value="0" @selected(old('is_featured', 0) == 0)>No</option>
                                    <option value="1" @selected(old('is_featured') == 1)>Yes</option>
                                </select>
                                @error('is_featured') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-control">
                                    <option value="1" @selected(old('status', 1) == 1)>Active</option>
                                    <option value="0" @selected(old('status') === '0')>Pending</option>
                                </select>
                                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Location Map</label>
                                <textarea name="map" class="form-control h_200">{{ old('map') }}</textarea>
                                @error('map') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Amenities</label>
                            <div class="row">
                                @foreach ($amenities as $amenity)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="amenities[]"
                                                value="{{ $amenity->id }}"
                                                id="amenity-{{ $amenity->id }}"
                                                @checked(in_array($amenity->id, old('amenities', [])))
                                            >
                                            <label class="form-check-label" for="amenity-{{ $amenity->id }}">
                                                {{ $amenity->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                @error('amenities') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12" style="margin: 10px 0;">
                                <button type="submit" class="btn btn-primary">Create Property</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('additionalPhotos');
            const preview = document.getElementById('additionalPhotosPreview');

            if (!input || !preview) return;

            input.addEventListener('change', function () {
                preview.innerHTML = '';

                Array.from(input.files).forEach(function (file) {
                    if (!file.type.startsWith('image/')) return;

                    const reader = new FileReader();
                    reader.onload = function (event) {
                        const column = document.createElement('div');
                        column.className = 'col-6 col-md-3 mb-3';
                        column.innerHTML = `
                            <img
                                src="${event.target.result}"
                                alt="Preview"
                                class="img-thumbnail"
                                style="width:100%; height:120px; object-fit:cover;"
                            >
                        `;
                        preview.appendChild(column);
                    };
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
@endsection
