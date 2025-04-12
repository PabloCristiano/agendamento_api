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
            'string',
            'max:255',
            'min:5',
            ],
            'nome_fantasia' => [
            'nullable',
            'string',
            'max:255',
            ],
            'tipo_pessoa' => [
            'nullable',
            'string',
            'max:255',
            ],
            'cnpj' => [
            'required',
            'string',
            'max:255',
            Rule::unique('empresas')->ignore($this->route('empresa')),
            ],
            'nome_responsavel' => [
            'required',
            'string',
            'max:255',
            'min:3',
            ],
            'telefone' => [
            'required',
            'string',
            'max:255',
            ],
            'email' => [
            'required',
            'string',
            'email',
            'max:255',
            ],
            'logradouro' => [
            'required',
            'string',
            'max:255',
            ],
            'numero' => [
            'required',
            'string',
            'max:255',
            ],
            'complemento' => [
            'nullable',
            'string',
            'max:255',
            ],
            'bairro' => [
            'required',
            'string',
            'max:255',
            ],
            'cep' => [
            'required',
            'string',
            'max:255',
            ],
            'status' => [
            'required',
            'boolean',
            ],
            'observacao' => [
            'nullable',
            'string',
            ],
        ];
    }

    public function messages(): array
    {
    return [
        'razao_social.required' => 'O campo razão social é obrigatório.',
        'razao_social.string' => 'O campo razão social deve ser um texto.',
        'razao_social.max' => 'O campo razão social não pode ter mais que 255 caracteres.',
        'razao_social.min' => 'O campo razão social deve ter pelo menos 5 caracteres.',
        'nome_fantasia.string' => 'O campo nome fantasia deve ser um texto.',
        'nome_fantasia.max' => 'O campo nome fantasia não pode ter mais que 255 caracteres.',
        'tipo_pessoa.string' => 'O campo tipo de pessoa deve ser um texto.',
        'tipo_pessoa.max' => 'O campo tipo de pessoa não pode ter mais que 255 caracteres.',
        'cnpj.required' => 'O campo CNPJ é obrigatório.',
        'cnpj.string' => 'O campo CNPJ deve ser um texto.',
        'cnpj.max' => 'O campo CNPJ não pode ter mais que 255 caracteres.',
        'cnpj.unique' => 'O CNPJ informado já está cadastrado.',
        'nome_responsavel.required' => 'O campo nome do responsável é obrigatório.',
        'nome_responsavel.string' => 'O campo nome do responsável deve ser um texto.',
        'nome_responsavel.max' => 'O campo nome do responsável não pode ter mais que 255 caracteres.',
        'nome_responsavel.min' => 'O campo nome do responsável deve ter pelo menos 3 caracteres.',
        'telefone.required' => 'O campo telefone é obrigatório.',
        'telefone.string' => 'O campo telefone deve ser um texto.',
        'telefone.max' => 'O campo telefone não pode ter mais que 255 caracteres.',
        'email.required' => 'O campo e-mail é obrigatório.',
        'email.string' => 'O campo e-mail deve ser um texto.',
        'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
        'email.max' => 'O campo e-mail não pode ter mais que 255 caracteres.',
        'logradouro.required' => 'O campo logradouro é obrigatório.',
        'logradouro.string' => 'O campo logradouro deve ser um texto.',
        'logradouro.max' => 'O campo logradouro não pode ter mais que 255 caracteres.',
        'numero.required' => 'O campo número é obrigatório.',
        'numero.string' => 'O campo número deve ser um texto.',
        'numero.max' => 'O campo número não pode ter mais que 255 caracteres.',
        'complemento.string' => 'O campo complemento deve ser um texto.',
        'complemento.max' => 'O campo complemento não pode ter mais que 255 caracteres.',
        'bairro.required' => 'O campo bairro é obrigatório.',
        'bairro.string' => 'O campo bairro deve ser um texto.',
        'bairro.max' => 'O campo bairro não pode ter mais que 255 caracteres.',
        'cep.required' => 'O campo CEP é obrigatório.',
        'cep.string' => 'O campo CEP deve ser um texto.',
        'cep.max' => 'O campo CEP não pode ter mais que 255 caracteres.',
        'status.required' => 'O campo status é obrigatório.',
        'status.boolean' => 'O campo status deve ser verdadeiro ou falso.',
        'observacao.string' => 'O campo observação deve ser um texto.',
    ];
    }
}
