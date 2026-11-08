@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Agent Plan</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content user-panel">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                    <x-dashboard />
                </div>
                <div class="col-lg-9 col-md-12">
                    <h4 class="mb-4">Current Plan</h4>
                    @if ($currentPlan)
                        @php $isUnlimited = is_null($currentPlan->expire_at); @endphp
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Plan Price: ${{ number_format($currentPlan->plan->price) }}</h5>
                                <hr>
                                <p><strong>Plan Name:</strong> {{ $currentPlan->plan->name }}</p>
                                <p><strong>Purchased At:</strong> {{ $currentPlan->purchased_at }}</p>
                                <p><strong>Expires At:</strong> {{ $isUnlimited ? 'Unlimited' : $currentPlan->expire_at }}</p>
                                @unless ($isUnlimited)
                                    <p><strong>Remaining Days:</strong> {{ ceil(now()->diffInDays($currentPlan->expire_at)) }}</p>
                                @endunless
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger mb-4">
                            You do not have any active plan.
                        </div>
                        <h4 class="mb-3">Buy Plan (Make Payment)</h4>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <form id="paymentForm" method="POST">
                                    @csrf
                                    <div class="row align-items-center">
                                        <div class="col-md-8 mb-3 mb-md-0">
                                            <select name="package_id" id="packageSelect" class="form-control">
                                                @foreach ($plans as $plan)
                                                    <option value="{{ $plan->id }}">
                                                        {{ $plan->name }} (${{ number_format($plan->price) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Buy Plan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <script>
                                    document.getElementById('paymentForm').addEventListener('submit', function (e) {
                                        const selectedId = document.getElementById('packageSelect').value;
                                        this.action = `/agent/payment/send/${selectedId}`;
                                    });
                                </script>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
