@extends('front.layouts.master')

@section('content')

<div dir="rtl">

    <div class="page-top"
         style="
            background-image: url('{{ asset('website-images/coo2.jpg') }}');
            background-size: 100% auto;
            background-position: center center;
            background-repeat: no-repeat;
            min-height: 260px;
         ">

        <div class="bg"></div>

        <div class="container">

            <div class="row">

                <div class="col-md-12">

                    <h2>لوحة المستخدم</h2>

                </div>

            </div>

        </div>

    </div>

      

      

</br>
</br>

    <div class="d-flex justify-content-center mb-4">

        <a href="{{ route('properties') }}"
           class="btn btn-primary bg-website">

            <i class="fas fa-building ms-2"></i>
            عرض الشقق المتاحة

        </a>

    </div>

    <div class="page-content user-panel">

        <div class="container">

            <div class="row">

                <div class="col-lg-3 col-md-12">

                    <x-dashboard />

                </div>

                <div class="col-lg-9 col-md-12">

                    <h3>
                        مرحباً {{ $user->name }}
                    </h3>

                    <p>
                        يمكنك من هنا مشاهدة العقارات التي أضفتها إلى المفضلة.
                    </p>

                    <h3 class="mt-5">
                        العقارات التي أعجبتك
                    </h3>

                    <div class="table-responsive">

                        <table class="table table-bordered text-center align-middle">

                            <tbody>

                                <tr>

                                    <th>
                                        الرقم
                                    </th>

                                    <th>
                                        الصورة
                                    </th>

                                    <th>
                                        اسم العقار
                                    </th>

                                    <th>
                                        السعر
                                    </th>

                                    <th>
                                        الإجراء
                                    </th>

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
                                                        title="حذف من المفضلة">

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

@endsection
