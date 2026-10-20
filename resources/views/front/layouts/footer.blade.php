{{-- الفوتر --}}
<div class="footer" dir="rtl">

    <div class="container">

        <div class="row">

            {{-- روابط مهمة --}}
            <div class="col-lg-4 col-md-6">

                <div class="item">

                    <h2 class="heading">
                        روابط مهمة
                    </h2>

                    <ul class="useful-links">

                        <li>
                            <a href="{{ route('pricing') }}">
                                العروض والخدمات
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('properties') }}">
                                العقارات
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('agents') }}">
                                الوكلاء
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('blog') }}">
                                المدونة
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('contact') }}">
                                تواصل معنا
                            </a>
                        </li>

                    </ul>

                </div>

            </div>

            {{-- المناطق الأكثر طلباً --}}
            <div class="col-lg-4 col-md-6">

                @php
                    $popularLocations = App\Models\Location::withCount([
                        'properties' => function ($query) {
                            $query->where('status', 1);
                        }
                    ])
                    ->orderByDesc('properties_count')
                    ->take(4)
                    ->get();
                @endphp

                <div class="item">

                    <h2 class="heading">
                        المناطق الأكثر طلباً
                    </h2>

                    <ul class="useful-links">

                        @forelse ($popularLocations as $location)

                            <li>
                                <a href="{{ route('location.detail', $location->slug) }}">
                                    {{ $location->name }}
                                </a>
                            </li>

                        @empty

                            <li>
                                لا توجد مناطق مضافة حالياً
                            </li>

                        @endforelse

                    </ul>

                </div>

            </div>

            {{-- معلومات المكتب --}}
            <div class="col-lg-4 col-md-12">

                <div class="item">

                    <h2 class="heading">
                        معلومات المكتب
                    </h2>

                    {{-- العنوان --}}
                    <div class="list-item">

                        <div class="left">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>

                        <div class="right">
                            دمشق – كفرسوسة – دخلة صالة روفانا
                              

                            مقابل مسجد عمار بن ياسر
                              

                            جانب صيدلية عاشور
                        </div>

                    </div>

                    {{-- الرقم الأول --}}
                    <div class="list-item">

                        <div class="left">
                            <i class="fas fa-phone"></i>
                        </div>

                        <div class="right" dir="ltr">

                            <a href="tel:0962188849">
                                0962188849
                            </a>

                        </div>

                    </div>

                    {{-- الرقم الثاني --}}
                    <div class="list-item">

                        <div class="left">
                            <i class="fas fa-phone"></i>
                        </div>

                        <div class="right" dir="ltr">

                            <a href="tel:0948001996">
                                0948001996
                            </a>

                        </div>

                    </div>

                    {{-- الرقم الثالث --}}
                    <div class="list-item">

                        <div class="left">
                            <i class="fas fa-phone"></i>
                        </div>

                        <div class="right" dir="ltr">

                            <a href="tel:0948001993">
                                0948001993
                            </a>

                        </div>

                    </div>

                    {{-- البريد الإلكتروني الخاص بالمكتب --}}
                    @if ($footer->email)

                        <div class="list-item">

                            <div class="left">
                                <i class="fas fa-envelope"></i>
                            </div>

                            <div class="right" dir="ltr">

                                <a href="mailto:{{ $footer->email }}">
                                    {{ $footer->email }}
                                </a>

                            </div>

                        </div>

                    @endif

                    {{-- فيسبوك فقط --}}
                    <ul class="social">

                        <li>

                            <a href="https://www.facebook.com/p/%D8%B9%D9%8A%D9%84%D8%A9-%D8%A7%D9%84%D8%A7%D9%83%D8%A7%D8%A8%D8%B1-%D8%B6%D8%A7%D8%AD%D9%8A%D8%A9-%D8%A7%D9%84%D9%81%D9%8A%D8%AD%D8%A7%D8%A1-61593026756688/"
                               target="_blank"
                               rel="noopener noreferrer"
                               title="صفحة فيسبوك">

                                <i class="fab fa-facebook-f"></i>

                            </a>

                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- أسفل الفوتر --}}
<div class="footer-bottom" dir="rtl">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6 col-md-6">

                <div class="copyright">
                    {{ $footer->copyright }}
                </div>

            </div>

            <div class="col-lg-6 col-md-6">

                <div class="right">

                    <ul>

                        <li>
                            <a href="{{ route('terms' ) }}">
                                شروط الاستخدام
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('privacy.policy') }}">
                                سياسة الخصوصية
                            </a>
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- زر العودة إلى الأعلى --}}
<div class="scroll-top">
    <i class="fas fa-angle-up"></i>
</div>

<div id="loader"></div>

<script src="{{ asset('dist-front/js/custom.js') }}"></script>
<script src="{{ asset('dist-admin/js/iziToast.min.js') }}"></script>

{{-- رسالة نجاح --}}
@if (session('success'))

    <script>
        iziToast.success({
            message: @json(session('success')),
            position: 'topRight',
            timeout: 3000,
            progressBarColor: '#2ecc71',
            transitionIn: 'bounceInDown',
            transitionOut: 'fadeOutUp'
        });
    </script>

@endif

{{-- رسالة خطأ --}}
@if (session('error'))

    <script>
        iziToast.error({
            message: @json(session('error')),
            position: 'topRight',
            timeout: 3000,
            progressBarColor: '#FF0000',
            transitionIn: 'bounceInDown',
            transitionOut: 'fadeOutUp'
        });
    </script>

@endif
