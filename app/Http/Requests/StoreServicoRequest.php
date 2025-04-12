<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServicoRequest extends FormRequest
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
            'servico' => ['required', 'string', 'max:255', Rule::unique('servicos', 'servico')->ignore($this->route('servico'))],
            'tempo' => 'required|integer|min:1',
            'valor' => 'required|numeric|min:0',
            'comissao' => 'required|numeric|min:0|max:100',
            'categoria_id' => 'required|integer|exists:categorias,id',
        ];
    }

    public function messages(): array
    {
        return [
            'servico.required' => 'O serviço é obrigatório.',
            'servico.string' => 'O serviço deve ser uma string.',
            'servico.max' => 'O serviço deve ter no máximo 255 caracteres.',
            'servico.unique' => 'O serviço informado já está cadastrado.',
            'tempo.required' => 'O tempo é obrigatório.',
            'tempo.integer' => 'O tempo deve ser um número inteiro.',
            'tempo.min' => 'O tempo deve ser maior que 0.',
            'valor.required' => 'O valor é obrigatório.',
            'valor.numeric' => 'O valor deve ser um número.',
            'valor.min' => 'O valor deve ser maior ou igual a 0.',
            'comissao.required' => 'A comissão é obrigatória.',
            'comissao.numeric' => 'A comissão deve ser um número.',
            'comissao.min' => 'A comissão deve ser maior ou igual a 0.',
            'comissao.max' => 'A comissão deve ser menor ou igual a 100.',
            'categoria_id.required' => 'O campo categoria é obrigatório.',
            'categoria_id.integer' => 'O campo categoria deve ser um número inteiro.',
            'categoria_id.exists' => 'A categoria informada não existe.',
        ];
    }
}
