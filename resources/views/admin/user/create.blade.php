@extends('admin.layouts.master')

@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>

    <div class="main-content">
        <section class="section">

            <div class="section-header d-flex justify-content-between">
                <h1>Create User</h1>

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

                                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">

                                        {{-- Photo --}}
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Photo</label>
                                                <input type="file" class="form-control" name="photo" accept="image/*">
                                                @error('photo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Name --}}
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Name *</label>
                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Email --}}
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Email *</label>
                                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Syrian Phone (10 digits) --}}
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Phone Number *</label>
                                                <input type="tel" name="phone" class="form-control"
                                                       value="{{ old('phone') }}"
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
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Password *</label>
                                                <input type="password" class="form-control" name="password" required>
                                                @error('password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Confirm Password --}}
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Confirm Password *</label>
                                                <input type="password" class="form-control" name="password_confirmation" required>
                                                @error('password_confirmation')
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