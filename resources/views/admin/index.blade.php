@extends('admin.layouts.master')

@section('content')

    <x-admin_navbar />
    <x-admin_sidebar />

    <div class="main-content">

        <section class="section">

            <div class="section-header">
                <h1>لوحة التحكم</h1>
            </div>

            <div class="row">

                {{-- إجمالي العروض --}}
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">

                    <div class="card card-statistic-1">

                        <div class="card-icon bg-primary">
                            <i class="fas fa-tags"></i>
                        </div>

                        <div class="card-wrap">

                            <div class="card-header">
                                <h4>إجمالي العروض</h4>
                            </div>

                            <div class="card-body">
                                {{ $totalPackages }}
                            </div>

                        </div>

                    </div>

                </div>

                {{-- إجمالي الأخبار --}}
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">

                    <div class="card card-statistic-1">

                        <div class="card-icon bg-danger">
                            <i class="fas fa-newspaper"></i>
                        </div>

                        <div class="card-wrap">

                            <div class="card-header">
                                <h4>إجمالي الأخبار</h4>
                            </div>

                            <div class="card-body">
                                {{ $postCount }}
                            </div>

                        </div>

                    </div>

                </div>

                {{-- إجمالي المستخدمين --}}
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">

                    <div class="card card-statistic-1">

                        <div class="card-icon bg-warning">
                            <i class="fas fa-users"></i>
                        </div>

                        <div class="card-wrap">

                            <div class="card-header">
                                <h4>إجمالي المستخدمين</h4>
                            </div>

                            <div class="card-body">
                                {{ $totalUsers }}
                            </div>

                        </div>

                    </div>

                </div>

                {{-- إجمالي العقارات --}}
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">

                    <div class="card card-statistic-1">

                        <div class="card-icon bg-danger">
                            <i class="fas fa-home"></i>
                        </div>

                        <div class="card-wrap">

                            <div class="card-header">
                                <h4>إجمالي العقارات</h4>
                            </div>

                            <div class="card-body">
                                {{ $totalProperties }}
                            </div>

                        </div>

                    </div>

                </div>

               
        </section>

    </div>

@endsection
