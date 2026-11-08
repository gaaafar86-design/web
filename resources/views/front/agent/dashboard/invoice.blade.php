@extends('front.layouts.master')

@section('content')
<div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Invoice No: {{ $order->transaction_id }}</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-content user-panel">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="card">
                    <x-dashboard/>
                </div>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="invoice-container" id="print_invoice">
                    <div class="invoice-top">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-border-0">
                                        <tbody>
                                            <tr>
                                                <td class="w-50">
                                                    <img src="{{ asset('website-images/' . $setting->logo) }}" alt="Logo" class="w-100">
                                                </td>
                                                <td class="w-50">
                                                    <div class="invoice-top-right">
                                                        <h4>Invoice</h4>
                                                        <h5>Invoice No: {{ $order->transaction_id }}</h5>
                                                        <h5>Date: {{ $order->created_at }}</h5>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-middle">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-border-0">
                                        <tbody>
                                            <tr>
                                                <td class="w-50">
                                                    <div class="invoice-middle-left">
                                                        <h4>Invoice To:</h4>
                                                        <p class="mb_0">{{ $order->agent->name }}</p>
                                                        <p class="mb_0">{{ $order->agent->email }}</p>
                                                        <p class="mb_0">{{ $order->agent->phone }}</p>
                                                        <p class="mb_0">{{ $order->agent->address }}</p>
                                                    </div>
                                                </td>
                                                <td class="w-50">
                                                    <div class="invoice-middle-right">
                                                        <h4>Invoice From:</h4>
                                                        <p class="mb_0">{{ config('app.name') }}</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-item">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered invoice-item-table text-center">
                                        <tbody>
                                            <tr>
                                                <th>Package Name</th>
                                                <th>Package Price</th>
                                                <th>Purchase Date</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $order->plan->name }}</td>
                                                <td>${{ number_format($order->paid_amount) }}</td>
                                                <td>{{ $order->created_at }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-bottom">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-border-0">
                                        <tbody>
                                            <td class="w-70 invoice-bottom-payment">
                                                <h4>Payment Method</h4>
                                                <p>Zibal</p>
                                            </td>
                                            <td class="w-30 tar invoice-bottom-total-box">
                                                <h4>Total</h4>
                                                <p>${{ number_format($order->paid_amount) }}</p>
                                            </td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="print-button mt_25">
                    <a onclick="printInvoice()" href="javascript:;" class="btn btn-primary"><i class="fas fa-print"></i> Print</a>
                </div>
                <script>
                    function printInvoice() {
                        let body = document.body.innerHTML;
                        let data = document.getElementById('print_invoice').innerHTML;
                        document.body.innerHTML = data;
                        window.print();
                        document.body.innerHTML = body;
                    }
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
