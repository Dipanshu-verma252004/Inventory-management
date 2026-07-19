<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'customer_name' => 'required|max:255',

            'mobile' => 'required|max:20',

            'email' => 'nullable|email',

            'gst_no' => 'nullable|max:50',

            'address' => 'nullable',

            'status' => 'required|boolean',

        ];
    }
}
