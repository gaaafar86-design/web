<div class="navbar-area" id="stickymenu">

    {{-- القائمة على الهاتف --}}
    <div class="mobile-nav">

        <a href="{{ route('home') }}" class="logo">

            <img src="{{ asset('website-images/' . $setting->logo) }}"
                 alt="الشعار">

        </a>

    </div>

    {{-- القائمة الرئيسية --}}
    <div class="main-nav">

        <div class="container">

            <nav class="navbar navbar-expand-md navbar-light">

                {{-- الشعار --}}
                <a class="navbar-brand"
                   href="{{ route('home') }}">

                    <img src="{{ asset('website-images/' . $setting->logo) }}"
                         alt="الشعار">

                </a>

                <div class="collapse navbar-collapse mean-menu"
                     id="navbarSupportedContent">

                    <ul class="navbar-nav ml-auto">

                        {{-- الرئيسية --}}
                        <li class="nav-item">

                            <a href="{{ route('home') }}"
                               class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">

                                الرئيسية

                            </a>

                        </li>

                        {{-- العقارات --}}
                        <li class="nav-item">

                            <a href="{{ route('properties') }}"
                               class="nav-link {{ request()->routeIs('properties') ? 'active' : '' }}">

                                العقارات

                            </a>

                        </li>

                        {{-- الوكلاء --}}
                        <li class="nav-item">

                            <a href="{{ route('agents') }}"
                               class="nav-link {{ request()->routeIs('agents') ? 'active' : '' }}">

                                الوكلاء

                            </a>

                        </li>

                        {{-- المواقع --}}
                        <li class="nav-item">

                            <a href="{{ route('locations') }}"
                               class="nav-link {{ request()->routeIs('locations') ? 'active' : '' }}">

                                المواقع

                            </a>

                        </li>

                        {{-- الباقات --}}
                        <li class="nav-item">

                            <a href="{{ route('pricing') }}"
                               class="nav-link {{ request()->routeIs('pricing') ? 'active' : '' }}">

                                عروض مميزة 

                            </a>

                        </li>

                        {{-- الأسئلة الشائعة --}}
                        <li class="nav-item">

                            <a href="{{ route('faq') }}"
                               class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}">

                                الأسئلة الشائعة

                            </a>

                        </li>

                        {{-- المدونة --}}
                        <li class="nav-item">

                            <a href="{{ route('blog') }}"
                               class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}">

                                المدونة

                            </a>

                        </li>

                        {{-- تواصل معنا --}}
                        <li class="nav-item">

                            <a href="{{ route('contact') }}"
                               class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">

                                تواصل معنا

                            </a>

                        </li>

                        {{-- المستخدم --}}
                        @if (Auth::guard('web')->check())

                            <li class="nav-item">

                                <a href="{{ route('user.dashboard') }}"
                                   class="nav-link">

                                    لوحة المستخدم

                                </a>

                            </li>

                        @elseif (Auth::guard('agent')->check())

                            <li class="nav-item">

                                <a href="{{ route('agent.dashboard') }}"
                                   class="nav-link">

                                    لوحة الوكيل

                                </a>

                            </li>

                        @else

                            <li class="nav-item">

                                <a href="{{ route('select.user') }}"
                                   class="nav-link">

                                    تسجيل الدخول / إنشاء حساب

                                </a>

                            </li>

                        @endif

                    </ul>

                </div>

            </nav>

        </div>

    </div>

</div>
