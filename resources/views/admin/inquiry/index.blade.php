@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>طلبات التواصل (Inquiries)</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>التاريخ</th>
                                                <th>العميل</th>
                                                <th>الهاتف</th>
                                                <th>العقار</th>
                                                <th>ملاحظة</th>
                                                <th>الحالة</th>
                                                <th>إجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($inquiries as $inquiry)
                                                @php
                                                    $waNumber = '963' . ltrim($inquiry->phone, '0');
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $inquiry->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>{{ $inquiry->name }}</td>
                                                    <td dir="ltr">{{ $inquiry->phone }}</td>
                                                    <td>
                                                        @if ($inquiry->property)
                                                            <a href="{{ route('property.detail', $inquiry->property->slug) }}" target="_blank">
                                                                {{ $inquiry->property->name }}
                                                            </a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td style="max-width: 250px; white-space: pre-line;">{{ $inquiry->note ?: '-' }}</td>
                                                    <td>
                                                        @if ($inquiry->is_handled)
                                                            <span class="badge badge-success">تمت المتابعة</span>
                                                        @else
                                                            <span class="badge badge-warning">جديد</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="tel:{{ $inquiry->phone }}" class="btn btn-sm btn-primary mb-1">اتصال</a>
                                                        <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" class="btn btn-sm btn-success mb-1">WhatsApp</a>
                                                        <form action="{{ route('admin.inquiries.handled', $inquiry) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-info mb-1">
                                                                {{ $inquiry->is_handled ? 'إعادة فتح' : 'تمت المتابعة' }}
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger mb-1">حذف</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">لا توجد طلبات حالياً</td>
                                                </tr>
                                            @endforelse
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