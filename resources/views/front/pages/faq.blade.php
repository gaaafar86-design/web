@extends('front.layouts.master')
@section('content')
    <style>
    .faq-page-top {
        min-height: 280px !important;
        height: 280px !important;
        background-size: contain !important;
        background-position: center center !important;
        background-repeat: no-repeat !important;
        background-color: #f5f5f5;
    }

    @media (max-width: 768px) {
        .faq-page-top {
            min-height: 200px !important;
            height: 200px !important;
        }
    }
</style>

<div class="page-top faq-page-top"
     style="background-image: url('{{ asset('website-images/coooooo2.jpg') }}');">

    <div class="bg"></div>

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <h2>الأسئلة الشائعة</h2>

            </div>

        </div>

    </div>

</div>

    <div class="page-content faq">
        <div class="container">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="accordion" id="accordionExample">
                        @foreach ($faqs as $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading_{{ $loop->iteration }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapse_{{ $loop->iteration }}">
                                        {!! $faq->question !!}
                                    </button>
                                </h2>
                                <div id="collapse_{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ $loop->iteration }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
