@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Show Footer</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.footer.edit') }}" class="btn btn-primary"><i class="fas fa-edit m-2"></i>Edit</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="footer_address" value="{{ $footer->address }}" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="footer_email" value="{{ $footer->email }}" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" class="form-control" name="footer_phone" value="{{ $footer->phone }}" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Facebook</label>
                                    <input type="text" class="form-control" name="footer_facebook" value="{{ $footer->facebook }}" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Twitter</label>
                                    <input type="text" class="form-control" name="footer_twitter" value="{{ $footer->twitter }}" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="text" class="form-control" name="footer_linkedin" value="{{ $footer->linkedin }}" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Instagram</label>
                                    <input type="text" class="form-control" name="footer_instagram" value="{{ $footer->instagram }}" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Copyright</label>
                                    <input type="text" class="form-control" name="footer_copyright" value="{{ $footer->copyright }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
