<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoriaRequest extends FormRequest
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

        // dd($this->route());
        return [
            'categoria' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categorias', 'categoria')->ignore($this->route('categoria')),
            ],
            'empresa_id' => [
                'required',
                'integer',
                'exists:empresas,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'categoria.required' => 'O campo categoria é obrigatório.',
            'categoria.string' => 'O campo categoria deve ser uma string.',
            'categoria.max' => 'O campo categoria deve ter no máximo 255 caracteres.',
            'categoria.unique' => 'A categoria informada já está cadastrada.',
            'empresa_id.required' => 'O campo Id empresa é obrigatório.',
            'empresa_id.integer' => 'O campo Id empresa deve ser um número inteiro.',
            'empresa_id.exists' => 'A empresa informada não existe.',
        ];
    }
}
