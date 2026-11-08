@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Profile</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.edit.profile.submit', $admin) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="{{ $admin->photo ? asset('user-images/' . $admin->photo) : asset('user-images/default.png') }}" alt="User-Photo" class="profile-photo w_100_p">
                                            <input type="file" class="mt_10" name="photo">
                                            @error('photo')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-4">
                                                <label class="form-label">Name *</label>
                                                <input type="text" class="form-control" name="name" value="{{ $admin->name }}">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Email *</label>
                                                <input type="text" class="form-control" name="email" value="{{ $admin->email }}">
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current password">
                                                @error('password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" name="password_confirmation" placeholder="Repeat new password">
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label"></label>
                                                <button type="submit" class="btn btn-primary">Update</button>
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
