@extends('admin.layouts.master')

@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>

    <div class="main-content">
        <section class="section">

            <div class="section-header d-flex justify-content-between">
                <h1>Edit User</h1>

                <div class="ml-auto">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left m-2"></i>
                        Back
                    </a>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">

                                <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">

                                        {{-- Existing Photo --}}
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Existing Photo</label>
                                            <div class="form-group">
                                                <img src="{{ $user->photo ? asset('user-images/' . $user->photo) : asset('user-images/default.png') }}"
                                                     alt="User image" class="user-photo w_200">
                                            </div>
                                        </div>

                                        {{-- Change Photo --}}
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Change Photo</label>
                                            <div class="form-group">
                                                <input type="file" name="photo" class="form-control" accept="image/*">
                                                @error('photo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Name --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Name *</label>
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Email --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email *</label>
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Syrian Phone (10 digits) --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Phone Number *</label>
                                            <div class="form-group">
                                                <input type="tel" name="phone" class="form-control"
                                                       value="{{ old('phone', $user->phone) }}"
                                                       placeholder="0930000000"
                                                       maxlength="10" minlength="10"
                                                       inputmode="numeric"
                                                       pattern="09[0-9]{8}"
                                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                       required>
                                                <small class="text-muted">Example: 0930000000</small>
                                                @error('phone')
                                                    <small class="text-danger d-block">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Password --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                                                @error('password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Confirm Password --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="Retype new password">
                                            </div>
                                        </div>

                                        {{-- Status --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status *</label>
                                            <div class="form-group">
                                                <select name="status" class="form-control" required>
                                                    <option value="0" @selected(old('status', $user->getRawOriginal('status')) == '0')>Inactive</option>
                                                    <option value="1" @selected(old('status', $user->getRawOriginal('status')) == '1')>Active</option>
                                                    <option value="2" @selected(old('status', $user->getRawOriginal('status')) == '2')>Suspended</option>
                                                </select>
                                                @error('status')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Submit --}}
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="Update">
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