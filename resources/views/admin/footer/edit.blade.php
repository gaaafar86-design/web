@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Edit Footer</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.footer.show') }}" class="btn btn-primary"><i class="fas fa-arrow-left m-2"></i>Back</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.footer.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mb-3">
                                        <label class="form-label">Address *</label>
                                        <input type="text" class="form-control" name="address" value="{{ $footer->address }}">
                                        @error('address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Email *</label>
                                        <input type="email" class="form-control" name="email" value="{{ $footer->email }}">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Phone *</label>
                                        <input type="tel" class="form-control" name="phone" value="{{ $footer->phone }}">
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Facebook</label>
                                        <input type="text" class="form-control" name="facebook" value="{{ $footer->facebook }}">
                                        @error('facebook')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Twitter</label>
                                        <input type="text" class="form-control" name="twitter" value="{{ $footer->twitter }}">
                                        @error('twitter')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">LinkedIn</label>
                                        <input type="text" class="form-control" name="linkedin" value="{{ $footer->linkedin }}">
                                        @error('linkedin')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Instagram</label>
                                        <input type="text" class="form-control" name="instagram" value="{{ $footer->instagram }}">
                                        @error('instagram')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Copyright *</label>
                                        <input type="text" class="form-control" name="copyright" value="{{ $footer->copyright }}">
                                        @error('copyright')
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
