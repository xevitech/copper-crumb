<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Blog;
use App\Models\Attribute;
use App\Models\AttributeItem;
use App\Models\ProductStock;
use App\Models\PaymentSession;
use App\Models\Order;
use App\Models\{Customer,ProductCategory,CouponProduct,Coupon,Cart,InvoiceItem,NewsletterSubscriber,IcContact};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Services\Product\ProductService;
use App\Services\Warehouse\WarehouseService;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;

class FrontendController extends Controller
{
    protected $warehouseService;
    protected $productService;

    public function __construct(
        ProductService $productService,
        WarehouseService $warehouseService,
    ){
        $this->productService = $productService;
        $this->warehouseService = $warehouseService;
    }
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
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
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

    public function getActiveProducts()
    {
        $products = ProductStock::with([
                'product.category', 
                'product.brand', 
                'product.weight_unit',
                'product.measurement_unit',
                'attribute' => function ($query) {
                    $query->where('status', 'active'); // Only active attributes
                },
            ])
            ->whereHas('product', function ($q) {
                $q->where('status', 'active')
                    ->where('available_for', '!=', Product::SALE_AVAILABLE_FOR['store']);
            })
            ->get();
    
        $formattedProducts = [];
    
        foreach ($products as $item) {
            $product = $item->product;
            $productId = $product->id;
    
            // If the product is not added yet, initialize it
            if (!isset($formattedProducts[$productId])) {
                $formattedProducts[$productId] = [
                    'id' => $productId,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'barcode' => $product->barcode,
                    'barcode_image' => $product->barcode_image,
                    'price' => $product->price,
                    'customer_buying_price' => $product->customer_buying_price,
                    'weight' => $product->weight,
                    'thumb' => $product->thumb,
                    'sgst_tax' => $product->sgst_tax,
                    'igst_tax' => $product->igst_tax,
                    'feature_image' => $product->feature_image,
                    'image_1' => $product->image_1,
                    'image_2' => $product->image_2,
                    'tag_1' => $product->tag_1,
                    'tag_2' => $product->tag_2,
                    'tag_3' => $product->tag_3,
                    'notes' => $product->notes,
                    'desc' => $product->desc,
                    'is_variant' => (bool) $product->is_variant,
                    'category' => [
                        'id' => $product->category->id ?? null,
                        'name' => $product->category->name ?? null,
                        'parent' => !empty($product->category->parent_category) ? [
                            'id' => $product->category->parent_category->id,
                            'name' => $product->category->parent_category->name
                        ] : null,
                    ],
                    'brand' => [
                        'id' => $product->brand->id ?? null,
                        'name' => $product->brand->name ?? null
                    ],
                    'weight_unit' => [
                        'id' => $product->weight_unit->id ?? null,
                        'name' => $product->weight_unit->name ?? null
                    ],
                    'measurement_unit' => [
                        'id' => $product->measurement_unit->id ?? null,
                        'name' => $product->measurement_unit->name ?? null
                    ],
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                    'tax_status' => $product->tax_status,
                    'custom_tax' => $product->custom_tax,
                    'stock' => $product->stock,
                    'thumb_url' => $product->thumb_url,
                    'variants' => []
                ];
            }
    
            // If the product is a variant and has an active attribute
            if ($product->is_variant && $item->attribute && $item->attribute->status === 'active') {
                $variantId = $item->attribute->id;
                $variantName = $item->attribute->name;
    
                // Check if the variant already exists in the product array
                $variantIndex = array_search($variantId, array_column($formattedProducts[$productId]['variants'], 'id'));
    
                // If variant doesn't exist, create it
                if ($variantIndex === false) {
                    $formattedProducts[$productId]['variants'][] = [
                        'id' => $variantId,
                        'name' => $variantName,
                        'items' => []
                    ];
                    $variantIndex = array_key_last($formattedProducts[$productId]['variants']);
                }
    
                // Add all active attribute items under the variant
                $formattedProducts[$productId]['variants'][$variantIndex]['items'][] = [
                    'id' => $item->attributeItem->id ?? null,
                    'name' => $item->attributeItem->name ?? null,
                    'price' => $item->price,
                    'customer_buying_price' => $item->customer_buying_price,
                    'price_for_sale' => $item->price_for_sale,
                    'stock' => $item->quantity,
                    'image' => $item->attributeItem->file_url ?? $item->product->thumb_url
                ];
            }
        }
    
        // Convert associative array to indexed array
        return response()->json(['data' => array_values($formattedProducts)], 200);
    }
        
    
    public function getSingleProduct($id)
    {
        $products = ProductStock::with([
            'product.category', 
            'product.brand', 
            'product.weight_unit',
            'product.measurement_unit',
            'attribute' => function ($query) {
                $query->where('status', 'active'); // Only active attributes
            },
        ])->where('product_id',$id)
        ->whereHas('product', function ($q) {
            $q->where('status', 'active')
                ->where('available_for', '!=', Product::SALE_AVAILABLE_FOR['store']);
        })
        ->get();

        $formattedProduct = [];

        foreach ($products as $item) {
            $product = $item->product;
            $productId = $product->id;

            // If the product is not added yet, initialize it
            if (!isset($formattedProduct[$productId])) {
                $formattedProduct[$productId] = [
                    'id' => $productId,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'barcode' => $product->barcode,
                    'barcode_image' => $product->barcode_image,
                    'price' => $product->price,
                    'customer_buying_price' => $product->customer_buying_price,
                    'weight' => $product->weight,
                    'thumb' => $product->thumb,
                    'sgst_tax' => $product->sgst_tax,
                    'igst_tax' => $product->igst_tax,
                    'feature_image' => $product->feature_image,
                    'image_1' => $product->image_1,
                    'image_2' => $product->image_2,
                    'tag_1' => $product->tag_1,
                    'tag_2' => $product->tag_2,
                    'tag_3' => $product->tag_3,
                    'notes' => $product->notes,
                    'desc' => $product->desc,
                    'is_variant' => (bool) $product->is_variant,
                    'category' => [
                        'id' => $product->category->id ?? null,
                        'name' => $product->category->name ?? null,
                        'parent' => !empty($product->category->parent_category) ? [
                            'id' => $product->category->parent_category->id,
                            'name' => $product->category->parent_category->name
                        ] : null,
                    ],
                    'brand' => [
                        'id' => $product->brand->id ?? null,
                        'name' => $product->brand->name ?? null
                    ],
                    'weight_unit' => [
                        'id' => $product->weight_unit->id ?? null,
                        'name' => $product->weight_unit->name ?? null
                    ],
                    'measurement_unit' => [
                        'id' => $product->measurement_unit->id ?? null,
                        'name' => $product->measurement_unit->name ?? null
                    ],
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                    'tax_status' => $product->tax_status,
                    'custom_tax' => $product->custom_tax,
                    'stock' => $product->stock,
                    'thumb_url' => $product->thumb_url,
                    'variants' => []
                ];
            }

            // If the product is a variant and has an active attribute
            /*
            if ($product->is_variant && $item->attribute && $item->attribute->status === 'active') {
                $variantId = $item->attribute->id;
                $variantName = $item->attribute->name;

                // Check if the variant already exists in the product array
                $variantIndex = array_search($variantId, array_column($formattedProduct[$productId]['variants'], 'id'));

                // If variant doesn't exist, create it
                if ($variantIndex === false) {
                    $formattedProduct[$productId]['variants'][] = [
                        'id' => $variantId,
                        'name' => $variantName,
                        'items' => []
                    ];
                    $variantIndex = array_key_last($formattedProduct[$productId]['variants']);
                }

                // Add all active attribute items under the variant
                $formattedProduct[$productId]['variants'][$variantIndex]['items'][] = [
                    'id' => $item->attributeItem->id ?? null,
                    'name' => $item->attributeItem->name ?? null,
                    'price' => $item->price,
                    'customer_buying_price' => $item->customer_buying_price,
                    'price_for_sale' => $item->price_for_sale,
                    'stock' => $item->quantity,
                    'image' => $item->attributeItem->file_url ?? $item->product->thumb_url
                ];
            }
            */
            // If the product is a variant and has an active attribute
            if ($product->is_variant && $item->attribute && $item->attribute->status === 'active') {
                $variantId = $item->attribute->id;
                $variantName = $item->attribute->name;
    
                // Check if the variant ID is already present in the array
                $exists = array_filter($formattedProduct[$productId]['variants'], function ($variant) use ($variantId) {
                    return $variant['id'] === $variantId;
                });
    
                // Add only if it doesn't already exist
                if (empty($exists)) {
                    $formattedProduct[$productId]['variants'][] = [
                        'id' => $variantId,
                        'name' => $variantName
                    ];
                }
            }
        }

        // Convert associative array to indexed array
        return response()->json(['data' => array_values($formattedProduct)], 200);
    }

