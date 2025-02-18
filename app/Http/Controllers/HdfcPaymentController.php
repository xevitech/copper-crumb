<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HdfcPaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {
        // 1. Get data from the request (amount, order ID, etc.)
        $amount = $request->input('amount');
        $orderId = $request->input('order_id'); // Make sure you have a way to generate unique order IDs

        // 2. Prepare the payload for the HDFC API
        $payload = [
            'merchant_id' => config('hdfc.merchant_id'), // Use config values
            'amount' => $amount,
            'order_id' => $orderId,
            'payment_page_client_id' => config('hdfc.payment_page_client_id'),
            // ... other required parameters from HDFC API docs
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('hdfc.api_key'),
                'Content-Type' => 'application/json',
            ])->post(config('hdfc.base_url') . '/payment_endpoint', $payload);

            if ($response->successful()) {
                $responseData = $response->json();

                Log::info('HDFC Payment Response:', $responseData);

                if (isset($responseData['redirect_url'])) { 
                    return redirect($responseData['redirect_url']);
                } else {
                    return back()->with('error', 'HDFC payment initiation failed. No redirect URL received.');
                }
            } else {
                $errorData = $response->json();
                Log::error('HDFC Payment Error:', $errorData);
                return back()->with('error', 'HDFC payment initiation failed: ' . $response->status() . ' - ' . ($errorData['message'] ?? ''));
            }

        } catch (\Exception $e) {
            Log::error('HDFC Payment Exception:', ['exception' => $e]);
            return back()->with('error', 'An error occurred during payment initiation: ' . $e->getMessage());
        }
    }

    public function handleHdfcResponse(Request $request)
    {
        $responseFromHDFC = $request->all();
        Log::info('HDFC Return:', $responseFromHDFC); 

        if ($this->isPaymentSuccessful($responseFromHDFC)) {
            return view('payment.success');
        } else {
            return view('payment.failed');
        }
    }

    private function isPaymentSuccessful($response) {
        return isset($response['status']) && $response['status'] == 'SUCCESS';
    }
}
