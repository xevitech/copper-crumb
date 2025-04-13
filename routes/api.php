<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\HdfcPaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('test', [FrontendController::class, 'test']);

Route::prefix('v1')->group(function () {
    //customer auth
    Route::post('register', [FrontendController::class, 'register']);
    Route::post('login', [FrontendController::class, 'login']);

    Route::middleware('auth:api_customer')->group(function () {
        // Customer details and logout
        Route::get('/customer-details', [FrontendController::class, 'user']);
        Route::post('/logout', [FrontendController::class, 'logout']);
        Route::put('/update-profile-address', [FrontendController::class, 'updateProfileAddress']);
    
        // Cart routes
        Route::post('cart/add', [FrontendController::class, 'addToCart']);
        Route::post('cart/update-quantity', [FrontendController::class, 'updateCartQuantity']);
        Route::get('/cart', [FrontendController::class, 'getCart']);
        Route::post('cart/remove', [FrontendController::class, 'removeFromCart']);
    });
 
    Route::get('products', [FrontendController::class, 'getActiveProducts']);
    // Route::post('clogin', [FrontendController::class, 'websiteCustomerLogin']);
    Route::get('product/{id}',[FrontendController::class, 'getSingleProduct']);
    Route::get('/variants/{variantId}/attributes', [FrontendController::class, 'getAttributesByVariant']);
    Route::get('/product-stock', [FrontendController::class, 'getStockByProductAndAttribute']);
    Route::get('category-product/{id}',[FrontendController::class, 'getProductByCategory']);
    Route::get('categories',[FrontendController::class, 'getAllCategories']);
    Route::post('validate-coupon',[FrontendController::class, 'validateCoupon']);

    Route::get('popular-products',[FrontendController::class,'popularProducts']);

    Route::post('newsletter/subscribe', [FrontendController::class, 'subscribe']);
    Route::post('newsletter/unsubscribe', [FrontendController::class, 'unsubscribe']);
    Route::post('customer/contact', [FrontendController::class, 'customerContact']);

    Route::post('checkout',[HdfcPaymentController::class, 'initiatePayment']);
});