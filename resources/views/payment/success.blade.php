<h2>Payment Successful!</h2>

<p><strong>Order ID:</strong> {{ $data['order_id'] ?? 'N/A' }}</p>
<p><strong>Payment Status:</strong> {{ $data['status'] ?? 'N/A' }}</p>
<p><strong>Amount:</strong> {{ $data['amount'] ?? 'N/A' }}</p>

{{-- Add any other details you want to show as invoice --}}
