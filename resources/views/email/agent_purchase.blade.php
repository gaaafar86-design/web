<p>Your payment has been successfully processed.</p>
<p>Transaction ID: {{ $order->transaction_id }}</p>
<p>Package Name: {{ $order->plan->name }}</p>
<p>Paid Amount: {{ number_format($order->paid_amount) }}</p>
<p>Purchase Date: {{ $plan->purchased_at->format('Y-m-d H:i:s') }}</p>
<p>Expiration Date: {{ $plan->expire_at == null ? 'Unlimited' : $plan->expire_at->format('Y-m-d H:i:s') }}</p>
<a href="{{ route('agent.dashboard') }}">Go to Your Dashboard</a>
