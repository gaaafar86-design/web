@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Show FAQ</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.faq.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left m-2"></i>Back</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label class="form-label">Question</label>
                                    <input type="text" class="form-control" name="question" value="{{ $faq->question }}" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Answer</label>
                                    <textarea name="answer" class="form-control h_200" disabled>{{ $faq->answer }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
