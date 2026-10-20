@extends('front.layouts.master')

@section('content')

    <style>
        /*
        |--------------------------------------------------------------------------
        | صورة رأس صفحة العروض فقط
        |--------------------------------------------------------------------------
        */
        .pricing-page-top {
            min-height: 280px !important;
            height: 280px !important;
            background-size: contain !important;
            background-position: center center !important;
            background-repeat: no-repeat !important;
            background-color: #f5f5f5;
        }

        /*
        |--------------------------------------------------------------------------
        | اتجاه صفحة العروض
        |--------------------------------------------------------------------------
        */
        .pricing-page {
            direction: rtl;
            text-align: right;
        }

        .pricing-page .card {
            height: 100%;
            overflow: hidden;
        }

        .pricing-page .card-body {
            text-align: right;
        }

        .pricing-page .card-title,
        .pricing-page .card-price,
        .pricing-page .card-day {
            text-align: center;
        }

        .pricing-page .card-price {
            direction: ltr;
        }

        .pricing-page .fa-ul {
            margin-right: 2.14285714em;
            margin-left: 0;
            padding-right: 0;
        }

        .pricing-page .fa-li {
            right: -2.14285714em;
            left: auto;
        }

        .pricing-page .buy button {
            min-height: 46px;
            border-radius: 6px;
        }

        @media (max-width: 768px) {
            .pricing-page-top {
                min-height: 200px !important;
                height: 200px !important;
            }

            .pricing-page {
                margin-top: 25px !important;
                margin-bottom: 25px !important;
            }
        }
    </style>

    {{-- رأس الصفحة --}}
    <div class="page-top pricing-page-top"
         style="background-image: url('{{ asset('website-images/c00.png') }}');">

        <div class="bg"></div>

        <div class="container">

            <div class="row">

                <div class="col-md-12">

                    <h2>
                        العروض والخدمات
                    </h2>

                </div>

            </div>

        </div>

    </div>

    {{-- محتوى الصفحة --}}
    <div class="page-content pricing pricing-page"
         style="margin: 40px 0;">

        <div class="container">

            <div class="row pricing">

                @foreach ($plans as $plan)

                    <div class="col-lg-4 col-md-6 mb_30">

                        <div class="card mb-5 mb-lg-0">

                            <div class="card-body">

                                {{-- اسم العرض --}}
                                <h2 class="card-title">
                                    {{ $plan->name }}
                                </h2>

                                {{-- السعر --}}
                                <h3 class="card-price">
                                    ${{ number_format($plan->price) }}
                                </h3>

                                {{-- مدة العرض --}}
                                <h4 class="card-day text-center">

                                    {{
                                        $plan->allowed_days == '-1'
                                            ? 'غير محدود'
                                            : $plan->allowed_days . ' يوم'
                                    }}

                                </h4>

                                <hr>

                                <ul class="fa-ul">

                                    {{-- عدد العقارات --}}
                                    <li>

                                        <span class="fa-li">
                                            <i class="{{ displayIcon(
                                                $plan->allowed_properties,
                                                'fas fa-check',
                                                'fas fa-times'
                                            ) }}"></i>
                                        </span>

                                        {{ formatLimit(
                                            $plan->allowed_properties,
                                            'عقار'
                                        ) }}

                                    </li>

                                    {{-- العقارات المميزة --}}
                                    <li>

                                        <span class="fa-li">
                                            <i class="{{ displayIcon(
                                                $plan->allowed_featured_properties,
                                                'fas fa-check',
                                                'fas fa-times'
                                            ) }}"></i>
                                        </span>

                                        {{ formatLimit(
                                            $plan->allowed_featured_properties,
                                            'عقار مميز'
                                        ) }}

                                    </li>


                                </ul>

                                {{-- زر الاشتراك --}}
                                <div class="buy">

                                    <form action="{{ route(
                                        'agent.payment.send',
                                        $plan
                                    ) }}"
                                          method="POST">

                                        @csrf

                                        <button type="submit"
                                                class="btn btn-primary"
                                                style="
                                                    width: 100%;
                                                    background-color: #d92228;
                                                    border: none;
                                                    font-weight: 500;
                                                ">

                                            اختيار العرض

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

                {{-- لا توجد عروض --}}
                @if ($plans->isEmpty())

                    <div class="col-12 text-center my-5">

                        <h4 class="text-muted">
                            لا توجد عروض متاحة حالياً.
                        </h4>

                        <p>
                            يرجى العودة لاحقاً أو التواصل مع المكتب
                            لمزيد من المعلومات.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection
