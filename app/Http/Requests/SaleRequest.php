<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'customer_id' => 'required|exists:customers,id',

            'sale_date' => 'required|date',

            'invoice_no' => 'nullable|max:100',

            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',

            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',

            'selling_price' => 'required|array|min:1',
            'selling_price.*' => 'required|numeric|min:0',

            'total_amount' => 'required|numeric|min:0',

            'paid_amount' => 'nullable|numeric|min:0',

            'due_amount' => 'nullable|numeric|min:0',

            'status' => 'required|boolean',

        ];
    }
}