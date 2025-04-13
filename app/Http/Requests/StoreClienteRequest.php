<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'cpf' => [
                'required',
                'string',
                'max:255',
                Rule::unique('clientes')->ignore($this->route('cliente')),
            ],
            'data_nascimento' => [
                'required',
                'date',
            ],
            'whatsapp' => [
                'required',
                'string',
                'max:255',
            ],
            'telefone' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'nullable',
                'email',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatória.',
            'name.string' => 'O nome deve ser um texto.',
            'name.min' => 'O nome deve ter no mínimo 5 caracteres.',
            'name.max' => 'O nome deve ter no mínimo 255 caracteres.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.string' => 'O CPF deve ser um texto.',
            'cpf.max' => 'O CPF deve ter no máximo 255 caracteres.',
            'cpf.unique' => 'O CPF já está cadastrado.',
            'data_nascimento.required' => 'A data de nascimento é obrigaória.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'whatsapp.required' => 'O whatsapp é obrigatório.',
            'whatsapp.string' => 'O whatsapp deve ser um texto.',
            'whatsapp.max' => 'O whatsapp não pode ter mais que 255 caracteres.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.string' => 'O telefone deve ser um texto.',
            'telefone.max' => 'O telefone não pode ter mais que 255 caracteres.',
            'email.email' => 'Email inválido.',
            'email.unique' => 'O email já está cadastrado.',
        ];
    }
}
