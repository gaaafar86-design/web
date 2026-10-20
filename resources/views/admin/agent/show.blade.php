@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Show Agent</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.agents.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left m-2"></i>Back</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="">Existing Photo</label>
                                        <div class="form-group">
                                            <img src="{{ $agent->photo ? asset('user-images/' . $agent->photo) : asset('user-images/default.png') }}" alt="Agent-image" class="user-photo w_200">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">Name</label>
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" value="{{ $agent->name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">Email</label>
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control" value="{{ $agent->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">Company</label>
                                        <div class="form-group">
                                            <input type="text" name="company" class="form-control" value="{{ $agent->company }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">Phone</label>
                                        <div class="form-group">
                                            <input type="text" name="phone" class="form-control" value="{{ $agent->phone }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">Designation</label>
                                        <div class="form-group">
                                            <input type="text" name="designation" class="form-control" value="{{ $agent->designation }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">Address</label>
                                        <div class="form-group">
                                            <input type="text" name="address" class="form-control" value="{{ $agent->address }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">Country</label>
                                        <div class="form-group">
                                            <input type="text" name="country" class="form-control" value="{{ $agent->country }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">State</label>
                                        <div class="form-group">
                                            <input type="text" name="state" class="form-control" value="{{ $agent->state }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">City</label>
                                        <div class="form-group">
                                            <input type="text" name="city" class="form-control" value="{{ $agent->city }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">Website</label>
                                        <div class="form-group">
                                            <input type="text" name="website" class="form-control" value="{{ $agent->website }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">Facebook</label>
                                        <div class="form-group">
                                            <input type="text" name="facebook" class="form-control" value="{{ $agent->facebook }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">Twitter</label>
                                        <div class="form-group">
                                            <input type="text" name="twitter" class="form-control" value="{{ $agent->twitter }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">Linkedin</label>
                                        <div class="form-group">
                                            <input type="text" name="linkedin" class="form-control" value="{{ $agent->linkedin }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="">Instagram</label>
                                        <div class="form-group">
                                            <input type="text" name="instagram" class="form-control" value="{{ $agent->instagram }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="">Biography</label>
                                        <div class="form-group">
                                            <textarea name="biography" class="form-control h_300" rows="5" disabled>{{ $agent->biography }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <a href="{{ route('admin.agents.edit', $agent) }}" class="btn btn-primary">Edit Agent</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
