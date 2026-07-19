<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [

            'category_id'=>'required|exists:categories,id',

            'brand_id'=>'required|exists:brands,id',

            'unit_id'=>'required|exists:units,id',

            'supplier_id'=>'required|exists:suppliers,id',

            'product_name'=>'required|max:255',

            'sku'=>'required|unique:products,sku',

            'barcode'=>'nullable|max:100',

            'purchase_price'=>'required|numeric',

            'selling_price'=>'required|numeric',

            'opening_stock'=>'required|integer',

            'minimum_stock'=>'required|integer',

            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'description'=>'nullable',

            'status'=>'required|boolean',

        ];
    }
}