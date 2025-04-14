<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment Response</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 700px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    h1 {
      text-align: center;
      color: {{ $hdfc_response['status'] === 'CHARGED' ? '#28a745' : '#dc3545' }};
      margin-bottom: 30px;
    }
    .section {
      margin-bottom: 25px;
    }
    .section h2 {
      font-size: 18px;
      margin-bottom: 10px;
      border-bottom: 1px solid #dee2e6;
      padding-bottom: 5px;
    }
    .details {
      line-height: 1.6;
    }
    .details span {
      font-weight: bold;
      display: inline-block;
      width: 180px;
    }
    .footer {
      text-align: center;
      font-size: 14px;
      color: #6c757d;
      margin-top: 20px;
    }
    .back-button {
      display: block;
      margin: 20px auto 0;
      text-align: center;
    }
    .back-button a {
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      transition: background-color 0.2s ease-in-out;
    }
    .back-button a:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Payment {{ $hdfc_response['status'] === 'CHARGED' ? 'Successful' : 'Failed' }}</h1>

    <div class="section">
      <h2>HDFC Response</h2>
      <div class="details">
        <p><span>Status:</span> {{ $hdfc_response['status'] ?? 'N/A' }}</p>
        {{-- <p><span>Status ID:</span> {{ $hdfc_response['status_id'] ?? 'N/A' }}</p> --}}
        <p><span>Order ID:</span> {{ $hdfc_response['order_id'] ?? 'N/A' }}</p>
        {{-- <p><span>Signature Algorithm:</span> {{ $hdfc_response['signature_algorithm'] ?? 'N/A' }}</p> --}}
        {{-- <p><span>Signature:</span> {{ $hdfc_response['signature'] ?? 'N/A' }}</p> --}}
      </div>
    </div>

    <div class="section">
      <h2>Customer Details</h2>
      <div class="details">
        <p><span>Name:</span> {{ $original_payload['first_name'] ?? '' }} {{ $original_payload['last_name'] ?? '' }}</p>
        <p><span>Email:</span> {{ $original_payload['customer_email'] ?? 'N/A' }}</p>
        <p><span>Phone:</span> {{ $original_payload['customer_phone'] ?? 'N/A' }}</p>
      </div>
    </div>

    <div class="section">
      <h2>Payment Info</h2>
      <div class="details">
        <p><span>Amount:</span> ₹{{ $original_payload['amount'] ?? '0' }}</p>
        <p><span>Currency:</span> {{ $original_payload['currency'] ?? 'INR' }}</p>
        <p><span>Description:</span> {{ $original_payload['description'] ?? '' }}</p>
        <p><span>Client ID:</span> {{ $original_payload['payment_page_client_id'] ?? '' }}</p>
      </div>
    </div>

    <div class="back-button">
      <a href="{{ url('/') }}">Back to Home</a>
    </div>

    <div class="footer">
      &copy; {{ now()->year }} Copper and Crumb. All rights reserved.
    </div>
  </div>

</body>
</html>