    public function getAttributesByVariant($variantId)
    {

        $attribute = Attribute::with(['items' => function ($query) {
            $query->select('id', 'name', 'attribute_id');
        }])->where('status', 'active')
          ->where('id', $variantId)
          ->first();
    
        if (!$attribute) {
            return response()->json(['message' => 'No attribute found for this variant'], 404);
        }
    
        // Extract only the items array with required fields
        $formattedItems = $attribute->items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                // 'file_url' => $item->file_url,
            ];
        });

        // dd($formattedItems->toArray());

        return response()->json(['data' => $formattedItems], 200);
    }

    public function getStockByProductAndAttribute(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'attribute_item_id' => 'required|integer',
        ]);

        $stocks = ProductStock::where('product_id', $request->product_id)
        ->where('attribute_item_id', $request->attribute_item_id)
        ->get(['id', 'customer_buying_price'])
        ->makeHidden(['price_for_sale']);

        return response()->json(['data' => $stocks], 200);
    }

    public function getAllCategories()
    {
        $productsCategoryIds = Product::where('available_for', '!=', 'store')
                                        ->pluck('category_id')
                                        ->unique();
        $categories = ProductCategory::whereIn('id',$productsCategoryIds)->get();
    
        $grouped = $categories->groupBy('parent_id');
    
        $formatCategories = function ($parentId) use ($grouped, &$formatCategories) {
            return $grouped->get($parentId, collect())->map(function ($category) use ($formatCategories) {
                return array_merge($category->toArray(), [
                    'subcategories' => $formatCategories($category->id)
                ]);
            });
        };
    
        $structuredCategories = $formatCategories(null);
    
        return response()->json(['data' => $structuredCategories]);
    }
        
    
    public function getProductByCategory($id)
    {
        $products = Product::where('category_id',$id)->where('available_for', '!=', Product::SALE_AVAILABLE_FOR['store'])->get();
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
        $quantity = $request->input('quantity', 1);
        $couponDiscount = $request->input('coupon_discount', 0);
        $amount = $request->input('amount');
        $isVariant = $request->input('is_varient', 0); // 1 if variant, 0 if simple
        $attributeId = $request->input('attribute_id'); // Variant group (e.g., size)
        $attributeItemId = $request->input('attribute_item_id'); // Variant option (e.g., Medium)
    
        // Query for an existing cart entry
        $cartQuery = Cart::where('customer_id', $userId)
            ->where('product_id', $productId);
    
        if ($isVariant) {
           
            $cartQuery->where('attribute_id', $attributeId)
                      ->where('attribute_item_id', $attributeItemId);
        }
    
        $cartItem = $cartQuery->first();
    
        if ($cartItem) {
            $cartItem->quantity += $quantity;
            if ($couponDiscount) {
                $cartItem->coupon_discount = $couponDiscount;
            }
            $cartItem->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Cart updated!',
                'cart' => $cartItem,
            ], 200);
        } else {
            $cartItem = Cart::create([
                'customer_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'coupon_discount' => $couponDiscount,
                'amount' => $amount,
                'attribute_id' => $isVariant ? $attributeId : null,
                'attribute_item_id' => $isVariant ? $attributeItemId : null,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart.',
                'cart' => $cartItem,
            ], 201);
        }
    }

    public function updateCartQuantity(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->input('product_id');
        $newQuantity = $request->input('quantity');
        $attributeId = $request->input('attribute_id'); // Nullable
        $attributeItemId = $request->input('attribute_item_id'); // Nullable

        if (!$productId || !$newQuantity || $newQuantity <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid request. Please provide a valid product and quantity.'
            ], 201);
        }

        $cartQuery = Cart::where('customer_id', $userId)
            ->where('product_id', $productId);

        if (!is_null($attributeId) && !is_null($attributeItemId)) {
            $cartQuery->where('attribute_id', $attributeId)
                    ->where('attribute_item_id', $attributeItemId);
        }

        $cartItem = $cartQuery->first();

        if (!$cartItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart item not found.'
            ], 201);
        }

        $cartItem->update(['quantity' => $newQuantity]);

        return response()->json([
            'status' => 'success',
            'message' => 'Cart updated successfully.',
            'quantity'=> $newQuantity
        ], 200);
    }

    

    // Get all cart items for the authenticated customer
    /*
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
    */

    public function getCart(Request $request)
    {
        $userId = Auth::id();

        $cartItems = Cart::where('customer_id', $userId)
            ->with('product') // Load related product
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'cart' => [],
                'message' => 'No items found in cart'
            ], 200);
        }

        $totalTax = 0;

        $cartData = $cartItems->map(function ($cart) use (&$totalTax){
            $isVariant = !is_null($cart->attribute_id) && !is_null($cart->attribute_item_id);

            $product = $cart->product;
            // Calculate tax if tax_status is included
            if ($product && $product->tax_status === 'included') {
                $taxRate = $product->custom_tax ?? 0;
                $itemTax = ($cart->amount * $taxRate / (100 + $taxRate)) * $cart->quantity;
                $totalTax += round($itemTax, 2);
            }

            return [
                'id' => $cart->id,
                'product' => $cart->product,
                'quantity' => $cart->quantity,
                'price' => $cart->amount,
                'is_variant' => $isVariant,
                'variant' => $isVariant ? [
                    'attribute_id' => $cart->attribute_id,
                    'attribute_name' => $this->getAttributeName($cart->attribute_id),
                    'attribute_item_id' => $cart->attribute_item_id,
                    'variant_name' => $this->getVariantName($cart->attribute_item_id) // Get variant name dynamically
                ] : null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'cart' => $cartData,
            'total_tax' => $totalTax
        ], 200);
    }

    private function getAttributeName($attributeId)
    {
        $attribute = Attribute::find($attributeId);
        return $attribute ? $attribute->name : null;
    }

    private function getVariantName($attributeItemId)
    {
        $variant = AttributeItem::find($attributeItemId);
        return $variant ? $variant->name : null;
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

        $data = Product::whereIn('id', $most_sale_ids)->where('status','active')->where('available_for', '!=', Product::SALE_AVAILABLE_FOR['store'])->get();
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
            ], 200);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ], 201);
        }
    



        // if($name,$email,$subject,$message);
    }

    public function blogs()
    {
        $data = Blog::where('status','active')->get();

        if ($data) {
            return response()->json([
                'data' => $data
            ]);
        }

        return response()->json([
            'data' => []
        ]);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->active()->first();

        if ($blog) {
            return response()->json([
                'success' => true,
                'data' => $blog,
            ],200);
        }

        return response()->json([
            'success' => false,
            'data' => []
        ], 202);
    }

    public function getOrders()
    {
        $userId = Auth()->id();

        $orders = Order::with('paymentSession')->where('customer_id',$userId)->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'status'=> false,
                'message' => 'Order not found',
                'data' => []
            ],201);
        }

        $orders->each(function ($order) {
            if ($order->paymentSession) {
                $order->paymentSession->payload = json_decode($order->paymentSession->payload, true);
                $order->paymentSession->invoice_data = json_decode($order->paymentSession->invoice_data, true);
            }
        });

        return response()->json([
            'status'=> true,
            'message' => 'Order list',
            'data' => $orders
        ]);
        
    }

    public function getOrderDetail(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string'
        ]);

        $userId = Auth()->id();

        $order = PaymentSession::with('orders')
            ->where('order_id', $request->order_id)
            ->whereHas('orders', function ($query) use ($userId) {
                $query->where('customer_id', $userId);
            })
            ->first();

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found',
                'data' => []
            ], 201);
        }

        $order->payload = json_decode($order->payload, true);
        $order->invoice_data = json_decode($order->invoice_data, true);

        return response()->json([
            'status' => true,
            'message' => 'Order details',
            'data' => $order
        ], 201);
    }

    // public function resetPassword(Request $request)
    // {
    //     // dd(Auth()->user());
    //     // Validate the request
    //     $validated = $request->validate([
    //         'password' => 'required|string|min:6|confirmed',
    //     ]);
    
    //     $customer = Auth()->user(); // already authenticated via token
    
    //     $customer->password = Hash::make($validated['password']);
    //     $customer->save();
    
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Password updated successfully.'
    //     ]);
    // }

    public function resetPassword(Request $request)
    {
        try {
            // Check if authenticated user exists
            $customer = auth()->user();
            if (!$customer) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized access.',
                ], 202);
            }

            // Validate the request
            $validated = $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);

            // Update password
            $customer->password = Hash::make($validated['password']);
            $customer->save();

            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully.',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $firstMessage = collect($e->errors())->flatten()->first();
            return response()->json([
                'status' => false,
                'message' => $firstMessage,
            ], 202);
        } catch (\Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());
            
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again later.',
            ], 202);
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            // Validate email
            $validated = $request->validate([
                'email' => 'required|email|exists:customers,email',
            ]);

            // Find customer by email
            $customer = Customer::where('email', $validated['email'])->first();

            if (!$customer) {
                return response()->json([
                    'status' => false,
                    'message' => 'Customer not found.',
                ], 202);
            }

            // dd('##################',$customer->email);
            $otp = rand(100000, 999999);
            // Generate and store OTP (or use your own reset flow)
            // dd($request->email,$otp);
            $customer->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10),
                'otp_verified_at' => null,
            ]);

            // dd($otp);

            Mail::to($customer->email)->send(new SendOtpMail($otp));

            return response()->json([
                'status' => true,
                'message' => 'OTP has been sent to your email address.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $firstMessage = collect($e->errors())->flatten()->first();

            return response()->json([
                'status' => false,
                'message' => $firstMessage,
            ], 202);
        } catch (\Exception $e) {
            // \Log::error('Forgot password error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again later.',
            ], 202);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            // Validate request input
            $validated = $request->validate([
                'email' => 'required|email|exists:customers,email',
                'otp' => 'required|digits:6',
            ]);

            // Retrieve customer
            $customer = Customer::where('email', $validated['email'])->first();

            // Check if OTP matches and is not expired
            if (
                !$customer->otp ||
                $customer->otp !== $validated['otp'] ||
                now()->greaterThan($customer->otp_expires_at)
            ) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid or expired OTP.',
                ], 202);
            }

            // Optional: Invalidate the OTP after successful verification
            $customer->otp = null;
            $customer->otp_expires_at = null;
            $customer->otp_verified_at = now();
            $customer->save();

            //  OTP is valid
            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully.',
                'verified_at' => $customer->otp_verified_at,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $firstMessage = collect($e->errors())->flatten()->first();

            return response()->json([
                'status' => false,
                'message' => $firstMessage,
            ], 202);
        } catch (\Exception $e) {
            // Log::error('OTP verification error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again later.',
            ], 202);
        }
    }

    public function createPassword(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'email' => 'required|email|exists:customers,email',
                'password' => 'required|string|min:6|confirmed',
            ]);

            // Fetch customer using email
            $customer = Customer::where('email', $validated['email'])->first();

            if (!$customer) {
                return response()->json([
                    'status' => false,
                    'message' => 'Customer not found.',
                ], 202);
            }

            // Check if OTP was verified
            if (is_null($customer->otp_verified_at)) {
                return response()->json([
                    'status' => false,
                    'message' => 'OTP not verified. Please verify OTP first.',
                ], 202);
            }

            // Ensure reset is within 5 minutes of verification
            if (now()->diffInMinutes($customer->otp_verified_at) > 5) {
                return response()->json([
                    'status' => false,
                    'message' => 'OTP verification timed out. Please retry.',
                ], 202);
            }

            // Reset password and clear otp_verified_at
            $customer->password = bcrypt($validated['password']);
            $customer->otp_verified_at = null;
            $customer->save();

            return response()->json([
                'status' => true,
                'message' => 'Password reset successfully.',
            ],200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $firstMessage = collect($e->errors())->flatten()->first();

            return response()->json([
                'status' => false,
                'message' => $firstMessage,
            ], 202);
        } catch (\Exception $e) {
            \Log::error('Reset password error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again later.',
            ], 202);
        }
    }







}
