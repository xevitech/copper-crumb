<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\DataTables\InvoiceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Services\Invoice\InvoiceService;
use App\Services\Customer\CustomerService;
use App\Models\PaymentSession;

class HdfcPaymentController extends Controller
{
    protected $invoiceService;
    protected $customerService;

    public function __construct(CustomerService $customerService, InvoiceService $invoiceService)
    {
        $this->customerService = $customerService;
        $this->invoiceService = $invoiceService;
    }

    public function initiatePayment(InvoiceRequest $request)
    {
        $data = $request->validated();

        if (!$data['customer_id']) {
            $data['customer'] = $data['walkin_customer'];
        } else {
            $customer = $this->customerService->get($data['customer_id']);
            $data['customer'] = $customer;
        }

        $amount = $data['payments'][0]['amount'];
        $orderId = 'CCORD' . time();

        if (is_array($data['customer']) && isset($data['customer']['id'])) {
            $customerId = $data['customer']['id'];
        } else {
            $customerId = $data['customer']['full_name'];
            $nameParts = explode(' ', trim($customerId), 2);
            $data['customer']['first_name'] = $nameParts[0];
            $data['customer']['last_name'] = $nameParts[1] ?? '';
        }


        $payload = [
            'order_id' => $orderId,
            'amount' => $amount,
            'customer_id' => $customerId,
            'customer_email' => $data['customer']['email'],
            'customer_phone' => $data['customer']['phone'],
            'payment_page_client_id' => config('hdfc.payment_page_client_id'),
            'action' => 'paymentPage',
            'currency' => 'INR',
            // 'return_url' => "https://deb4-49-43-99-93.ngrok-free.app/admin/hdfc/response",
            'return_url' => url('https://copperandcrumb.in/order/success'),
            'description' => 'Descripyion goese here !',
            'first_name' => $data['customer']['first_name'],
            'last_name' => $data['customer']['last_name'],
        ];

        // Initiate payment (before redirecting)
        PaymentSession::create([
            'order_id' => $orderId,
            'payload' => json_encode($payload),
            'invoice_data' => json_encode($data),
        ]);


        try {
            $response = Http::withHeaders([
                'Authorization'   => 'Basic ' . base64_encode(config('hdfc.api_key') . ':'),
                'x-merchantid'    => config('hdfc.merchant_id'),
                'x-customerid'    => $customerId,
                'Content-Type'    => 'application/json',
            ])->post(config('hdfc.base_url') . '/session', $payload);

            $responseData = $response->json();

            Log::info('HDFC Payment Initiation Response:', $responseData);

            if ($response->successful() && isset($responseData['payment_links']['web'])) {

                return response()->json([
                    'payment_url' => $responseData['payment_links']['web']
                ]);
            }

           return response()->json([
                'message' => 'Unable to redirect to payment page. Please try again.'
            ], 202);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                ]);
                
            
        }
    }

    public function handleHdfcResponse(Request $request)
    {
        // dd('sdsdsd');
        $responseData = $request->all();

        $orderId = $request->input('order_id');

        $session = PaymentSession::where('order_id', $orderId)->first();

        // dd($session);

        if (!$session) {
            return response()->json(['error' => 'Payment session not found.'], 202);
        }

        $invoiceData = json_decode($session->invoice_data, true);
        // dd($invoiceData);
        $invoice = $this->invoiceService->storeOrUpdate($invoiceData);

        $originalData = json_decode($session->payload, true);

        return view('payment.success', [
            'hdfc_response' => $responseData,
            'original_payload' => $originalData
        ]);

    }

    private function isPaymentSuccessful(array $response): bool
    {
        return isset($response['status']) && strtoupper($response['status']) === 'SUCCESS';
    }
}
