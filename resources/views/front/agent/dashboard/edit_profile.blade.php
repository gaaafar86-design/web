@extends('front.layouts.master')
@section('content')
        <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Edit Profile</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content user-panel">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <x-dashboard/>
                </div>
                <div class="col-lg-9 col-md-12">
                    <form action="{{ route('agent.edit.profile.submit', $agent->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Current Photo</label>
                                <div class="mb-3">
                                    <img src="{{ $agent->photo ? asset('user-images/' . $agent->photo) : asset('user-images/default.png') }}"
                                        alt="Agent-image"
                                        class="img-thumbnail rounded-circle"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="photo" class="form-label">Upload New Photo</label>
                                <input type="file" name="photo" id="photo" class="form-control">
                                @error('photo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $agent->name }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $agent->email }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank to keep current password">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Repeat new password">
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <div class="input-group">
                                    <input type="tel" name="phone" class="form-control"
                                           value="{{ old('phone', $agent->phone) }}"
                                           placeholder="0930000000"
                                           maxlength="10" minlength="10"
                                           inputmode="numeric"
                                           pattern="09[0-9]{8}"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                           required>
                                </div>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="company" class="form-label">Company *</label>
                                <input type="text" name="company" id="company" class="form-control" value="{{ $agent->company }}">
                                @error('company')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="designation" class="form-label">Designation *</label>
                                <input type="text" name="designation" id="designation" class="form-control" value="{{ $agent->designation }}">
                                @error('designation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control" value="{{ $agent->address }}">
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" name="country" id="country" class="form-control" value="{{ $agent->country }}">
                                @error('country')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="state" class="form-label">State</label>
                                <input type="text" name="state" id="state" class="form-control" value="{{ $agent->state }}">
                                @error('state')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" id="city" class="form-control" value="{{ $agent->city }}">
                                @error('city')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="website" class="form-label">Website</label>
                                <input type="text" name="website" id="website" class="form-control" value="{{ $agent->website }}">
                                @error('website')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="text" name="facebook" id="facebook" class="form-control" value="{{ $agent->facebook }}">
                                @error('facebook')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="text" name="twitter" id="twitter" class="form-control" value="{{ $agent->twitter }}">
                                @error('twitter')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="linkedin" class="form-label">Linkedin</label>
                                <input type="text" name="linkedin" id="linkedin" class="form-control" value="{{ $agent->linkedin }}">
                                @error('linkedin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="text" name="instagram" id="instagram" class="form-control" value="{{ $agent->instagram }}">
                                @error('instagram')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="biography" class="form-label">Biography</label>
                                <textarea name="biography" id="biography" class="form-control h-200">{{ $agent->biography }}</textarea>
                                @error('biography')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12 text-end">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary px-4" value="Update Profile">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
