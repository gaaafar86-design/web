@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>شهادات العملاء</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.testimonial.create') }}" class="btn btn-primary"><i class="fas fa-plus m-2"></i>Create</a>
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
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Designation</th>
                                                <th class="w_100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($testimonials as $testimonial)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ asset('user-images/'. $testimonial->photo) }}" alt="User-image" class="w_100">
                                                </td>
                                                <td>{{ $testimonial->name }}</td>
                                                <td>{{ $testimonial->designation }}</td>
                                                <td>
                                                    <a href="{{ route('admin.testimonial.edit', $testimonial) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('admin.testimonial.destroy', $testimonial) }}" method="POST" style="display: inline;">
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
