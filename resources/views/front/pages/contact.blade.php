@extends('front.layouts.master')

@section('content')

<style>
     .facebook-qr-item {
        display: flex;
        align-items: center;
        margin-right: 12px;
    }

    .facebook-qr-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        text-align: center;
    }

    .facebook-qr-title {
        display: block;
        color: #1877f2;
        font-size: 10px;
        font-weight: 700;
        line-height: 1.3;
        white-space: nowrap;
    }

    .facebook-qr-image {
        display: block;
        width: 44px;
        height: 44px;
        padding: 3px;
        border-radius: 5px;
        background: #ffffff;
        object-fit: contain;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18 );
        transition: 0.25s ease;
    }

    .facebook-qr-image:hover {
        transform: scale(1.08);
        box-shadow: 0 4px 12px rgba(24, 119, 242, 0.35);
    }

    @media (max-width: 991px) {
        .facebook-qr-item {
            justify-content: center;
            margin: 10px 0;
        }

        .facebook-qr-title {
            font-size: 12px;
        }

        .facebook-qr-image {
            width: 52px;
            height: 52px;
        }
    }
    .contact-page {
        direction: rtl;
    }

    .contact-page .contact-form,
    .contact-page .office-info,
    .contact-page .map-box {
        width: 100%;
        border-radius: 12px;
    }

    .contact-page .form-control,
    .contact-page .form-select {
        min-height: 46px;
        border-radius: 7px;
        direction: rtl;
        text-align: right;
    }

    .contact-page textarea.form-control {
        min-height: 130px;
        resize: vertical;
    }

    .contact-page .map-box {
        min-height: 470px;
        overflow: hidden;
        background: #f1f1f1;
    }

    .contact-page .map-box iframe {
        display: block;
        width: 100%;
        height: 470px;
        min-height: 470px;
        border: 0;
    }

    .contact-page .contact-form {
        height: 100%;
    }

    .contact-page .btn-send {
        min-height: 48px;
        border: 0;
        border-radius: 7px;
        font-weight: 700;
    }

    .contact-page .office-info {
        line-height: 1.9;
    }

    .contact-page .contact-icon {
        width: 28px;
        color: #d92228;
        text-align: center;
    }

    @media (max-width: 991px) {
        .contact-page .map-box {
            min-height: 360px;
        }

        .contact-page .map-box iframe {
            height: 360px;
            min-height: 360px;
        }
    }

    @media (max-width: 575px) {
        .contact-page {
            padding-top: 25px;
            padding-bottom: 25px;
        }

        .contact-page .contact-form,
        .contact-page .office-info {
            padding: 20px !important;
        }

        .contact-page .map-box {
            min-height: 300px;
        }

        .contact-page .map-box iframe {
            height: 300px;
            min-height: 300px;
        }

        .page-top h2 {
            font-size: 25px;
        }
    }
</style>

{{-- رأس الصفحة --}}
<style>
    .office-page-top {
        min-height: 280px !important;
        height: 280px !important;
        background-size: contain !important;
        background-position: center center !important;
        background-repeat: no-repeat !important;
        background-color: #f5f5f5;
    }

    @media (max-width: 768px) {
        .office-page-top {
            min-height: 200px !important;
            height: 200px !important;
        }
    }
</style>

<div class="page-top office-page-top"
     style="background-image: url('{{ asset('website-images/coooo2.png') }}');">

    <div class="bg"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>تواصل معنا</h2>
            </div>
        </div>
    </div>

</div>


{{-- محتوى الصفحة --}}
<div class="page-content contact-page py-5">

    <div class="container">

        <div class="row g-4 align-items-stretch">

            {{-- نموذج التواصل --}}
            <div class="col-12 col-lg-6">

                <div class="contact-form p-4 border rounded shadow-sm bg-light">

                    <h4 class="mb-3"
                        style="color: #d92228; font-weight: 700;">
               QR
                    </h4>

                    <p class="text-muted mb-4">
                     قم بزيارة موقعنا على فيس بوك من خلال مسح الرابط التالي
                    </p>

                    <li class="nav-item facebook-qr-item">

    <div class="facebook-qr-box">

        <span class="facebook-qr-title">
            امسح لزيارة موقع فيسبوك
        </span>

        <a href="https://www.facebook.com/p/%D8%B9%D9%8A%D9%84%D8%A9-%D8%A7%D9%84%D8%A7%D9%83%D8%A7%D8%A8%D8%B1-%D8%B6%D8%A7%D8%AD%D9%8A%D8%A9-%D8%A7%D9%84%D9%81%D9%8A%D8%AD%D8%A7%D8%A1-61593026756688/"
           target="_blank"
           rel="noopener noreferrer"
           title="زيارة صفحة فيسبوك">

            <img src="{{ asset('website-images/facebook-qr.png' ) }}"
                 alt="رمز QR لصفحة فيسبوك"
                 class="facebook-qr-image">

        </a>

    </div>

</li>
                </div>
            </div>

            {{-- الخريطة والمعلومات --}}
            <div class="col-12 col-lg-6">

                <div class="d-flex flex-column gap-4 h-100">

                    {{-- معلومات المكتب --}}
                    {{-- معلومات المكتب --}}
<div class="office-info p-4 border rounded shadow-sm bg-white">

    <h4 class="mb-3"
        style="color: #d92228; font-weight: 700;">

        موقع مكتبنا

    </h4>

    <p class="text-muted mb-3">

        نحن جاهزون لمساعدتك في اختيار العقار المناسب للسكن أو الاستثمار
        في دمشق وريف دمشق، وتقديم خدمات الوساطة العقارية والإكساء والتعهدات.
        يمكنكم زيارة مكتبنا في دمشق – كفرسوسة.

    </p>

    <div class="mb-2">

        <i class="fas fa-map-marker-alt contact-icon ms-2"></i>

        دمشق – كفرسوسة – دخلة صالة روفانا

          


        <span style="margin-right: 34px;">
            مقابل مسجد عمار بن ياسر – جانب صيدلية عاشور
        </span>

    </div>

    <div class="mb-2" dir="ltr">

        <i class="fas fa-phone contact-icon ms-2"></i>

        +963 0962188849

    </div>
    <div class="mb-2" dir="ltr">

        <i class="fas fa-phone contact-icon ms-2"></i>

        +963 0948001996

    </div>
    <div class="mb-2" dir="ltr">

        <i class="fas fa-phone contact-icon ms-2"></i>

        +963 0948001993

    </div>

    <div>

        <i class="fas fa-clock contact-icon ms-2"></i>

        السبت – الخميس، 9 صباحاً – 6 مساءً

    </div>

</div>


                    {{-- الخريطة --}}
                    <div class="map-box border rounded shadow-sm flex-grow-1">

                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1876.325846781023!2d36.14649982453419!3d33.52554679051106!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1518d90035775be9%3A0x4d653740877cdfb3!2z2LbYp9it2YrYqSDYp9mE2YHZitit2KfYoQ!5e1!3m2!1sen!2smx!4v1791623099110!5m2!1sen!2smx"
                            title="موقع ضاحية الفيحاء - ريف دمشق"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>

@endsection
