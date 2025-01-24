<?php

namespace App\Http\Controllers\Customer\Invoice;

use App\DataTables\CustomerInvoiceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Services\Customer\CustomerService;
use App\Services\Invoice\InvoiceService;
use App\Services\Product\ProductCategoryService;
use App\Services\Product\ProductService;
use App\Services\Warehouse\WarehouseService;

class InvoicesController extends Controller
{
    protected $invoiceService;
    protected $customerService;
    protected $productService;
    protected $categoryService;
    protected $warehouseService;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        InvoiceService $invoiceService,
        CustomerService $customerService,
        ProductService $productService,
        ProductCategoryService $categoryService,
        WarehouseService $warehouseService
    )
    {
        $this->invoiceService   = $invoiceService;
        $this->customerService  = $customerService;
        $this->productService   = $productService;
        $this->categoryService  = $categoryService;
        $this->warehouseService = $warehouseService;
    }
        public function index(CustomerInvoiceDataTable $dataTable)
    {
        set_page_meta(__('custom.invoice'));
        return $dataTable->render('customer.invoice.index');
    }


    public function create()
    {
        $warehouses = $this->warehouseService->pluck();
        $warehouse = count($warehouses) > 1 && \request('warehouse')
            ? $this->warehouseService->getWareHouse(\request('warehouse'))
            : $this->warehouseService->firstWarehouse();
        $all_status = $this->invoiceService->getAllStatus();
        $customers = $this->customerService->getActiveData(null, ['b_country_data', 'b_state_data', 'b_city_data']);
//        $products = $this->productService->wareHouseWiseProducts('warehouseStockQty', $warehouse);/*$this->productService->get(null, [], 20);*/
        $product_stocks = $this->productService->wareHouseWiseAllProductStocks(['product','attribute','attributeItem'], $warehouse);
        $categories = $this->categoryService->get()->toArray();

        array_unshift($categories, ['id' => 'all', 'text' => 'All Categories']);

        set_page_meta(__('custom.create_invoice'));

        return view('customer.invoice.create', compact('all_status', 'customers', 'product_stocks', 'categories', 'warehouses', 'warehouse'));
    }
    public function store(InvoiceRequest $request)
    {
        $data = $request->validated();

        // Customer
        if (!$data['customer_id']) {
            $data['customer'] = $data['walkin_customer'];
        } else {
            $customer = $this->customerService->get($data['customer_id']);
            $data['customer'] = $customer;
        }

        try {
            $invoice = $this->invoiceService->storeOrUpdate($data);
            flash(__('custom.invoice_created_successful'))->success();

            return response()->json(['success' => true, 'invoice' => $invoice->id], 200);
        } catch (Throwable $th) {
            flash(__('custom.invoice_created_failed'))->success();

            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }
    }

    public function show($id)
    {
        $invoice = $this->invoiceService->get($id, ['items', 'payments']);
        if(!$invoice) {
            flash(__('custom.invoice_not_found'))->error();
            return redirect()->route('customer.invoices.index');
        }
        if($invoice->customer_id != auth()->guard('customer')->user()->id) {
            flash(__('custom.invoice_not_found'))->error();
            return redirect()->route('customer.invoices.index');
        }

        set_page_meta(__('custom.show_invoice'));
        return view('customer.invoice.show', compact('invoice'));
    }
    public function download($id)
    {
        $invoice = $this->invoiceService->get($id, ['items', 'payments']);
        if(!$invoice) {
            flash(__('custom.invoice_not_found'))->error();
            return redirect()->route('customer.invoices.index');
        }
        if($invoice->customer_id != auth()->guard('customer')->user()->id) {
            flash(__('custom.invoice_not_found'))->error();
            return redirect()->route('customer.invoices.index');
        }

        return $this->invoiceService->download($id);
    }
    public function getPayments($invoice_id)
    {
        return $this->invoiceService->getPayments($invoice_id);
    }
    public function print($id)
    {
        return view('admin.invoices.thermal-print', [
            'invoice' => $this->invoiceService->get($id)
        ]);
    }
}
