@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Privacy Policy</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.privacy-policy.edit') }}" class="btn btn-primary"><i class="fas fa-edit m-2"></i>Edit</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label class="form-label">Content</label>
                                    <textarea style="resize: vertical; height: 700px;" name="content" class="form-control" disabled>{!! $policies->content !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
