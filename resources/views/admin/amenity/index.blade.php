@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Amenities</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.amenities.create') }}" class="btn btn-primary"><i class="fas fa-plus m-2"></i>Create</a>
                </div>
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
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($amenities as $amenity)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $amenity->name }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.amenities.edit', $amenity) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                        <form action="{{ route('admin.amenities.destroy', $amenity) }}" method="POST" style="display: inline;">
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
