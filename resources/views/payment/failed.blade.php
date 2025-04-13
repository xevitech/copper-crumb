<h2>Payment Failed!</h2>

<p><strong>Order ID:</strong> {{ $data['order_id'] ?? 'N/A' }}</p>
<p><strong>Payment Status:</strong> {{ $data['status'] ?? 'FAILED' }}</p>
<p><strong>Amount:</strong> {{ $data['amount'] ?? 'N/A' }}</p>

@if(isset($data['message']))
    <p><strong>Message:</strong> {{ $data['message'] }}</p>
@endif

{{-- Optional debug --}}
{{-- <pre>{{ print_r($data, true) }}</pre> --}}
