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
use App\Models\Order;

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
        // $userId = auth()->guard('customer')->user()->id;

        if (!$data['customer_id']) {
            $data['customer'] = $data['walkin_customer'];
        } else {
            $customer = $this->customerService->get($data['customer_id']);
            $data['customer'] = $customer;
        }

        $amount = $data['payments'][0]['amount'];
        $orderId = 'CCORD' . time();

        if (isset($data['customer']['id'])) {
            // if (is_array($data['customer']) && isset($data['customer']['id'])) {
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
            'customer_id' => $orderId,
            'customer_email' => $data['customer']['email'],
            'customer_phone' => $data['customer']['phone'],
            'payment_page_client_id' => config('hdfc.payment_page_client_id'),
            'action' => 'paymentPage',
            'currency' => 'INR',
            'return_url' => "https://a948-49-43-99-87.ngrok-free.app/admin/hdfc/response",
            // 'return_url' => url('https://copperandcrumb.in/order/success'),
            'description' => 'Description goes here !',
            'first_name' => $data['customer']['first_name'],
            'last_name' => $data['customer']['last_name'],
        ];

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
        $responseData = $request->all();
        $orderId = $request->input('order_id');
        $session = PaymentSession::where('order_id', $orderId)->first();

        if (!$session) {
            return response()->json(['error' => 'Payment session not found.'], 202);
        }
        
        $invoiceId = null; 
        $customerId = null;
        
        if($responseData['status']==='CHARGED'){
            $invoiceData = json_decode($session->invoice_data, true);
            $invoice = $this->invoiceService->storeOrUpdate($invoiceData);
            $invoiceId = $invoice->id;
            if($invoiceData['customer_id']){
                $customerId = (int)$invoiceData['customer_id'];
            }else{
                $customerId = null;
            }
            
        }
        $originalData = json_decode($session->payload, true);

        Order::updateOrCreate(
            ['payment_session_id' => $session->id],
            [
                'payment_status' => $responseData['status'],
                'invoice_id' => $invoiceId,
                'customer_id' => $customerId,
            ]
        );

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
