@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Forget Password</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h4 class="mb-4 text-center">Recover Your Password</h4>
                            <form action="{{ route('agent.forget.password.submit') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary bg-website">
                                        <i class="fas fa-unlock-alt me-2"></i> Submit
                                    </button>
                                </div>
                            </form>
                            <div class="text-center">
                                <a href="{{ route('agent.login') }}" class="text-decoration-none text-muted d-inline-block">
                                    Back to Login Page
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
