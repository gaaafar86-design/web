@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between align-items-center">
                <h1>Properties</h1>
                <a href="{{ route('admin.properties.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> إضافة عقار
                </a>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle" id="example1">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Featured Photo</th>
                                                <th>Agent</th>
                                                <th>Location</th>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($properties as $property)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img src="{{ asset('property-images/' . $property->featured_photo) }}" alt="Property-image" class="profile-photo w_100">
                                                    </td>
                                                    <td>{{ $property->agent->name }}</td>
                                                    <td>{{ $property->location->name }}</td>
                                                    <td>{{ $property->propertyType->name }}</td>
                                                    <td>{{ $property->name }}</td>
                                                    <td>
                                                        <span class="badge {{ displayIcon($property->status, 'bg-success', 'bg-danger') }}">{{ $property->status ? 'Active' : 'Pending' }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.properties.show', $property) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('admin.properties.edit', $property) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                        @unless ($property->status)
                                                            <form action="{{ route('admin.properties.make.active', $property) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success btn-sm">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                        @endunless
                                                        <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" style="display: inline;">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
