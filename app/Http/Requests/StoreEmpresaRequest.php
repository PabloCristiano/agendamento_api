<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmpresaRequest extends FormRequest
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
            'razao_social' => [
                'required',
                'Min:5',
            ],
            'cnpj' => [
                'required',
                'min:14',
                'max:18',
                Rule::unique('empresas')->ignore($this->route('empresa')),
            ],
            'nome_responsavel' => [
                'required',
                'min:3',
            ],
            'telefone' => [
                'required',
                'max:14',
            ],
            'email' => [
                'required',
                'email',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'razao_social.required' => 'A Razão Social é obrigatória.',
            'razao_social.min' => 'A Razão Social deve ter no mínimo 5 caracteres.',
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.min' => 'O CNPJ deve ter no mínimo 14 caracteres.',
            'cnpj.max' => 'O CNPJ deve ter no máximo 18 caracteres.',
            'cnpj.unique' => 'O CNPJ já está cadastrado.',
            'nome_responsavel.required' => 'O  nome do responsável é obrigatório.',
            'nome_responsavel.min' => 'O nome do responsável deve ter no mínimo 5 caracteres.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.max' => 'O telefone deve ter no máximo 14 digitos.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Email inválido.',
        ];
    }
}
