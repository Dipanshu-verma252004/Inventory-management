<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnitRequest extends FormRequest
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
    $unitId = $this->route('unit');

    return [
        'name' => [
            'required',
            'max:255',
            Rule::unique('units', 'name')->ignore($unitId),
        ],

        'short_name' => 'required|max:20',

        'description' => 'nullable',

        'status' => 'required|boolean',
    ];
}
}
