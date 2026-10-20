<div class="main-sidebar">

    <aside id="sidebar-wrapper">

        {{-- اسم لوحة التحكم --}}
        <div class="sidebar-brand">
            <a href="{{ route('admin.panel') }}">
                لوحة التحكم
            </a>
        </div>

        {{-- الاسم المختصر عند تصغير القائمة --}}
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.panel') }}">
                لوحة
            </a>
        </div>

        <ul class="sidebar-menu">

            {{-- الرئيسية --}}
            <li class="nav-item {{ request()->routeIs('admin.panel') ? 'active' : '' }}">

                <a class="nav-link"
                   href="{{ route('admin.panel') }}">

                    <i class="fas fa-tachometer-alt"></i>
                    <span>الرئيسية</span>

                </a>

            </li>

            {{-- الإشعارات --}}
            <li class="nav-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">

                <a class="nav-link"
                   href="{{ route('admin.notifications.index') }}">

                    <i class="fas fa-bell"></i>
                    <span>الإشعارات</span>

                </a>

            </li>

            {{-- الخطط --}}
            <li class="nav-item {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">

                <a class="nav-link"
                   href="{{ route('admin.plans.index') }}">

                    <i class="fas fa-chart-pie"></i>
                    <span>الخطط</span>

                </a>

            </li>

            {{-- قسم العقارات --}}
            <li class="nav-item dropdown
                {{ request()->routeIs(
                    'admin.locations.*',
                    'admin.property.types.*',
                    'admin.amenities.*',
                    'admin.properties.*'
                ) ? 'active' : '' }}">

                <a href="#"
                   class="nav-link has-dropdown">

                    <i class="fas fa-building"></i>
                    <span>قسم العقارات</span>

                </a>

                <ul class="dropdown-menu">

                    {{-- المواقع --}}
                    <li class="{{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">

                        <a class="nav-link"
                           href="{{ route('admin.locations.index') }}">

                            <i class="fas fa-angle-right"></i>
                            المواقع

                        </a>

                    </li>

                    {{-- أنواع العقارات --}}
                    <li class="{{ request()->routeIs('admin.property.types.*') ? 'active' : '' }}">

                        <a class="nav-link"
                           href="{{ route('admin.property.types.index') }}">

                            <i class="fas fa-angle-right"></i>
                            أنواع العقارات

                        </a>

                    </li>

                    {{-- المزايا --}}
                    <li class="{{ request()->routeIs('admin.amenities.*') ? 'active' : '' }}">

                        <a class="nav-link"
                           href="{{ route('admin.amenities.index') }}">

                            <i class="fas fa-angle-right"></i>
                            المزايا والخدمات

                        </a>

                    </li>

                    {{-- العقارات --}}
                    <li class="{{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">

                        <a class="nav-link"
                           href="{{ route('admin.properties.index') }}">

                            <i class="fas fa-angle-right"></i>
                            العقارات

                        </a>

                    </li>

                </ul>

            </li>

            {{-- المستخدمون --}}
            <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">

                <a class="nav-link"
                   href="{{ route('admin.users.index') }}">

                    <i class="fas fa-users"></i>
                    <span>المستخدمون</span>

                </a>

            </li>

            {{-- الوكلاء --}}
            <li class="nav-item {{ request()->routeIs('admin.agents.*') ? 'active' : '' }}">

                <a class="nav-link"
                   href="{{ route('admin.agents.index') }}">

                    <i class="fas fa-user-tie"></i>
                    <span>الوكلاء</span>

                </a>

            </li>

            {{-- الهيدر --}}
            <li class="{{ request()->routeIs('admin.header.*') ? 'active' : '' }}">

                <a class="nav-link"
                   href="{{ route('admin.header.show') }}">

                    <i class="fas fa-file"></i>
                    <span>رأس الصفحة</span>

                </a>

            </li>

            {{-- آراء العملاء --}}
            <li class="{{ request()->routeIs('admin.testimonial.*') ? 'active' : '' }}">

                <a class="nav-link"
                   href="{{ route('admin.testimonial.index') }}">

                    <i class="fas fa-comments"></i>
                    <span>آراء العملاء</span>

                </a>

            </li>

            {{-- لماذا تختارنا --}}
            <li class="{{ request()->routeIs('admin.why-choose-us.*') ? 'active' : '' }}">

                <a class="nav-link"
                   href="{{ route('admin.why-choose-us.index') }}">

                    <i class="fas fa-question-circle"></i>
                    <span>لماذا تختارنا</span>

                </a>

            </li>

            {{-- المدونة --}}
            <li class="{{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">

                <a class="nav-link"
                   href="{{ route('admin.blog.index') }}">

                    <i class="fas fa-blog"></i>
                    <span>المدونة</span>

                </a>

            </li>

            {{-- الأسئلة الشائعة --}}
            <li class="{{ request()->routeIs('admin.faq.*') ? 'active' : '' }}">

                <a class="nav-link"
                   href="{{ route('admin.faq.index') }}">

                    <i class="fas fa-question"></i>
                    <span>الأسئلة الشائعة</span>

                </a>

            </li>

          

           

            {{-- الإعدادات --}}
            <li class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">

                <a class="nav-link"
                   href="{{ route('admin.settings.show') }}">

                    <i class="fas fa-cog"></i>
                    <span>الإعدادات</span>

                </a>

            </li>

            {{-- تذييل الصفحة --}}
            <li class="{{ request()->routeIs('admin.footer.*') ? 'active' : '' }}">

                <a class="nav-link"
                   href="{{ route('admin.footer.show') }}">

                    <i class="fas fa-th-large"></i>
                    <span>تذييل الصفحة</span>

                </a>

            </li>

        </ul>

    </aside>

</div>
