<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules.
     */
    public function rules(): array
    {
        $supplierId = $this->route('supplier');

        return [

            'supplier_name' => [
                'required',
                'max:255',
                Rule::unique('suppliers', 'supplier_name')->ignore($supplierId),
            ],

            'company_name' => 'nullable|max:255',

            'contact_person' => 'nullable|max:255',

            'gst_number' => 'nullable|max:30',

            'phone' => 'required|max:20',

            'alternate_phone' => 'nullable|max:20',

            'email' => 'nullable|email',

            'website' => 'nullable|url',

            'address' => 'nullable',

            'city' => 'nullable|max:100',

            'state' => 'nullable|max:100',

            'country' => 'nullable|max:100',

            'postal_code' => 'nullable|max:20',

            'status' => 'required|boolean',

        ];
    }
}