@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Edit Testimonial</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.testimonial.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left m-2"></i>Back</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.testimonial.update', $testimonial) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mb-3">
                                        <label class="form-label">Existing Photo</label>
                                        <div>
                                            <img src="{{ asset('user-images/'. $testimonial->photo) }}" alt="User-image" class="w_100">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Change Photo</label>
                                        <div>
                                            <input type="file" name="photo">
                                            @error('photo')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Name *</label>
                                        <input type="text" class="form-control" name="name" value="{{ $testimonial->name }}">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Designation *</label>
                                        <input type="designation" class="form-control" name="designation" value="{{ $testimonial->designation }}">
                                        @error('designation')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Comment *</label>
                                        <textarea name="comment" class="form-control h_150">{{ $testimonial->comment }}</textarea>
                                        @error('comment')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
