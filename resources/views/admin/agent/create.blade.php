@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Create Agent</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.agents.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left m-2"></i>Back</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.agents.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="">Photo</label>
                                            <div class="form-group">
                                                <input type="file" name="photo">
                                                @error('photo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Name *</label>
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Email *</label>
                                            <div class="form-group">
                                                <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Password *</label>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control">
                                                @error('password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Confirm Password *</label>
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Company *</label>
                                            <div class="form-group">
                                                <input type="text" name="company" class="form-control" value="{{ old('company') }}">
                                                @error('company')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Phone Number *</label>
                                            <div class="form-group">
                                                <input type="tel" name="phone" class="form-control"
                                                       value="{{ old('phone') }}"
                                                       placeholder="0930000000"
                                                       maxlength="10" minlength="10"
                                                       inputmode="numeric"
                                                       pattern="09[0-9]{8}"
                                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                       required>
                                                <small class="text-muted">مثال: 0930000000 (10 أرقام)</small>
                                                @error('phone')
                                                    <small class="text-danger d-block">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Designation *</label>
                                            <div class="form-group">
                                                <input type="text" name="designation" class="form-control" value="{{ old('designation') }}">
                                                @error('designation')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Address</label>
                                            <div class="form-group">
                                                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                                                @error('address')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Country</label>
                                            <div class="form-group">
                                                <input type="text" name="country" class="form-control" value="{{ old('country')}}">
                                                @error('country')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">State</label>
                                            <div class="form-group">
                                                <input type="text" name="state" class="form-control" value="{{ old('state') }}">
                                                @error('state')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">City</label>
                                            <div class="form-group">
                                                <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                                                @error('city')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Website</label>
                                            <div class="form-group">
                                                <input type="text" name="website" class="form-control" value="{{ old('website') }}">
                                                @error('website')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Facebook</label>
                                            <div class="form-group">
                                                <input type="text" name="facebook" class="form-control" value="{{ old('facebook') }}">
                                                @error('facebook')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Twitter</label>
                                            <div class="form-group">
                                                <input type="text" name="twitter" class="form-control" value="{{ old('twitter') }}">
                                                @error('twitter')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Linkedin</label>
                                            <div class="form-group">
                                                <input type="text" name="linkedin" class="form-control" value="{{ old('linkedin') }}">
                                                @error('linkedin')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Instagram</label>
                                            <div class="form-group">
                                                <input type="text" name="instagram" class="form-control" value="{{ old('instagram') }}">
                                                @error('instagram')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="">Biography</label>
                                            <div class="form-group">
                                                <textarea name="biography" class="form-control h_200" rows="5">{{ old('biography') }}</textarea>
                                                @error('biography')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="Create">
                                            </div>
                                        </div>
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
