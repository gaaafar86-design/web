@php
    $admin = Auth::guard('admin')->user();
    $adminPhoto = $admin?->photo;
    $unreadNotifications = $admin ? $admin->unreadNotifications()->latest()->take(8)->get() : collect();
    $unreadCount = $admin ? $admin->unreadNotifications()->count() : 0;
@endphp

<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right justify-content-end rightsidetop align-items-center">
        <li class="nav-item dropdown me-2">
            <a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="الإشعارات">
                <i class="fas fa-bell" style="font-size: 1.2rem; color: #fff;"></i>
                @if ($unreadCount > 0)
                    <span class="badge badge-danger" style="position:absolute; top:0; right:0; font-size:10px;">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end" style="min-width: 320px; max-height: 400px; overflow-y: auto;">
                <li class="dropdown-header d-flex justify-content-between">
                    <span>الإشعارات</span>
                    <a href="{{ route('admin.notifications.index') }}" class="small">عرض الكل</a>
                </li>
                <li><hr class="dropdown-divider"></li>
                @forelse ($unreadNotifications as $notification)
                    @php $data = $notification->data; @endphp
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('admin.notifications.read', $notification->id) }}">
                            <div class="small">
                                <strong>{{ $data['user_name'] ?? 'مستخدم' }}</strong>
                                أعجبه
                                <strong>{{ $data['property_name'] ?? 'عقار' }}</strong>
                            </div>
                            <div class="text-muted" style="font-size: 11px;">
                                {{ $data['user_phone'] ?? '' }} · {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </a>
                    </li>
                @empty
                    <li><span class="dropdown-item text-muted small">لا إشعارات جديدة</span></li>
                @endforelse
            </ul>
        </li>
        <li class="nav-link">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-warning">Front End</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img alt="image" src="{{ $adminPhoto ? asset('user-images/' . $adminPhoto) : asset('user-images/default.png') }}" class="rounded-circle-custom">
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('admin.edit.profile') }}"><i class="far fa-user"></i> Edit Profile</a></li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item" style="padding-left: 25px;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
