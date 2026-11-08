@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Edit Post</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left m-2"></i>Back</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mb-3">
                                        <label class="form-label">Existing Photo</label>
                                        <div>
                                            <img src="{{ asset('blog-images/' . $blog->photo) }}" alt="Location-image" class="w_200">
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
                                        <label class="form-label">Title *</label>
                                        <input type="text" class="form-control" name="title" value="{{ $blog->title }}">
                                        @error('title')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Short Description *</label>
                                        <textarea name="short_description" class="form-control h_100">{{ $blog->short_description }}</textarea>
                                        @error('short_description')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Description *</label>
                                        <textarea name="description" class="form-control editor">{{ $blog->description }}</textarea>
                                        @error('description')
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
