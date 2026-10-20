@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Orders</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content user-panel mt_50 mb_50">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <x-dashboard/>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th>Payment Id</th>
                                    <th>Plan Name</th>
                                    <th>Price</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Print Invoice</th>
                                </tr>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->transaction_id }}</td>
                                        <td>{{ $order->plan->name }}</td>
                                        <td>${{ number_format($order->plan->price) }}</td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <span class="badge {{ displayIcon($order->status, 'bg-success', 'bg-danger') }}">{{ $order->status ? 'Success' : 'Fail' }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('agent.invoice', $order) }}" class="btn btn-primary btn-sm"><i class="fas fa-print"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
