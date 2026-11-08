@extends('admin.layouts.master')

@section('content')

    <x-admin_navbar />
    <x-admin_sidebar />

    <style>
        .plans-page {
            direction: rtl;
        }

        .plans-page .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .plans-page .section-header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
        }

        .plans-page .create-plan-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
        }

        .plans-page .card {
            border: 0;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
        }

        .plans-page table {
            min-width: 850px;
        }

        .plans-page table thead th {
            padding: 15px 10px;
            background: #f8f9fa;
            color: #333;
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
            vertical-align: middle;
        }

        .plans-page table tbody td {
            padding: 13px 10px;
            vertical-align: middle;
        }

        .plans-page .plan-name {
            font-weight: 700;
            color: #333;
        }

        .plans-page .plan-price {
            color: #d92228;
            font-weight: 700;
            white-space: nowrap;
        }

        .plans-page .limit-badge {
            display: inline-block;
            min-width: 55px;
            padding: 5px 9px;
            border-radius: 20px;
            background: #eef4ff;
            color: #2459a6;
            font-size: 13px;
            font-weight: 600;
        }

        .plans-page .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }

        .plans-page .action-buttons .btn {
            width: 34px;
            height: 34px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .plans-page .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .plans-page .empty-state i {
            margin-bottom: 15px;
            color: #adb5bd;
        }

        @media (max-width: 768px) {
            .plans-page .section-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .plans-page .create-plan-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="main-content plans-page">

        <section class="section">

            {{-- رأس الصفحة --}}
            <div class="section-header">

                <h1>
                    إدارة العروض
                </h1>

                <a href="{{ route('admin.plans.create') }}"
                   class="btn btn-primary create-plan-btn">

                    <i class="fas fa-plus"></i>
                    إنشاء عرض جديد

                </a>

            </div>

            <div class="section-body">

                <div class="row">

                    <div class="col-12">

                        <div class="card">

                            <div class="card-header">
                                <h4 class="mb-0">
                                    جميع العروض المتاحة
                                </h4>
                            </div>

                            <div class="card-body">

                                @if ($plans->count() > 0)

                                    <div class="table-responsive">

                                        <table class="table table-bordered text-center align-middle"
                                               id="example1">

                                            <thead>
                                                <tr>
                                                    <th>الرقم</th>
                                                    <th>اسم العرض</th>
                                                    <th>السعر</th>
                                                    <th>مدة العرض</th>
                                                    <th>عدد العقارات</th>
                                                    <th>العقارات المميزة</th>
                                                    <th>الإجراءات</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                @foreach ($plans as $plan)

                                                    <tr>

                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>

                                                        <td>
                                                            <span class="plan-name">
                                                                {{ $plan->name }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <span class="plan-price">
                                                                ${{ number_format($plan->price) }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <span class="limit-badge">
                                                                {{ displayLimit($plan->allowed_days) }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <span class="limit-badge">
                                                                {{ displayLimit($plan->allowed_properties) }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <span class="limit-badge">
                                                                {{ displayLimit($plan->allowed_featured_properties) }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <div class="action-buttons">

                                                                {{-- تعديل العرض --}}
                                                                <a href="{{ route('admin.plans.edit', $plan->id) }}"
                                                                   class="btn btn-primary btn-sm"
                                                                   title="تعديل العرض">

                                                                    <i class="fas fa-edit"></i>

                                                                </a>

                                                                {{-- حذف العرض --}}
                                                                <form action="{{ route('admin.plans.destroy', $plan->id) }}"
                                                                      method="POST"
                                                                      class="d-inline"
                                                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا العرض؟');">

                                                                    @csrf
                                                                    @method('DELETE')

                                                                    <button type="submit"
                                                                            class="btn btn-danger btn-sm"
                                                                            title="حذف العرض">

                                                                        <i class="fas fa-trash"></i>

                                                                    </button>

                                                                </form>

                                                            </div>
                                                        </td>

                                                    </tr>

                                                @endforeach

                                            </tbody>

                                        </table>

                                    </div>

                                @else

                                    <div class="empty-state">

                                        <i class="fas fa-tags fa-3x"></i>

                                        <h4>
                                            لا توجد عروض حالياً
                                        </h4>

                                        <p class="text-muted">
                                            يمكنك إنشاء أول عرض من خلال الزر الموجود في أعلى الصفحة.
                                        </p>

                                        <a href="{{ route('admin.plans.create') }}"
                                           class="btn btn-primary">

                                            <i class="fas fa-plus ml-2"></i>
                                            إنشاء عرض جديد

                                        </a>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
