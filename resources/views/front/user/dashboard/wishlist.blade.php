@extends('front.layouts.master')

@section('content')

    {{-- رأس الصفحة --}}
    <div dir="rtl">
    <div class="page-top"
         style="background-image: url({{ asset('website-images/cooo2.png') }})" >

        <div class="bg"></div>

        <div class="container">

            <div class="row">

                <div class="col-md-12">

                    <h2>العقارات المفضلة</h2>

                </div>

            </div>

        </div>

    </div>

    {{-- محتوى الصفحة --}}
    <div class="page-content user-panel">

        <div class="container">

            <div class="row">

                {{-- القائمة الجانبية --}}
                <div class="col-lg-3 col-md-12">

                    <x-dashboard />

                </div>

                {{-- جدول العقارات المفضلة --}}
                <div class="col-lg-9 col-md-12">

                    @if ($wishlistItems->count())

                        <div class="table-responsive">

                            <table class="table table-bordered text-center align-middle">

                                <tbody>

                                    <tr>

                                        <th>الرقم</th>
                                        <th>الصورة</th>
                                        <th>اسم العقار</th>
                                        <th>السعر</th>
                                        <th>الإجراء</th>

                                    </tr>

                                    @foreach ($wishlistItems as $wishlistItem)

                                        <tr>

                                            <td>
                                                {{ $loop->iteration }}
                                            </td>

                                            <td>

                                                <img src="{{ asset(
                                                    'property-images/' .
                                                    $wishlistItem->property->featured_photo
                                                ) }}"
                                                     class="w-150"
                                                     alt="صورة العقار">

                                            </td>

                                            <td>

                                                <a href="{{ route(
                                                    'property.detail',
                                                    $wishlistItem->property->slug
                                                ) }}"
                                                   style="color: inherit;">

                                                    {{ $wishlistItem->property->name }}

                                                </a>

                                            </td>

                                            <td>

                                                ${{ number_format(
                                                    $wishlistItem->property->price
                                                ) }}

                                            </td>

                                            <td>

                                                <form action="{{ route(
                                                    'user.remove.from.wishlist',
                                                    $wishlistItem
                                                ) }}"
                                                      method="POST"
                                                      style="display: inline;">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            title="إزالة من المفضلة">

                                                        <i class="fas fa-trash"></i>

                                                    </button>

                                                </form>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                            {{-- صفحات النتائج --}}
                            <div class="col-12 mt_30">

                                {{ $wishlistItems->links() }}

                            </div>

                        </div>

                    @else

                        <div class="alert alert-info text-center">

                            لا توجد عقارات مضافة إلى المفضلة حالياً.

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>
</div>
@endsection
