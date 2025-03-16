<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\{Customer,ProductCategory,CouponProduct,Coupon,Cart,InvoiceItem,NewsletterSubscriber,IcContact};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
     /**
      * customer-Authentication
      * 
      * Register a new user.
     */
    public function register(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|unique:customers,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create customer
        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Automatically log the customer in
        $token = $customer->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Customer registered successfully.',
            'token' => $token,
        ], 201);
    }
    /**
     * Login user.
     */
    public function login(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check credentials
        if (!Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Generate token
        $customer = Auth::guard('customer')->user();
        $token = $customer->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Logged in successfully.',
            'token' => $token,
        ]);
    }
    /**
     * Get authenticated user details.
     */
    public function user(Request $request)
    {
        return response()->json([
            'customer' => $request->user(),
        ]);
    }

    /**
     * Update the authenticated customer's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function updateProfileAddress(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'zipcode' => 'nullable|string|max:20',
            'short_address' => 'nullable|string|max:255',
            'billing_same' => 'nullable|boolean',
            'b_first_name' => 'nullable|string|max:255',
            'b_last_name' => 'nullable|string|max:255',
            'b_email' => 'nullable|email|max:255',
            'b_phone' => 'nullable|string|max:20',
            'b_address_line_1' => 'nullable|string|max:255',
            'b_address_line_2' => 'nullable|string|max:255',
            'b_country' => 'nullable|string|max:100',
            'b_state' => 'nullable|string|max:100',
            'b_city' => 'nullable|string|max:100',
            'b_zipcode' => 'nullable|string|max:20',
            'b_short_address' => 'nullable|string|max:255',
        ]);

        // Update the customer's profile
        $customer = $request->user();
        $customer->update($validatedData);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'customer' => $customer,
        ], 200);
    }

    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out successfully.'
        ], 200);
    }

    //front-end without authentication
    public function getActiveProducts()
    {
        $roducts = Product::where('status', 'active')->where('available_for','!=','store')->get();
        return response()->json(['data' => $roducts]);
    }
    
    
    public function getSingleProduct($id)
    {
        $product = Product::where('id',$id)->get();
        return response()->json(['data' => $product]);
    }
    
    public function getAllCategories()
    {
        $categories = ProductCategory::all();
        return response()->json(['data'=>$categories]);
    }
    
    public function getProductByCategory($id)
    {
        $products = Product::where('category_id',$id)->get();
        return response()->json(['data'=>$products]);
    }
    
    public function validateCoupon(Request $request)
    {
        $couponCode = $request->input('code');
        $productIds = json_decode($request->input('product_ids'), true);

        $coupon = Coupon::select('id', 'discount_type', 'discount')
        ->where('status', 'active')
        ->where('code', $couponCode)
        ->first();
    
        if ($coupon) {
            $relatedProductIds = CouponProduct::where('coupon_id', $coupon->id)
                ->whereIn('product_id', $productIds)
                ->pluck('product_id');
        
            return response()->json([
                'status' => 'success',
                'coupon' => [
                    'discount_type' => $coupon->discount_type,
                    'discount' => $coupon->discount,
                ],
                'related_product_ids' => $relatedProductIds,
            ],200);
        } else {
            return response()->json([
                'status' => 'false',
                'error' => 'Coupon not found'
            ], 201);
        }
    }

    //cart-system
    // Add a product to the cart
    public function addToCart(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $coupon_discount = $request->input('coupon_discount');
        $amount = $request->input('amount');

        $cartId = Cart::where('customer_id', $userId)->where('product_id',$productId)->pluck('id')->first();
        if($cartId){
            $cart = Cart::find($cartId);
            $cart->quantity += $quantity;
            if($coupon_discount){
                $cart->coupon_discount = $coupon_discount;
            }
            $cart->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Cart Updated!',
                'cart' => $cart,
            ], 200);

        }else{
            $cart = Cart::Create(
                [
                    'customer_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'coupon_discount' => $coupon_discount,
                    'amount' => $amount,
                ],
            );
            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart.',
                'cart' => $cart,
            ], 200);
        }
        return response()->json([
            'status' => 'false',
            'message' => 'Something went wrong!',
        ], 201);
    }

    // Get all cart items for the authenticated customer
    public function getCart(Request $request)
    {
        $cartItems = Cart::where('customer_id', Auth::id())->with('product')->get();
        if($cartItems){
            return response()->json([
                'status' => 'success',
                'cart' => $cartItems,
            ], 200);
        }else{
            return response()->json([
                'status' => 'false',
                'message' => 'No record found',
            ], 201);
        }
    }
    
    // Remove a product from the cart
    public function removeFromCart(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->input('product_id');
        $cartItem = Cart::where('customer_id', $userId)->where('product_id',$productId)->first();
        if($cartItem){
            $cartItem->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from cart.'
            ], 200);
        }else{
            return response()->json([
                'status' => 'false',
                'message' => 'Cart item not found.'
            ], 201);
        }
    }

    public function popularProducts()
    {
        $most_sale_ids = InvoiceItem::select(DB::raw('product_id, sum(quantity) as total'))
                ->groupBy('product_id')
                ->orderBy('total', 'DESC')
                ->limit(5)
                ->pluck('product_id');

        $data = Product::whereIn('id', $most_sale_ids)->where('status','active')->get();
        if($data){
            return response()->json([
                'status' => 'success',
                'products' => $data
            ]);
        }else{
            return response()->json([
                'status' => 'false',
                'message' => 'No record found'
            ]);
        }
        

    }

    public function subscribe(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:newsletter_subscribers,email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $subscriber = NewsletterSubscriber::create([
                'email' => $request->input('email'),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Subscribed successfully!',
                'data' => $subscriber,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(), // Debugging: return exception message
            ], 500);
        }
    
    }

    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:newsletter_subscribers,email',
        ]);

        $subscriber = NewsletterSubscriber::where('email', $validated['email'])->first();
        $subscriber->update(['is_subscribed' => false]);

        return response()->json(['message' => 'Unsubscribed successfully!'], 200);
    }

    public function customerContact(Request $request)
    {
        // $name = $request->input('name');
        // $email = $request->input('email');
        // $subject = $request->input('subject');
        // $message = $request->input('message');

        try {
            // Validate incoming request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            // Store the data in the database
            $contact = IcContact::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'subject' => $request->input('subject'),
                'message' => $request->input('message'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Contact saved successfully!',
                'data' => $contact,
            ], 201);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ], 500);
        }
    



        // if($name,$email,$subject,$message);
    }


}
