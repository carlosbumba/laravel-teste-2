<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneValidationRequest extends FormRequest
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
            'number' => ['required', 'string'],
            'country_code' => ['nullable', 'string', 'size:2'], // Ex: 'US', 'BR'
        ];
    }

    public function messages(): array
    {
        return [
            'country_code.size' => 'O código do país deve conter 2 letras.',
        ];
    }
}
