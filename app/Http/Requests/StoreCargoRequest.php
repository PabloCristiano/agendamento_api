<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCargoRequest extends FormRequest
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
            'cargo' => [
                'required',
                'min:5',
            ],
            'empresa_id' => [
                'required',
                'exists:App\Models\Empresa,id'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'cargo.required' => 'O cargo é obrigatório',
            'cargo.min' => 'O cargo deve ter no mínimo 5 caracteres',
            'empresa_id.required' => 'A empresa é obrigatório',
            'empresa_id.exists' => 'A empresa não existe'
        ];
    }
}
