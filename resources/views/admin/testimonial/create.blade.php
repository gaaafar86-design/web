@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Create Testimonial</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.testimonial.index') }}" class="btn btn-primary"><i class="fas fa-eye m-2"></i>Back</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.testimonial.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label class="form-label">Photo *</label>
                                        <div>
                                            <input type="file" name="photo">
                                            @error('photo')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Name *</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Designation *</label>
                                        <input type="text" class="form-control" name="designation" value="{{ old('designation') }}">
                                        @error('designation')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Comment *</label>
                                        <textarea name="comment" class="form-control h_100" cols="30" rows="10">{{ old('comment') }}</textarea>
                                        @error('comment')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
