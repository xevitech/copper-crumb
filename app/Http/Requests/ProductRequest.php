<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /*
        return [
            'category_id' => ['bail', 'required', 'numeric'],
            'name' => ['bail', 'required', 'min:1', 'max:200', Rule::unique('products')->ignore($this->product)],
            'sku' => ['bail', 'required', 'min:1', 'max:200', Rule::unique('products')->ignore($this->product)],
            'barcode' => ['bail', 'required', 'min:1', 'max:200', Rule::unique('products')->ignore($this->product)],
            'barcode_image' => ['nullable'],
            'brand_id' => ['bail', 'nullable', 'numeric'],
            'manufacturer_id' => ['bail', 'nullable', 'numeric'],
            'model' => ['bail', 'nullable', 'max:200'],
            'price' => ['bail', 'required', 'regex:/^(\d+(\.\d*)?)|(\.\d+)$/'],
            'weight' => ['bail','nullable', 'numeric', 'between:0,99999999.99'],
            'weight_unit_id' => ['bail', 'nullable', 'numeric', 'between:0,99999999.99'],
            'dimension_l' => ['bail', 'nullable', 'numeric', 'between:0,99999999.99'],
            'dimension_w' => ['bail', 'nullable', 'numeric', 'between:0,99999999.99'],
            'dimension_d' => ['bail', 'nullable', 'numeric', 'between:0,99999999.99'],
            'measurement_unit_id' => ['bail', 'nullable', 'numeric'],
            'notes' => ['bail', 'nullable', 'max:255'],
            'desc' => ['bail', 'nullable', 'max:10000'],
            'thumb' => ['bail', 'nullable', 'image', 'mimes:jpeg,jpg,png', 'max:300'],
            'is_variant' => ['bail', 'nullable'],
            'split_sale' => ['bail', 'nullable', 'boolean'],
            'attribute_data' => ['bail', 'nullable', 'array'],
            'tax_status' => ['bail', 'required'],
            'custom_tax' => ['bail', 'nullable', 'numeric', 'between:0,99999999.99'],
            'status' => ['bail', 'required', Rule::in([Product::STATUS_ACTIVE, Product::STATUS_INACTIVE])],
            'available_for' => ['bail', 'required', Rule::in(Product::SALE_AVAILABLE_FOR)],
            'customer_buying_price' => ['bail', 'nullable','regex:/^(\d+(\.\d*)?)|(\.\d+)$/'],
        ];
        */
        return [
            'category_id' => ['bail', 'required', 'numeric'],
            'name' => ['bail', 'required', 'min:1', 'max:200', Rule::unique('products')->ignore($this->product)],
            'sku' => ['bail', 'required', 'min:1', 'max:200', Rule::unique('products')->ignore($this->product)],
            'barcode' => ['bail', 'required', 'min:1', 'max:200', Rule::unique('products')->ignore($this->product)],
            'barcode_image' => ['nullable'],
            'brand_id' => ['bail', 'nullable', 'numeric'],
            'manufacturer_id' => ['bail', 'nullable', 'numeric'],
            'quantity' => ['bail', 'nullable', 'numeric'],
            'price' => ['bail', 'required', 'regex:/^(\d+(\.\d*)?)|(\.\d+)$/'],
            'weight' => ['bail','nullable', 'numeric', 'between:0,99999999.99'],
            'weight_unit_id' => ['bail', 'nullable', 'numeric', 'between:0,99999999.99'],
            'dimension_l' => ['bail', 'nullable', 'numeric', 'between:0,99999999.99'],
            'dimension_w' => ['bail', 'nullable', 'numeric', 'between:0,99999999.99'],
            'dimension_d' => ['bail', 'nullable', 'numeric', 'between:0,99999999.99'],
            'measurement_unit_id' => ['bail', 'nullable', 'numeric'],
            'notes' => ['bail', 'nullable', 'max:255'],
            'desc' => ['bail', 'nullable', 'max:10000'],
            'thumb' => ['bail', 'nullable', 'image', 'mimes:jpeg,jpg,png', 'max:300'],
            'feature_image' => ['bail', 'nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'image_1' => ['bail', 'nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'image_2' => ['bail', 'nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'tag_1' => ['nullable'],
            'tag_2' => ['nullable'],
            'tag_3' => ['nullable'],
            'is_variant' => ['bail', 'nullable'],
            'split_sale' => ['bail', 'nullable', 'boolean'],
            'attribute_data' => ['bail', 'nullable', 'array'],
            'tax_status' => ['bail', 'required'],
            'custom_tax' => ['bail', 'nullable', 'numeric', 'between:0,99999999.99'],
            'sgst_tax' => ['bail', 'nullable', 'numeric', 'between:0,99999999.99'],
            'igst_tax' => ['bail', 'nullable', 'numeric', 'between:0,99999999.99'],
            'status' => ['bail', 'required', Rule::in([Product::STATUS_ACTIVE, Product::STATUS_INACTIVE])],
            'available_for' => ['bail', 'nullable', Rule::in(Product::SALE_AVAILABLE_FOR)],
            'customer_buying_price' => ['bail', 'nullable','regex:/^(\d+(\.\d*)?)|(\.\d+)$/'],
        ];
    }
}
