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
                'Min:3',
            ],
            'cpf' => [
                'required',
                'min:11',
                'max:14',
                Rule::unique('profissionais')->ignore($this->route('profissional')),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('profissionais')->ignore($this->route('profissional')),
            ],
            'telefone' => [
                'required',
                'max:14',
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
            'name.min' => 'O nome deve ter no mínimo 5 caracteres.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.min' => 'O CPF deve ter no mínimo 11 caracteres.',
            'cpf.max' => 'O CPF deve ter no máximo 14 caracteres.',
            'cpf.unique' => 'O CPF já está cadastrado.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Email inválido.',
            'email.unique' => 'O email já está cadastrado.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.max' => 'O telefone deve ter no máximo 14 digitos.',
            'password.required' => 'A senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            "cargo_id.required" => 'O cargo é obrigatório.',
            "cargo_id.exists" => 'Cargo inválido.',
            "empresa_id.required" => 'A empresa é obrigatório.',
            "empresa_id.exists" => 'Empresa inválida.',
        ];
    }
}
