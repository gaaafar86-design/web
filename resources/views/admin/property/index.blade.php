@extends('admin.layouts.master')

@section('content')

    <x-admin_navbar />
    <x-admin_sidebar />

    <div class="main-content">

        <section class="section">

            <div class="section-header d-flex justify-content-between align-items-center">

                <h1>
                    العقارات
                </h1>

                <a href="{{ route('admin.properties.create') }}"
                   class="btn btn-primary">

                    <i class="fas fa-plus me-1"></i>
                    إضافة عقار

                </a>

            </div>

            <div class="section-body">

                <div class="row">

                    <div class="col-12">

                        <div class="card">

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered text-center align-middle"
                                           id="example1">

                                        <thead>

                                            <tr>

                                                <th>
                                                    الرقم
                                                </th>

                                                <th>
                                                    الصورة الرئيسية
                                                </th>

                                                <th>
                                                    الوكيل
                                                </th>

                                                <th>
                                                    المنطقة
                                                </th>

                                                <th>
                                                    النوع
                                                </th>

                                                <th>
                                                    اسم العقار
                                                </th>

                                                <th>
                                                    حالة العقار
                                                </th>

                                                <th>
                                                    حالة النشر
                                                </th>

                                                <th>
                                                    الإجراءات
                                                </th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach ($properties as $property)

                                                <tr>

                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>

                                                    <td>

                                                        <img src="{{ asset(
                                                            'property-images/' .
                                                            $property->featured_photo
                                                        ) }}"
                                                             alt="صورة العقار"
                                                             class="profile-photo w_100">

                                                    </td>

                                                    <td>
                                                        {{ $property->agent->name ?? '-' }}
                                                    </td>

                                                    <td>
                                                        {{ $property->location->name ?? '-' }}
                                                    </td>

                                                    <td>
                                                        {{ $property->propertyType->name ?? '-' }}
                                                    </td>

                                                    <td>
                                                        {{ $property->name }}
                                                    </td>

                                                    {{-- Available / Sold --}}
                                                    <td>

                                                        @if ($property->purpose === 'Available')

                                                            <span class="badge bg-success">
                                                                متوفر
                                                            </span>

                                                        @else

                                                            <span class="badge bg-danger">
                                                                غير متوفر
                                                            </span>

                                                        @endif

                                                    </td>

                                                    {{-- status: منشور أو قيد المراجعة --}}
                                                    <td>

                                                        <span class="badge {{
                                                            displayIcon(
                                                                $property->status,
                                                                'bg-success',
                                                                'bg-warning'
                                                            )
                                                        }}">

                                                            {{ $property->status
                                                                ? 'منشور'
                                                                : 'قيد المراجعة'
                                                            }}

                                                        </span>

                                                    </td>

                                                    <td>

                                                        {{-- عرض --}}
                                                        <a href="{{ route(
                                                            'admin.properties.show',
                                                            $property
                                                        ) }}"
                                                           class="btn btn-primary btn-sm"
                                                           title="عرض">

                                                            <i class="fas fa-eye"></i>

                                                        </a>

                                                        {{-- تعديل --}}
                                                        <a href="{{ route(
                                                            'admin.properties.edit',
                                                            $property
                                                        ) }}"
                                                           class="btn btn-primary btn-sm"
                                                           title="تعديل">

                                                            <i class="fas fa-edit"></i>

                                                        </a>

                                                        {{-- نشر العقار --}}
                                                        @unless ($property->status)

                                                            <form action="{{ route(
                                                                'admin.properties.make.active',
                                                                $property
                                                            ) }}"
                                                                  method="POST"
                                                                  style="display: inline;">

                                                                @csrf

                                                                <button type="submit"
                                                                        class="btn btn-success btn-sm"
                                                                        title="نشر العقار">

                                                                    <i class="fas fa-check"></i>

                                                                </button>

                                                            </form>

                                                        @endunless

                                                        {{-- حذف --}}
                                                        <form action="{{ route(
                                                            'admin.properties.destroy',
                                                            $property
                                                        ) }}"
                                                              method="POST"
                                                              style="display: inline;">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                    class="btn btn-danger btn-sm"
                                                                    title="حذف"
                                                                    onclick="return confirm('هل أنت متأكد من حذف العقار؟');">

                                                                <i class="fas fa-trash"></i>

                                                            </button>

                                                        </form>

                                                    </td>

                                                </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
