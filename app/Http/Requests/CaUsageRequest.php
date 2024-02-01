<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaUsageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cash_advance_id' => ['nullable', 'exists:cash_advances,id'],
            'name' => ['required', 'string'],
            'date' => ['required', 'date'],
            'is_user_signature_showed' => ['nullable', 'in:on'],
            'is_draft' => ['nullable', 'boolean'],
        ];
    }
}
