@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Create Item</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.why-choose-us.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left m-2"></i>Back</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.why-choose-us.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Title *</label>
                                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                                @error('title')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Text *</label>
                                                <textarea name="text" class="form-control h_200">{{ old('text') }}</textarea>
                                                @error('text')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
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
