<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
// use App\Services\Warehouse\WarehouseService;
use Throwable;
use App\DataTables\InvoiceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Services\Invoice\InvoiceService;
// use App\Services\Product\ProductService;
use App\Services\Customer\CustomerService;
// use App\Services\Product\ProductCategoryService;
use App\Models\PaymentSession;

class HdfcPaymentController extends Controller
{
    protected $invoiceService;
    protected $customerService;
    // protected $productService;
    // protected $categoryService;
    // protected $warehouseService;

    public function __construct(CustomerService $customerService, InvoiceService $invoiceService)
    {
        $this->customerService = $customerService;
        $this->invoiceService = $invoiceService;
    }

    public function initiatePayment(InvoiceRequest $request)
    {
        // dd('ghgjkj');
        $data = $request->validated();

        // dd($data);
       

        if (!$data['customer_id']) {
            $data['customer'] = $data['walkin_customer'];
        } else {
            $customer = $this->customerService->get($data['customer_id']);
            $data['customer'] = $customer;
        }

        // dd($data);


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

        // dd($data['customer']['last_name']);

        $payload = [
            'order_id' => $orderId,
            'amount' => $amount,
            'customer_id' => $customerId,
            'customer_email' => $data['customer']['email'],
            'customer_phone' => $data['customer']['phone'],
            'payment_page_client_id' => config('hdfc.payment_page_client_id'),
            'action' => 'paymentPage',
            'currency' => 'INR',
            'return_url' => "https://2dfe-49-43-99-214.ngrok-free.app/admin/hdfc/response",
            // 'return_url' => route('hdfc.response'),
            'description' => 'Complete your payment for order on Copper and Crumb',
            'first_name' => $data['customer']['first_name'],
            'last_name' => $data['customer']['last_name'],
        ];

        // dd($data);

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

            // dd($responseData['payment_links']['web']);
            // dd($response->successful());

            Log::info('HDFC Payment Initiation Response:', $responseData);

            if ($response->successful() && isset($responseData['payment_links']['web'])) {

                return response()->json([
                    'payment_url' => $responseData['payment_links']['web']
                ]);
            }

            return back()->with('error', 'Unable to redirect to payment page. Please try again.');
        } catch (\Throwable $e) {
            Log::error('HDFC Payment Initiation Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Payment initiation failed. Please try again later.');
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
            return response()->json(['error' => 'Payment session not found.'], 404);
        }

        $invoiceData = json_decode($session->invoice_data, true);
        // dd($invoiceData);
        $invoice = $this->invoiceService->storeOrUpdate($invoiceData);

        $originalData = json_decode($session->payload, true);

        // dd($originalData);

        // Now you have everything: amount, email, phone, etc.
        // Example: return all info to debug
        return response()->json([
            'hdfc_response' => $request->all(),
            'original_payload' => $originalData
        ]);

        // Log::info('HDFC Payment Response Received:', $responseData);

        // if ($this->isPaymentSuccessful($responseData)) {
        //     return view('payment.success', ['data' => $responseData]);
        // }

        // return view('payment.failed', ['data' => $responseData]);
    }

    private function isPaymentSuccessful(array $response): bool
    {
        return isset($response['status']) && strtoupper($response['status']) === 'SUCCESS';
    }
}
