<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'supplier_id' => 'required|exists:suppliers,id',

            'purchase_date' => 'required|date',

            'invoice_no' => 'nullable|max:255',

            'paid_amount' => 'nullable|numeric|min:0',

            'total_amount' => 'required|numeric|min:0',

            'due_amount' => 'required|numeric|min:0',

            'status' => 'required|boolean',

            'product_id.*' => 'required|exists:products,id',

            'quantity.*' => 'required|integer|min:1',

            'purchase_price.*' => 'required|numeric|min:0',

        ];
    }
}