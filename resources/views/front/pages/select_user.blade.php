@extends('front.layouts.master')

@section('content')

<style>
    /*
    |--------------------------------------------------------------------------
    | صورة الغلاف
    |--------------------------------------------------------------------------
    */

    .customer-hero {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        background-color: #f5f5f5;
        text-align: center;
        line-height: 0;
    }

    .customer-hero img {
        display: block;
        width: 100%;
        max-width: 100%;
        height: auto;
        object-fit: contain;
    }

    /*
    |--------------------------------------------------------------------------
    | محتوى الصفحة
    |--------------------------------------------------------------------------
    */

    .customer-content {
        padding: 55px 15px 75px;
    }

    .customer-card {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
    }

    .customer-card .card-body {
        padding: 35px 25px;
    }

    .customer-card .customer-icon {
        font-size: 42px;
        color: #0d6efd;
        margin-bottom: 18px;
    }

    .customer-card .card-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 25px;
    }

    .customer-buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .customer-buttons .btn {
        width: 75%;
        min-height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        font-weight: 600;
        text-decoration: none;
    }

    /*
    |--------------------------------------------------------------------------
    | الموبايل
    |--------------------------------------------------------------------------
    */

    @media (max-width: 768px) {
        .customer-content {
            padding: 35px 15px 50px;
        }

        .customer-card .card-body {
            padding: 28px 18px;
        }

        .customer-card .card-title {
            font-size: 21px;
        }

        .customer-buttons .btn {
            width: 90%;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | الشاشات الصغيرة جداً
    |--------------------------------------------------------------------------
    */

    @media (max-width: 400px) {
        .customer-buttons .btn {
            width: 100%;
        }
    }
</style>


{{-- صورة الغلاف كاملة بدون قص --}}
<div class="customer-hero">
    <img src="{{ asset('website-images/co3.png') }}"
         alt="صفحة الزبون">
</div>


{{-- محتوى صفحة الزبون --}}
<div class="page-content customer-content">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-12 col-sm-10 col-md-7 col-lg-5">

                <div class="card customer-card shadow-sm text-center">

                    <div class="card-body">

                        {{-- أيقونة المستخدم --}}
                        <div class="customer-icon">
                            <i class="fas fa-user"></i>
                        </div>

                        {{-- العنوان --}}
                        <h5 class="card-title">
                            الزبون
                        </h5>

                        {{-- الأزرار المرتبطة --}}
                        <div class="customer-buttons">

                            {{-- زر إنشاء حساب --}}
                            <a href="{{ route('user.register') }}"
                               class="btn btn-outline-primary">

                                <i class="fas fa-user-plus ms-2"></i>
                                إنشاء حساب جديد

                            </a>

                            {{-- زر تسجيل الدخول --}}
                            <a href="{{ route('user.login') }}"
                               class="btn btn-primary">

                                <i class="fas fa-sign-in-alt ms-2"></i>
                                تسجيل الدخول

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
