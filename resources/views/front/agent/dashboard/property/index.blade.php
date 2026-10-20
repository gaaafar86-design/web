@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>All Properties</h2>
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
                    <div class="table-responsive">
                        <table class="table table-bordered text-center table align-middle" id="datatable">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Featured Photo</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Location</th>
                                    <th>Purpose</th>
                                    <th>Status</th>
                                    <th class="w-150">Options</th>
                                    <th class="w-150">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($properties as $property)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset('property-images/' . $property->featured_photo) }}" alt="Property-image" class="w-150">
                                        </td>
                                        <td>{{ $property->name }}</td>
                                        <td>{{ $property->PropertyType->name }}</td>
                                        <td>{{ $property->location->name }}</td>
                                        <td>{{ $property->purpose }}</td>
                                        <td>
                                            <span class="badge {{ displayIcon($property->status, 'bg-success', 'bg-danger') }}">
                                                {{ $property->status ? 'Active' : 'Pending' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('agent.photo.gallery', $property) }}" class="btn btn-primary btn-sm btn-sm-custom w-100-p mb_5">Photo Gallery</a>
                                            <a href="{{ route('agent.video.gallery', $property) }}" class="btn btn-primary btn-sm btn-sm-custom w-100-p mb_5">Video Gallery</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('agent.properties.edit', $property)}}" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                            <a href="{{ route('agent.properties.show', $property) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                            <form action="{{ route('agent.properties.destroy', $property) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $properties->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
