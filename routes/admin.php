<?php

use App\Http\Controllers\Admin\Coupon\CouponController;
use App\Http\Controllers\Admin\Coupon\CouponProductController;
use App\Http\Controllers\Admin\Customer\CustomersController;
use App\Http\Controllers\Admin\Sale\SaleReturnRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Axios\AxiosController;
use App\Http\Controllers\Admin\Purchase\PurchaseController;
use App\Http\Controllers\Admin\Purchase\PurchaseReturnController;
use App\Http\Controllers\Admin\Purchase\PurchaseReceiveController;

// Route::namespace('Admin')->prefix('admin')->as('admin.')->middleware(['auth','isInstalled'])->group(function () {
Route::namespace('Admin')->prefix('admin')->as('admin.')->group(function () {

    Route::get('set-lang', 'DashboardController@setLang')->name('set-lang');
    // DASHBOARD
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    // USER
    Route::resource('users', Administration\UsersController::class);
    // ROLE
    Route::resource('roles', Administration\RolesController::class);
    // WAREHOUSE
    Route::resource('warehouses', Warehouse\WarehousesController::class);
    Route::get('warehouses/{warehouse}/show-pdf', "Warehouse\WarehousesController@showPdf")->name('warehouses.show-pdf');
    // BRAND
    Route::resource('brands', Brand\BrandsController::class);
    // MANUFACTURER
    Route::resource('manufacturers', Manufacturer\ManufacturersController::class);
    // WEIGHT UNIT
    Route::resource('weight-units', WeightUnit\WeightUnitsController::class);
    // MEASUREMENT UNIT
    Route::resource('measurement-units', MeasurementUnit\MeasurementUnitsController::class);
    // PRODUCT CATEGORY
    Route::resource('product-categories', Product\ProductCategoriesController::class);
    // ATTRIBUTE
    Route::resource('attributes', Attribute\AttributesController::class);
    // PRODUCT
    Route::resource('products', Product\ProductsController::class);
    Route::get('product/barcode/{id}', 'Product\ProductsController@barcodeDownload')->name('products.barcode.download');
    Route::post('product/barcode-zip', 'Product\ProductsController@barcodeDownloadZip')->name('products.barcode.download.zip');

    // PRODUCT STOCK
    Route::resource('product-stocks', Stock\ProductStocksController::class)->only(['update', 'edit']);

    Route::put('product-stocks.update-by-stock/{id}', 'Stock\ProductStocksController@updateByStock')->name('product-stocks.update-by-stock');

    Route::get('low-stock-products', 'Stock\ProductStocksController@index')->name('low-stock-products');
    // CUSTOMER
    Route::resource('customers', Customer\CustomersController::class);
    Route::get('customers/verify/{id}', [CustomersController::class, 'verifyUnverify'])->name('customers.verify');
    // SUPPLIER
    Route::resource('suppliers', Supplier\SuppliersController::class);
    // EXPENSES CATEGORY
    Route::resource('expenses-categories', Expenses\ExpensesCategoriesController::class);
    // EXPENSES
    Route::resource('expenses', Expenses\ExpensesController::class);
    Route::delete('expenses/file/delete/{file_id}', 'Expenses\ExpensesController@deleteFile')->name('expenses.deleteFile');

    // INVOICE
    Route::resource('invoices', 'Invoice\InvoicesController');
    Route::get('invoices/download/{id}', 'Invoice\InvoicesController@download')->name('invoices.download');
    Route::get('invoices/delivered/{id}/{status}', 'Invoice\InvoicesController@deliveryStatusChange')->name('invoices.delivery.status.change');
    Route::post('invoices/payments', 'Invoice\InvoicesController@addPayment')->name('invoices.add_payment');
    Route::get('invoices/payments/{invoice_id}', 'Invoice\InvoicesController@getPayments')->name('invoices.get_payments');
    Route::post('invoices/payments/send', 'Invoice\InvoicesController@sendInvoice')->name('invoices.sendInvoice');
    Route::get('invoices/payments/delete/{id}', 'Invoice\InvoicesController@deletePayment')->name('invoices.delete_payment');
    Route::get('invoices/make-payment/{id}', 'Invoice\InvoicesController@makePayment')->name('invoices.makePayment');
    Route::post('invoices/make-payment/{id}', 'Invoice\InvoicesController@makePaymentPost')->name('invoices.makePaymentPost');
    Route::get('invoices/customer-email/{id}', 'Invoice\InvoicesController@invoiceCustomerEmail');
    Route::get('invoices-print/{id}', 'Invoice\InvoicesController@print')->name('invoice.print');
    Route::get('kitchen-print/{id}', 'Invoice\InvoicesController@kitchenPrint')->name('kitchen.print');

    // SALE
    Route::resource('sales', 'Sale\SalesController');

    // SALE RETURN
    Route::resource('sales-return', 'Sale\SaleReturnController')->except(['create']);
    Route::get('sales-return/{sale_id}/create', 'Sale\SaleReturnController@create')
        ->name('sales-return.create');
    Route::get('sales-return-create', 'Sale\SaleReturnController@createList')
        ->name('sales-return.createable_list');
    Route::get('sales-return-requests', [SaleReturnRequestController::class, 'returnRequestList'])
        ->name('sales-return.requests');
    Route::get('products-return-request/{id}', [SaleReturnRequestController::class, 'returnRequestShow'])
        ->name('products-return-request.show');
    Route::get('products-return-request/accept/{id}', [SaleReturnRequestController::class, 'returnRequestAccept'])
        ->name('products-return-request.accept');
    Route::get('products-return-request/reject/{id}', [SaleReturnRequestController::class, 'returnRequestReject'])
        ->name('products-return-request.reject');

    // Purchase
    Route::resource('purchases', Purchase\PurchaseController::class);

    Route::get('purchases/{purchase}/cancel', [PurchaseController::class, 'cancelPurchase'])
        ->name('purchases.cancel');
    Route::post('purchases/{purchase}/cancel', [PurchaseController::class, 'storeCancelPurchase'])
        ->name('purchases.cancelPost');
    Route::get('purchases/{purchase}/confirm', [PurchaseController::class, 'confirmPurchase'])
        ->name('purchases.confirm');

    // Purchase Receive
    Route::get('purchases/{purchase}/receive', [PurchaseReceiveController::class, 'purchasesReceive'])
        ->name('purchases.receive');
    Route::post('purchases/{purchase}/receive', [PurchaseReceiveController::class, 'storePurchasesReceive'])
        ->name('purchases.receive.store');
    Route::get('purchases/receive/list', [PurchaseReceiveController::class, 'receives'])
        ->name('purchases.receive-list');
    Route::get('purchases/receive/show/{id}', [PurchaseReceiveController::class, 'receiveShow'])
        ->name('purchases.receive.show');
    Route::delete('purchases/receive/delete/{id}', [PurchaseReceiveController::class, 'receiveDelete'])
        ->name('purchases.receive.delete');

    // Purchase Return

    Route::get('purchases/{purchase}/return', [PurchaseReturnController::class, 'purchaseReturn'])
        ->name('purchases.return');
    Route::post('purchases/{purchase}/return', [PurchaseReturnController::class, 'storePurchaseReturn'])
        ->name('purchases.return.store');
    Route::get('purchases/return/list', [PurchaseReturnController::class, 'purchaseReturnList'])
        ->name('purchases.return.list');
    Route::get('purchases/return/show/{id}', [PurchaseReturnController::class, 'returnShow'])
        ->name('purchases.return.show');
    Route::delete('purchases/return/delete/{id}', [PurchaseReturnController::class, 'returnDelete'])
        ->name('purchases.return.delete');

    //COUPON
    Route::resource('coupons', Coupon\CouponController::class);
    Route::get('coupon-products/{id}', [CouponProductController::class, 'index'])->name('coupon.products');
    Route::post('coupon-products/store', [CouponProductController::class, 'store'])->name('coupon.product.store');
    Route::delete('coupon-products/destroy/{id}', [CouponProductController::class, 'destroy'])->name('coupon.product.destroy');

    // REPORTS
    Route::get('reports/expenses', 'Report\ReportsController@expenses')->name('reports.expenses');
    Route::get('reports/export/expenses', 'Report\ReportsController@exportExpenses')->name('reports.export.expenses');
    Route::get('reports/sales', 'Report\ReportsController@sales')->name('reports.sales');
    Route::get('reports/export/sales', 'Report\ReportsController@exportSales')->name('reports.export.sales');
    Route::get('reports/purchases', 'Report\ReportsController@purchases')->name('reports.purchases');
    Route::get('reports/export/purchases', 'Report\ReportsController@exportPurchases')->name('reports.export.purchases');
    Route::get('reports/payments', 'Report\ReportsController@payments')->name('reports.payments');
    Route::get('reports/export/payments', 'Report\ReportsController@exportPayments')->name('reports.export.payments');
    Route::get('reports/stock', 'Report\ReportsController@stock')->name('reports.stock');

    Route::get('reports/warehouse-stock', 'Report\ReportsController@warehouseStock')->name('report.warehouse-stock');
    Route::get('reports/loss-profit', 'Report\ReportsController@lossProfit')->name('report.loss-profit');

    // SYSTEM SETTINGS
    Route::get('system-settings', 'Settings\SystemSettingsController@edit')->name('system-settings.edit');
    Route::post('system-settings', 'Settings\SystemSettingsController@update')->name('system-settings.update');

    // PROFILE
    Route::get('profile', 'Administration\UsersController@profile')->name('user.profile');
    Route::put('profile/{profile}', 'Administration\UsersController@updateProfile')->name('user.profile.update');

    // HANDLE AJAX
    Route::prefix('api')->group(function () {
        // Attribute items
        Route::get('attribute-items/{id}', 'Attribute\AttributesController@attributeItems');

        Route::get('/product/search/name-sku/{query}', [AxiosController::class, 'productSearchNameSku'])->name('search-product-name-sku');
        Route::get('/product-stock/search/name-sku/{query}', [AxiosController::class, 'productStockSearchNameSku'])->name('search-product-name-sku');
        Route::get('/purchase_item/delete/{query}', [AxiosController::class, 'purchaseItemDelete']);


    });

    // HANDLE API REQUEST
    Route::prefix('app/api')->as('app-api.')->group(function () {
        // TODO: Because this api only handle forntend API and ajax
        // TODO: request so added "app" at prefix. its done for future.
        // TODO: If user try to build full feature API they can use "/api" endpint
        // Thanks me later
        

        // Search product by sku
        Route::get('/products/skus/search/{query}', 'Product\ProductsController@productSkuSearch');
        // Search product by name and sku
        Route::get('/products/name-sku/search/{query}', 'Product\ProductsController@productSearchByNameSku');
        Route::get('/product-stocks/name-sku/search/{query}/{warehouse_id}', 'Product\ProductsController@productStockSearchByNameSku');
        Route::get('/products/warehouse/search/{query}', 'Product\ProductsController@productSearchByWarehouse');
        Route::get('/product-stocks/warehouse/search/{id}', 'Product\ProductsController@productStockSearchByWarehouse');
        // Get product by category
        Route::get('/products/category/{id}', 'Product\ProductsController@getByCategory');
        Route::get('/product-stocks/category/{id}/{warehouse_id}', 'Product\ProductsController@getProductStockByCategory');
        // Get product by barcode
        Route::get('/products/barcode/{barcode}', 'Product\ProductsController@getByBarcode');
        Route::get('/product-stocks/barcode/{barcode}', 'Product\ProductsController@getProductStockByBarcode');

        Route::get('/active-coupon/{code}', [CouponController::class,'getActiveCouponByCode']);

        Route::get('/products/stack-update/{query}', 'Product\ProductsController@productQtyUpdate');


        // Dashboard product filter by (month, year, week)
        Route::get('top-product', 'DashboardController@getTopProduct')
            ->name('get-top-product');
    });
});
