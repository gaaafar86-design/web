@extends('admin.layouts.master')

@section('content')

<style>
    .faq-page {
        direction: rtl;
        text-align: right;
    }

    .faq-page .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .faq-page .section-header h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
    }

    .faq-page .card {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.07);
    }

    .faq-page .card-header {
        padding: 18px 22px;
        border-bottom: 1px solid #eeeeee;
        background: #ffffff;
    }

    .faq-page .card-header h4 {
        margin: 0;
        font-weight: 700;
    }

    .faq-page .form-label {
        font-weight: 600;
    }

    .faq-page .form-control {
        min-height: 46px;
        border-radius: 7px;
        text-align: right;
    }

    .faq-page textarea.form-control {
        min-height: 180px;
        resize: vertical;
    }

    .faq-page .back-button,
    .faq-page .submit-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border-radius: 7px;
        font-weight: 600;
    }

    .faq-page .help-box {
        padding: 14px 16px;
        border-right: 4px solid #0d6efd;
        border-radius: 6px;
        background: #f0f6ff;
        color: #555;
        line-height: 1.8;
    }

    @media (max-width: 768px) {
        .faq-page .section-header {
            align-items: stretch;
            flex-direction: column;
        }

        .faq-page .back-button {
            width: 100%;
        }
    }
</style>

<x-admin_navbar />
<x-admin_sidebar />

<div class="main-content faq-page">

    <section class="section">

        {{-- رأس الصفحة --}}
        <div class="section-header">

            <h1>
                إضافة سؤال شائع
            </h1>

            <a href="{{ route('admin.faq.index') }}"
               class="btn btn-primary back-button">

                <i class="fas fa-arrow-right"></i>
                العودة إلى الأسئلة الشائعة

            </a>

        </div>

        <div class="section-body">

            <div class="row justify-content-center">

                <div class="col-12 col-lg-9">

                    <div class="card">

                        <div class="card-header">
                            <h4>
                                تفاصيل السؤال والإجابة
                            </h4>
                        </div>

                        <div class="card-body">

                            <form action="{{ route('admin.faq.store') }}"
                                  method="POST">

                                @csrf

                                {{-- السؤال --}}
                                <div class="form-group mb-4">

                                    <label for="question"
                                           class="form-label">

                                        السؤال
                                        <span class="text-danger">*</span>

                                    </label>

                                    <input type="text"
                                           id="question"
                                           name="question"
                                           class="form-control"
                                           value="{{ old('question') }}"
                                           placeholder="اكتب السؤال هنا..."
                                           minlength="3"
                                           required>

                                    <small class="text-muted">
                                        يجب أن يكون السؤال 3 أحرف على الأقل.
                                    </small>

                                    @error('question')
                                        <small class="text-danger d-block mt-1">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>

                                {{-- الإجابة --}}
                                <div class="form-group mb-4">

                                    <label for="answer"
                                           class="form-label">

                                        الإجابة
                                        <span class="text-danger">*</span>

                                    </label>

                                    <textarea id="answer"
                                              name="answer"
                                              class="form-control h_200"
                                              rows="6"
                                              placeholder="اكتب الإجابة بالتفصيل هنا..."
                                              minlength="10"
                                              required>{{ old('answer') }}</textarea>

                                    <small class="text-muted">
                                        يجب أن تكون الإجابة 10 أحرف على الأقل.
                                    </small>

                                    @error('answer')
                                        <small class="text-danger d-block mt-1">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>

                                {{-- تنبيه --}}
                                <div class="help-box mb-4">

                                    <i class="fas fa-info-circle ml-1"></i>

                                    اكتب السؤال والإجابة بطريقة واضحة ومختصرة
                                    ليسهل على الزائر فهم المعلومات.

                                </div>

                                {{-- زر الحفظ --}}
                                <div class="text-start">

                                    <button type="submit"
                                            class="btn btn-primary submit-button">

                                        <i class="fas fa-save"></i>
                                        حفظ السؤال

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection
