@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Orders</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle" id="example1">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Agent</th>
                                                <th>Package</th>
                                                <th>Transaction ID</th>
                                                <th>Paid Amount</th>
                                                <th>Purchase Date</th>
                                                <th>Status</th>
                                                <th>Invoice</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $order->agent->id . '-' . $order->agent->name }} {{ $order->agent->email }}</td>
                                                    <td>{{ $order->plan->id . '-' . $order->plan->name }}</td>
                                                    <td>{{ $order->transaction_id }}</td>
                                                    <td>${{ number_format($order->paid_amount) }}</td>
                                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <span class="badge {{ displayIcon($order->status, 'bg-success', 'bg-danger') }}">
                                                            {{ $order->status ? 'Succeeded' : 'Failed' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.invoice', $order)}}" class="btn btn-primary btn-sm"><i class="fas fa-print"></i></a>
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
