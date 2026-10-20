@php
    $user = Auth::guard('web')->check();
@endphp

<div class="card" dir="rtl">

    <ul class="list-group list-group-flush">

        <li class="list-group-item text-end {{ request()->routeIs('user.dashboard', 'agent.dashboard') ? 'active' : '' }}">

            <a href="{{ $user ? route('user.dashboard') : route('agent.dashboard') }}">
                لوحة التحكم
            </a>

        </li>

        @unless ($user)

            <li class="list-group-item text-end {{ request()->routeIs('agent.plan') ? 'active' : '' }}">

                <a href="{{ route('agent.plan') }}">
                    الخطة الفعالة
                </a>

            </li>

            <li class="list-group-item text-end {{ request()->routeIs('agent.orders', 'agent.invoice') ? 'active' : '' }}">

                <a href="{{ route('agent.orders') }}">
                    الطلبات
                </a>

            </li>

            <li class="list-group-item text-end {{ request()->routeIs(
                'agent.properties.index',
                'agent.properties.show',
                'agent.properties.edit',
                'agent.photo.gallery',
                'agent.video.gallery'
            ) ? 'active' : '' }}">

                <a href="{{ route('agent.properties.index') }}">
                    جميع العقارات
                </a>

            </li>

            <li class="list-group-item text-end {{ request()->routeIs('agent.properties.create') ? 'active' : '' }}">

                <a href="{{ route('agent.properties.create') }}">
                    إضافة عقار
                </a>

            </li>

        @endunless

        @if ($user)

            <li class="list-group-item text-end {{ request()->routeIs('user.wishlist') ? 'active' : '' }}">

                <a href="{{ route('user.wishlist') }}">
                    المفضلة
                </a>

            </li>

        @endif

        <li class="list-group-item text-end {{ request()->routeIs('user.edit.profile', 'agent.edit.profile') ? 'active' : '' }}">

            <a href="{{ $user ? route('user.edit.profile') : route('agent.edit.profile') }}">
                تعديل الملف الشخصي
            </a>

        </li>

        <li class="list-group-item logout text-end">

            <form action="{{ $user ? route('user.logout') : route('agent.logout') }}"
                  method="POST"
                  class="d-block m-0 p-0">

                @csrf

                <button type="submit"
                        class="nav-link w-100 text-end text-danger border-0 bg-transparent p-0 logout-btn"
                        style="margin: 8px 0 8px 15px; font-weight: bold;">

                    تسجيل الخروج

                </button>

            </form>

        </li>

    </ul>

</div>
