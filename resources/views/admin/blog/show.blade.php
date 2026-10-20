@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Show Post</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left m-2"></i>Back</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label class="form-label">Photo</label>
                                    <div>
                                        <img src="{{ asset('blog-images/'. $blog->photo) }}" alt="Blog-image" class="w_200">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ $blog->title }}" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea name="short_description" class="form-control h_100" disabled>{{ $blog->short_description }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control h_200" disabled>{{ $blog->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
