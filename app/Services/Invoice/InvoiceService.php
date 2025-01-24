<?php

namespace App\Services\Invoice;

use PDF;
use Throwable;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Product;
use App\Mail\InvoiceSend;
use App\Models\Warehouse;
use App\Models\InvoiceItem;
use Illuminate\Support\Str;
use App\Models\ProductStock;
use App\Services\BaseService;
use App\Models\InvoicePayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\Payments\PaypalService;
use App\Services\Payments\StripeService;
use App\Services\Product\ProductService;

/**
 * InvoiceService
 */
class InvoiceService extends BaseService
{
    protected $productService;
    protected $stripeService;
    protected $paypalService;
    protected $productStock;
    protected $product;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $model = new Invoice();
        parent::__construct($model);

        $this->productService = app(ProductService::class);
        $this->stripeService = app(StripeService::class);
        $this->paypalService = app(PaypalService::class);
        $this->productStock = app(ProductStock::class);
        $this->product = app(Product::class);
    }

    /**
     * getAllStatus
     *
     * @return array
     */
    public function getAllStatus(): array
    {
        try {
            return $this->model::INVOICE_ALL_STATUS;
        } catch (Throwable $th) {
            throw $th;
        }
    }


    /**
     * filterPaymentByDateRange
     *
     * @param  mixed $start
     * @param  mixed $end
     * @param  mixed $with
     * @return void
     */
    public function filterPaymentByDateRange($start = null, $end = null, $with = [])
    {
        try {
            $query = InvoicePayment::query()->with($with);

            if ($start) {
                $query->whereDate('date', '>=', $start);
            }

            if ($end) {
                $query->whereDate('date', '<=', $end);
            }

            return $query->when(request('warehouse'), function ($q){
                $q->whereHas('invoice.warehouse', function ($q){
                    $q->where('warehouse_id', request('warehouse'));
                });
            })
            ->when(Auth()->guard('customer')->check(), function($q){
                $q->whereHas('invoice', function ($q){
                    $q->where('customer_id', Auth()->guard('customer')->id());
                });
            })
            ->whereNotNull('amount')->orderBy('date', 'DESC')->get();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function invoiceCustomerEmail($id)
    {
        $invoice = $this->get($id);

        if ($invoice->customer_id) {
            return $invoice->customer['email'];
        } else {
            return '';
        }
    }

    /**
     * getAllPayments
     *
     * @return void
     */
    public function getAllPayments($with = [])
    {
        return InvoicePayment::with($with)
            ->when(request('warehouse'), function ($q){
                $q->whereHas('invoice.warehouse', function ($q){
                    $q->where('warehouse_id', request('warehouse'));
                });
            })
            ->when(Auth()->guard('customer')->check(), function($q){
                $q->whereHas('invoice', function ($q){
                    $q->where('customer_id', Auth()->guard('customer')->id());
                });
            })
            ->whereNotNull('amount')->get();
    }

    /**
     * filterByDateRange
     *
     * @param  mixed $start
     * @param  mixed $end
     * @param  mixed $with
     * @return void
     */
    public function filterByDateRange($start = null, $end = null, $with = [])
    {
        try {
            $query = $this->model::query()->with($with);

            if ($start) {
                $query->whereDate('date', '>=', $start);
            }

            if ($end) {
                $query->whereDate('date', '<=', $end);
            }

            return $query->when(request('warehouse'), fn($q) => $q->where('warehouse_id', request('warehouse')))
                ->when(Auth()->guard('customer')->check(), fn($q) => $q->where('customer_id', Auth()->guard('customer')->id()))
                ->orderBy('date', 'DESC')
                ->get();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function filterWareHouseWiseAll($with = [])
    {
        try {
            return $this->model::query()
                ->with($with)
                ->when(request('warehouse'), fn($q) => $q->where('warehouse_id', request('warehouse')))
                ->when(Auth()->guard('customer')->check(), fn($q) => $q->where('customer_id', Auth()->guard('customer')->id()))
                ->orderBy('date', 'DESC')
                ->get();

        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * download
     *
     * @param  mixed $id
     * @return void
     */
    public function download($id)
    {
        try {
            $invoice = $this->get($id, ['items']);
            $pdf = PDF::loadView('admin.invoices.pdf.invoice', ['data' => $invoice]);
            return $pdf->download('Invoice_'. make8digits($invoice->id) .'.pdf');
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * storeOrUpdate
     *
     * @param  mixed $data
     * @param  mixed $id
     * @return void
     */
    public function storeOrUpdate(array $data, $id = null)
    {
        try {

            DB::beginTransaction();
            if ($id) {
                $invoice = $this->model::findOrFail($id);
            } else {
                $invoice = new $this->model();
                if(Auth()->guard('customer')->check()){
                    $invoice->created_by = Auth()->guard('customer')->user()->id;
                }else{
                    $invoice->created_by = Auth::id();
                }
            }

            $invoice->date = Carbon::parse($data['date'])->format('Y-m-d H:i:s');
            $invoice->due_date = Carbon::parse($data['due_date'])->format('Y-m-d H:i:s');
            $invoice->customer_id = $data['customer_id'];
            $invoice->customer = $data['customer'];
            $invoice->warehouse_id = $data['warehouse_id'];
            $invoice->billing_info = $data['billing'];
            $invoice->shipping_info = $data['shipping'];
            $invoice->items_data = $data['items'];
            $invoice->total_paid = ($data['payment_type'] == $this->model::PAYMENT_TYPE_CASH || $data['payment_type'] == $this->model::PAYMENT_TYPE_BANK) ? $data['total_paid'] : 0;
            $invoice->last_paid = $data['total_paid'];
            $invoice->payment_type = $data['payment_type'];
            if (isset($data['bank_info'])) {
                $invoice->bank_info = $data['bank_info'] ?? null;
            }
            $invoice->global_discount = $data['discount'];
            $invoice->global_discount_type = $data['discount_type'];
            $invoice->notes = $data['notes'];
            $invoice->status = $this->model::STATUS_PENDING;
            $invoice->token = Str::random(64);
            $invoice->updated_by = Auth::id();
            if(Auth()->guard('customer')->check()){
                $invoice->delivery_status               = $this->model::DELIVERY_STATUS_PENDING;
                $invoice->invoice_created_from          = $this->model::CREATED_FROM_CUSTOMER;
            }else{

                if(isset($data['is_delivered']) && $data['is_delivered'] != null && $data['is_delivered'] == true){
                    $invoice->delivery_status               = $this->model::DELIVERY_STATUS_DELIVERED;
                }else{
                    $invoice->delivery_status               = $this->model::DELIVERY_STATUS_PENDING;
                }
            }
            $invoice->save();

            $gross_total = 0;
            $total_tax = 0;
            $total_discount = 0;

            if (request()->method() == "PUT") {
                $this->stockPlusUpdate($data['items'], $id);
            }

            // Delete old item
            InvoiceItem::where('invoice_id', $id)->delete();

            // Add new item
            if ($data['items']) {
                foreach ($data['items'] as $item) {
                    $product = $this->productService->get($item['product_id']);
                    if (!$product) continue;

                    $i_item = new InvoiceItem();
                    $i_item->invoice_id = $invoice->id;
                    $i_item->product_id = $item['product_id'];
                    $i_item->product_stock_id = $item['id'];
                    $i_item->product_name = $product->name;
                    $i_item->sku = $product->sku;
                    $i_item->quantity = $item['quantity'];
                    $i_item->price = $item['price'];
                    $i_item->discount = $item['discount'];
                    $i_item->discount_type = $item['discount_type'];
                    $i_item->sub_total = $item['price'] * $item['quantity'];

                    // Tax percent
                    if ($product->tax_status == Product::TAX_INCLUDED) {
                        if ($product->custom_tax) {
                            $i_item->tax = $product->custom_tax;
                        } else {
                            $i_item->tax = getDefaultTax();
                        }
                    }

                    // Calculate discount
                    $discount_amount = 0;
                    if ($item['discount_type'] == $this->model::DISCOUNT_PERCENT) {
                        $discount_amount = $item['price'] * ($item['discount'] / 100);
                    } else {
                        $discount_amount = $item['discount'];
                    }


                    $i_item->sub_total = ($item['price'] - $discount_amount) * $item['quantity'];

                    $i_item->save();

                    $gross_total += $i_item->sub_total;

                    // Calculate discount
                    $total_discount += $discount_amount;

                    // Calculate tax
                    $tax_amount = $item['price'] * ($i_item->tax / 100);
                    $total_tax += $tax_amount * $i_item->quantity;
                }
            }


            $this->stockUpdate($data['items']);

            // If update delete old paymets
            if ($id) {
                InvoicePayment::where('invoice_id', $id)->delete();
            }

            // Invoice payment
            if ($data['payment_type'] == $this->model::PAYMENT_TYPE_CASH || $data['payment_type'] == $this->model::PAYMENT_TYPE_BANK) {
                $payment = new InvoicePayment();
                $payment->invoice_id = $invoice->id;
                $payment->date = Carbon::parse($data['date'])->format('Y-m-d H:i:s');
                $payment->payment_type = $data['payment_type'];
                $payment->amount =  $data['total_paid'];
                $payment->bank_info = json_encode($invoice->bank_info);
                $payment->created_by = Auth::id();
                $payment->save();
            }

            $total = $gross_total + $total_tax;

            // Calculate global discount
            $global_discount_amount = 0;
            if ($data['discount_type'] == $this->model::DISCOUNT_PERCENT) {
                $global_discount_amount = $total * ($data['discount'] / 100);
            } else {
                $global_discount_amount = $item['discount'];
            }

            $total -= $global_discount_amount;
            $total_discount += $global_discount_amount;

            // Update invoice info
            $invoice->tax_amount = $total_tax;
            $invoice->discount_amount = $total_discount;
            $invoice->total = $total;

            // Update status
            if ($data['payment_type'] == $this->model::PAYMENT_TYPE_CASH && $data['total_paid'] > 0) {
                if ($data['total_paid'] >= $total) {
                    $invoice->status = $this->model::STATUS_PAID;
                } else {
                    $invoice->status = $this->model::STATUS_PARTIALLY_PAID;
                }
            }
            if(auth()->guard('customer')->check() && $invoice->payment_type  == 'online') {
                $invoice->status        = $this->model::STATUS_PENDING;
                $invoice->last_paid     = $total;
                $invoice->payment_type  = 'online';
            }

            $invoice->save();



            DB::commit();
            return $invoice;
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * addPayment
     *
     * @param  mixed $data
     * @return void
     */
    public function addPayment(array $data)
    {
        try {
            $invoice = $this->get($data['invoice_id']);

            $payment = new InvoicePayment();
            $payment->invoice_id = $invoice->id;
            $payment->date = $data['date'];
            $payment->payment_type = $data['payment_type'];
            $payment->amount = $data['amount'];
            $payment->notes = $data['notes'];
            $payment->created_by = Auth::id();

            if ($payment->save()) {
                $invoice->total_paid = $invoice->total_paid + $payment->amount;
                $invoice->save();
            }

            return $payment;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * getPayments
     *
     * @param  mixed $invoice_id
     * @return void
     */
    public function getPayments($invoice_id)
    {
        try {
            return InvoicePayment::where('invoice_id', $invoice_id)->orderBy('id', 'DESC')->get();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * deletePayment
     *
     * @param  mixed $id
     * @return void
     */
    public function deletePayment($id)
    {
        try {

            $payment = InvoicePayment::findOrFail($id);
            // Get the invoice
            $invoice = $this->get($payment->invoice_id);
            // Adjust paid amount
            $invoice->total_paid = $invoice->total_paid - $payment->amount;
            $invoice->save();

            return $payment->delete();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * sendInvoice
     *
     * @param  mixed $data
     * @return void
     */
    public function sendInvoice(array $data)
    {
        try {
            $invoice = $this->get($data['invoice_id']);

            return Mail::to($data['email'])->send(new InvoiceSend($invoice));
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * getByToken
     *
     * @param  mixed $token
     * @return void
     */
    public function getByToken($token)
    {
        try {
            return $this->model::where('token', $token)->first();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * generateInvoiceNo
     *
     * @return void
     */
    public function generateInvoiceNo()
    {
        // Generate invoice no
        $invoice_no = 1;
        $last_sale = $this->model::latest()->first();
        if ($last_sale) $invoice_no = $last_sale->id + 1;
        return sprintf("%08d", $invoice_no);
    }


    /**
     * payByStripe
     *
     * @param  mixed $invoice_id
     * @return void
     */
    public function payByStripe($invoice_id)
    {
        $invoice = $this->get($invoice_id);
        if (!$invoice) abort(404);

        return $this->stripeService->pay($invoice);
    }

    /**
     * stripePaymentSuccess
     *
     * @param  mixed $invoice_id
     * @return void
     */
    public function stripePaymentSuccess($invoice_id)
    {
        $invoice = $this->get($invoice_id);
        if (!$invoice) abort(404);

        $invoice->total_paid = $invoice->total_paid + $invoice->last_paid;
        $invoice->payment_type = $this->model::PAYMENT_TYPE_STRIPE;

        if ($invoice->total_paid >= $invoice->total) {
            $invoice->status = $this->model::STATUS_PAID;
        } else {
            $invoice->status = $this->model::STATUS_PARTIALLY_PAID;
        }
        $invoice->save();

        // Store payment
        $payment = new InvoicePayment();
        $payment->invoice_id = $invoice->id;
        $payment->date = Carbon::parse(Carbon::now())->format('Y-m-d H:i:s');
        $payment->payment_type = $invoice->payment_type;
        $payment->amount =  $invoice->last_paid;
        $payment->save();


        return true;
    }

    /**
     * paypalPaymentSuccess
     *
     * @param  mixed $invoice_id
     * @param  mixed $order_id
     * @return void
     */
    public function paypalPaymentSuccess($invoice_id, $order_id)
    {

        $transaction_amount = $this->paypalService->getTransaction($order_id);
        if (!$transaction_amount) abort(404);


        $invoice = $this->get($invoice_id);
        if (!$invoice) abort(404);

        $invoice->total_paid = $invoice->total_paid + $transaction_amount;

        if ($invoice->total_paid >= $invoice->total) {
            $invoice->status = $this->model::STATUS_PAID;
        } else {
            $invoice->status = $this->model::STATUS_PARTIALLY_PAID;
        }

        $invoice->payment_type = $this->model::PAYMENT_TYPE_PAYPAL;
        $invoice->save();

        // Store payment
        $payment = new InvoicePayment();
        $payment->invoice_id = $invoice->id;
        $payment->date = Carbon::parse(Carbon::now())->format('Y-m-d H:i:s');
        $payment->payment_type = $invoice->payment_type;
        $payment->amount =  $transaction_amount;
        $payment->save();


        return true;
    }


    /**
     * makePayment
     *
     * @param  mixed $invoice_id
     * @param  mixed $data
     * @return void
     */
    public function makePayment($invoice_id, $data)
    {
        $invoice = $this->get($invoice_id);
        if (!$invoice) abort(404);

        $invoice->last_paid = $data['last_paid'];
        $invoice->payment_type = $data['payment_type'];

        if ($data['payment_type'] == $this->model::PAYMENT_TYPE_CASH || $data['payment_type'] == $this->model::PAYMENT_TYPE_BANK) {
            $invoice->total_paid = $invoice->total_paid + $data['last_paid'];
            $invoice->bank_info = json_encode($data['bank_info']) ?? null;

            if ($invoice->total_paid >= $invoice->total) {
                $invoice->status = $this->model::STATUS_PAID;
            } else {
                $invoice->status = $this->model::STATUS_PARTIALLY_PAID;
            }
        } else {
            $invoice->status = $this->model::STATUS_PENDING;
        }

        $invoice->save();

        if ($data['payment_type'] == $this->model::PAYMENT_TYPE_CASH || $data['payment_type'] == $this->model::PAYMENT_TYPE_BANK) {
            // Store payment
            $payment = new InvoicePayment();
            $payment->invoice_id = $invoice->id;
            $payment->date = Carbon::parse(Carbon::now())->format('Y-m-d H:i:s');
            $payment->payment_type = $invoice->payment_type;
            $payment->amount =  $invoice->last_paid;
            $payment->bank_info = json_encode($data['bank_info']) ?? null;
            $payment->save();
        }

        return true;
    }

    /**
     * stockUpdate
     *
     * @param  mixed $items
     * @return void
     */

    private function stockUpdate($items)
    {
        if (isset($items)) {
            foreach ($items as $key => $item) {
                if ($item['id']) {
                    $stock = $this->getStock($item['id']);
                    if ($stock) {
                        $stock->update([
                            'quantity' => $stock->quantity - $item['quantity']
                        ]);
                    }

                    $productStock = $this->product->newQuery()->where('id', $item['product_id'])->first();
                    $productStock->update([
                        'stock' => $productStock->stock - $item['quantity']
                    ]);
                }
            }
        }
    }


    private function stockPlusUpdate($items, $id)
    {
        if (isset($items)) {
            foreach ($items as $key => $item) {
                if ($item['id']) {

                    $itemTableQuantity = optional(InvoiceItem::query()
                        ->where('invoice_id', $id)
                        ->where('product_id', $item['product_id'])
                        ->where('product_stock_id', $item['id'])
                        ->first())->quantity ?: 0;

                    $stock = $this->getStock($item['id']);
                    if ($stock) {
                        $stock->update([
                            'quantity' => $stock->quantity + $itemTableQuantity
                        ]);
                    }

                    $productStock = $this->product->newQuery()->where('id', $item['product_id'])->first();
                    $productStock->update([
                        'stock' => $productStock->stock + $itemTableQuantity
                    ]);
                }
            }
        }
    }

    /**
     * getStock
     *
     * @param  mixed $product
     * @return void
     */
    public function getStock($product_stock_id)
    {
        return $this->productStock->newQuery()->where('id', $product_stock_id)->first();

//        if (request('warehouse_id')){
//            $defaultWarehouse = request('warehouse_id');
//        }else{
//            $defaultWarehouse = Warehouse::query()->where('is_default', true)->first()->id;
//        }
//
//        return $this->productStock
//            ->newQuery()
//            ->where('product_id', $product)
//            ->where('warehouse_id', $defaultWarehouse)
//            ->first();
    }
    public function deliveryStatusChange($id,$status)
    {

        $invoice = $this->get($id,'items.product');
        if (!$invoice) abort(404);

        if($invoice->delivery_status == $this->model::DELIVERY_STATUS_CANCELED && $status != $this->model::DELIVERY_STATUS_CANCELED){
            $this->stockUpdate($this->makeItemObj($invoice->items));
        }elseif ($invoice->delivery_status == $this->model::DELIVERY_STATUS_DELIVERED && $status != $this->model::DELIVERY_STATUS_DELIVERED){
            $this->stockPlusUpdate($this->makeItemObj($invoice->items),$id);
        }

        $invoice->delivery_status = $status;
        $invoice->save();

        return true;
    }
    private function makeItemObj($items)
    {
        $itemObj = [];
        foreach ($items as $key => $item) {
            $itemObj[] = [
                'id'            => $item->product_stock_id,
                'product_id'    => $item->product_id,
                'split_sale'    => optional($item->product)->split_sale,
                'sku'           => $item->sku,
                'name'          => $item->product_name,
                'price'         => $item->price,
                'stock'         => $item->product,
                'quantity'      => $item->quantity,
                'tax_status'    => $item->product,
                'custom_tax'    => $item->tax,
                'discount'      => $item->discount,
                'discount_type' => $item->discount_type,
            ];
        }
        return $itemObj;
    }

}
