@extends('admin.layouts.master')

@section('content')

<style>
    .notifications-page {
        direction: rtl;
        text-align: right;
    }

    .notifications-page .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 25px;
    }

    .notifications-page .section-header h1 {
        margin: 0;
        color: #252525;
        font-size: 26px;
        font-weight: 700;
    }

    .notification-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .notification-action-form {
        margin: 0;
    }

    .mark-all-btn,
    .delete-all-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border-radius: 7px;
        font-weight: 600;
        white-space: nowrap;
    }

    .notifications-card {
        overflow: hidden;
        border: 0;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
    }

    .notifications-card .card-header {
        padding: 18px 22px;
        border-bottom: 1px solid #eeeeee;
        background: #ffffff;
    }

    .notifications-card .card-header h4 {
        margin: 0;
        color: #333333;
        font-size: 18px;
        font-weight: 700;
    }

    .notification-item {
        display: flex;
        align-items: center;
        gap: 15px;
        min-height: 95px;
        padding: 18px 22px;
        border-bottom: 1px solid #eeeeee;
        background: #ffffff;
    }

    .notification-item:last-child {
        border-bottom: 0;
    }

    .notification-item.unread {
        border-right: 4px solid #d92228;
        background: #fff6f6;
    }

    .notification-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 48px;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #ffe9e9;
        color: #d92228;
        font-size: 20px;
    }

    .notification-content {
        flex: 1;
        min-width: 0;
        color: #444444;
        line-height: 1.8;
    }

    .notification-content strong {
        color: #d92228;
        font-weight: 700;
    }

    .notification-name {
        color: #333333 !important;
    }

    .notification-details {
        margin-top: 5px;
        color: #777777;
        font-size: 13px;
    }

    .notification-time {
        margin-top: 3px;
        color: #999999;
        font-size: 12px;
    }

    .unread-badge {
        display: inline-block;
        margin-right: 8px;
        padding: 3px 9px;
        border-radius: 20px;
        background: #d92228;
        color: #ffffff;
        font-size: 11px;
        line-height: 1.5;
    }

    .notification-type {
        display: inline-block;
        margin-right: 8px;
        padding: 3px 9px;
        border-radius: 20px;
        color: #ffffff;
        font-size: 11px;
        line-height: 1.5;
    }

    .notification-type.plan {
        background: #0d6efd;
    }

    .notification-type.property {
        background: #6c757d;
    }

    .empty-notifications {
        padding: 70px 20px;
        color: #888888;
        text-align: center;
    }

    .empty-notifications i {
        display: block;
        margin-bottom: 15px;
        color: #c7c7c7;
        font-size: 45px;
    }

    .empty-notifications h4 {
        margin-bottom: 8px;
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .notifications-page .section-header {
            align-items: stretch;
            flex-direction: column;
        }

        .notification-actions {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }

        .notification-action-form,
        .mark-all-btn,
        .delete-all-btn {
            width: 100%;
        }

        .notification-item {
            align-items: flex-start;
            padding: 16px 14px;
        }

        .notification-icon {
            flex-basis: 42px;
            width: 42px;
            height: 42px;
            font-size: 17px;
        }

        .notification-details {
            line-height: 2;
        }
    }
</style>

<x-admin_navbar />
<x-admin_sidebar />

<div class="main-content notifications-page">

    <section class="section">

        {{-- رأس الصفحة --}}
        <div class="section-header">

            <h1>
                الإشعارات
            </h1>

            <div class="notification-actions">

                {{-- تعليم الكل كمقروء --}}
                <form action="{{ route('admin.notifications.read.all') }}"
                      method="POST"
                      class="notification-action-form">

                    @csrf

                    <button type="submit"
                            class="btn btn-primary btn-sm mark-all-btn">

                        <i class="fas fa-check-double"></i>
                        تعليم الكل كمقروء

                    </button>

                </form>

                {{-- حذف جميع الإشعارات --}}
                <form action="{{ route('admin.notifications.delete.all') }}"
                      method="POST"
                      class="notification-action-form"
                      onsubmit="return confirm('هل أنت متأكد من حذف جميع الإشعارات؟');">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger btn-sm delete-all-btn">

                        <i class="fas fa-trash-alt"></i>
                        مسح الإشعارات

                    </button>

                </form>

            </div>

        </div>

        <div class="section-body">

            <div class="card notifications-card">

                <div class="card-header">

                    <h4>
                        آخر إشعارات المستخدمين
                    </h4>

                </div>

                <div class="card-body p-0">

                    @forelse ($notifications as $notification)

                        @php
                            $data = is_array($notification->data)
                                ? $notification->data
                                : json_decode($notification->data, true);

                            $data = is_array($data) ? $data : [];

                            $notificationType = $data['type'] ?? 'property_inquiry';

                            $isPlanNotification =
                                $notificationType === 'plan_selected';

                            $isUnread = is_null($notification->read_at);
                        @endphp

                        <div class="notification-item {{ $isUnread ? 'unread' : '' }}">

                            {{-- أيقونة الإشعار --}}
                            <div class="notification-icon">

                                @if ($isPlanNotification)
                                    <i class="fas fa-tags"></i>
                                @else
                                    <i class="fas fa-heart"></i>
                                @endif

                            </div>

                            {{-- محتوى الإشعار --}}
                            <div class="notification-content">

                                @if ($isPlanNotification)

                                    {{-- إشعار اختيار العرض --}}

                                    <div>

                                        <strong class="notification-name">
                                            {{ $data['user_name'] ?? 'مستخدم' }}
                                        </strong>

                                        <span>
                                            اختار العرض:
                                        </span>

                                        <strong>
                                            {{ $data['plan_name'] ?? 'عرض غير محدد' }}
                                        </strong>

                                        <span class="notification-type plan">
                                            طلب عرض
                                        </span>

                                        @if ($isUnread)
                                            <span class="unread-badge">
                                                جديد
                                            </span>
                                        @endif

                                    </div>

                                @else

                                    {{-- إشعار العقار القديم --}}

                                    <div>

                                        <strong class="notification-name">
                                            {{ $data['user_name'] ?? 'مستخدم' }}
                                        </strong>

                                        <span>
                                            أعجب بالعقار:
                                        </span>

                                        <strong>
                                            {{ $data['property_name'] ?? 'عقار غير محدد' }}
                                        </strong>

                                        <span class="notification-type property">
                                            عقار
                                        </span>

                                        @if ($isUnread)
                                            <span class="unread-badge">
                                                جديد
                                            </span>
                                        @endif

                                    </div>

                                @endif

                                {{-- رقم الهاتف والإيميل --}}
                                <div class="notification-details">

                                    <span dir="ltr">
                                        <i class="fas fa-phone ms-1"></i>
                                        {{ $data['user_phone'] ?? '-' }}
                                    </span>

                                    <span class="mx-2">|</span>

                                    <span dir="ltr">
                                        <i class="fas fa-envelope ms-1"></i>
                                        {{ $data['user_email'] ?? '-' }}
                                    </span>

                                </div>

                                {{-- وقت الإشعار --}}
                                <div class="notification-time">

                                    <i class="far fa-clock ms-1"></i>
                                    {{ $notification->created_at->diffForHumans() }}

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="empty-notifications">

                            <i class="far fa-bell-slash"></i>

                            <h4>
                                لا توجد إشعارات حالياً
                            </h4>

                            <p class="mb-0">
                                ستظهر هنا إشعارات المستخدمين الجديدة.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

            {{-- ترقيم الصفحات --}}
            @if ($notifications->hasPages())

                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>

            @endif

        </div>

    </section>

</div>

@endsection
