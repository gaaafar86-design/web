@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Settings</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Change Logo</label>
                                                <input type="file" name="logo" class="form-control">
                                                @error('logo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Existing Logo</label>
                                                <div>
                                                    <img src="{{ asset('website-images/'. $setting->logo) }}" alt="Logo" class="w_100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Change Favicon</label>
                                                <input type="file" name="favicon" class="form-control">
                                                @error('favicon')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="from-label">Existing Favicon</label>
                                                <div>
                                                    <img src="{{ asset('website-images/'. $setting->favicon) }}" alt="Favicon" class="w_100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Change Banner</label>
                                                <input type="file" name="banner" class="form-control">
                                                @error('banner')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Existing Banner</label>
                                                <div>
                                                    <img src="{{ asset('website-images/'. $setting->banner) }}" alt="Banner" class="w_200">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Change Why-Choose-Us Image</label>
                                                <input type="file" name="why_choose_us_image" class="form-control">
                                                @error('why_choose_us_image')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Existing Banner</label>
                                                <div>
                                                    <img src="{{ asset('website-images/'. $setting->why_choose_us_image) }}" alt="Image" class="w_200">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Change Our-Happy-Clients Image</label>
                                                <input type="file" name="our_happy_clients_image" class="form-control">
                                                @error('our_happy_clients_image')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Existing Banner</label>
                                                <div>
                                                    <img src="{{ asset('website-images/'. $setting->our_happy_clients_image) }}" alt="Image" class="w_200">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
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
