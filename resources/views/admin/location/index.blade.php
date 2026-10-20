@extends('admin.layouts.master')

@section('content')

    <x-admin_navbar />
    <x-admin_sidebar />

    <div class="main-content">

        <section class="section">

            <div class="section-header d-flex justify-content-between align-items-center">

                <h1>
                    المواقع
                </h1>

                <div class="ml-auto">
                    <a href="{{ route('admin.locations.create') }}"
                       class="btn btn-primary">

                        <i class="fas fa-plus ml-2"></i>
                        إضافة موقع

                    </a>
                </div>

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
                                                <th>الرقم</th>
                                                <th>الصورة</th>
                                                <th>اسم الموقع</th>
                                                <th>عدد العقارات</th>
                                                <th>الإجراءات</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($locations as $location)

                                                <tr>

                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>

                                                    <td>
                                                        <img src="{{ asset('location-images/' . $location->photo) }}"
                                                             class="w_150"
                                                             alt="{{ $location->name }}">
                                                    </td>

                                                    <td>
                                                        {{ $location->name }}
                                                    </td>

                                                    <td>
                                                        {{ $location->properties_count }}
                                                    </td>

                                                    <td>

                                                        <a href="{{ route('admin.locations.edit', $location) }}"
                                                           class="btn btn-primary btn-sm"
                                                           title="تعديل الموقع">

                                                            <i class="fas fa-edit"></i>

                                                        </a>

                                                        <form action="{{ route('admin.locations.destroy', $location) }}"
                                                              method="POST"
                                                              style="display: inline;">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                    class="btn btn-danger btn-sm"
                                                                    title="حذف الموقع"
                                                                    onclick="return confirm('هل أنت متأكد من حذف هذا الموقع؟');">

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
