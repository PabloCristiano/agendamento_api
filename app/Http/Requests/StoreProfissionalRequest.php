<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreProfissionalRequest extends FormRequest
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
                'max:255'
            ],
            'cpf' => [
                'required',
                'string',
                'max:255',
                Rule::unique('profissionais')->ignore($this->route('profissional')),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('profissionais')->ignore($this->route('profissional')),
            ],
            'telefone' => [
                'required',
                'string',
                'max:255',
            ],
            'password' => [
                'required',
                Password::min(8),
            ],
            'cargo_id' => [
                'required',
                'exists:App\Models\Cargo,id'
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
            'name.required' => 'O nome é obrigatória.',
            'name.string' => 'O nome deve ser um texto.',
            'name.min' => 'O nome deve ter no mínimo 5 caracteres.',
            'name.max' => 'O nome deve ter no mínimo 255 caracteres.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.string' => 'O CPF deve ser um texto.',
            'cpf.max' => 'O CPF deve ter no máximo 255 caracteres.',
            'cpf.unique' => 'O CPF já está cadastrado.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Email inválido.',
            'email.unique' => 'O email já está cadastrado.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.string' => 'O telefone deve ser um texto.',
            'telefone.max' => 'O telefone não pode ter mais que 255 caracteres.',
            'password.required' => 'A senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            "cargo_id.required" => 'O cargo é obrigatório.',
            "cargo_id.exists" => 'Cargo inválido.',
            "empresa_id.required" => 'A empresa é obrigatório.',
            "empresa_id.exists" => 'Empresa inválida.',
        ];
    }
}
