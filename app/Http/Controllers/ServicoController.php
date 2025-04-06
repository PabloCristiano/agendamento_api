<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servico = Servico::all();
        return response()->json([
            'data' => $servico,
            'message' => 'Serviços listados com sucesso.'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        
        $servico = new Servico();
       
        $servico->servico = $request->input('servico');
        $servico->tempo = $request->input('tempo');
        $servico->valor = $request->input('valor');
        $servico->comissao = $request->input('comissao');
        $servico->id_categoria = $request->input('id_categoria');

        $rules = [
            'servico' => ['required', 'string', 'max:255', Rule::unique('servicos', 'servico')],
            'tempo' => 'required|integer|min:1',
            'valor' => 'required|numeric|min:0',
            'comissao' => 'required|numeric|min:0|max:100',
            'id_categoria' => 'required|integer|exists:categorias,id'
        ];

        $messages = [
            'servico.required' => 'O campo serviço é obrigatório.',
            'servico.string' => 'O campo serviço deve ser uma string.',
            'servico.max' => 'O campo serviço deve ter no máximo 255 caracteres.',
            'servico.unique' => 'O serviço informado já está cadastrado.',
            'tempo.required' => 'O campo tempo é obrigatório.',
            'tempo.integer' => 'O campo tempo deve ser um número inteiro.',
            'tempo.min' => 'O campo tempo deve ser no mínimo 1.',
            'valor.required' => 'O campo valor é obrigatório.',
            'valor.numeric' => 'O campo valor deve ser um número.',
            'valor.min' => 'O campo valor deve ser no mínimo 0.',
            'comissao.required' => 'O campo comissão é obrigatório.',
            'comissao.numeric' => 'O campo comissão deve ser um número.',
            'comissao.min' => 'O campo comissão deve ser no mínimo 0.',
            'comissao.max' => 'O campo comissão deve ser no máximo 100.',
            'id_categoria.required' => 'O campo categoria é obrigatório.',
            'id_categoria.integer' => 'O campo categoria deve ser um número inteiro.',
            'id_categoria.exists' => 'A categoria informada não existe.',
        ];

        // Validação dos dados
        $validator = Validator::make($request->all(), $rules, $messages);

        // Verifica se a validação falhou
        if ($validator->fails()) {
            return response()->json([
            'mensagem' => 'Erro de validação.',
            'erros' => $validator->errors(),
            'status' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $servico->save();

        return response()->json([
            'mensagem' => 'Serviço cadastrado com sucesso!',
            'status' => true
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {    
        $servico = Servico::find($id);

        if (!$servico) {
            return response()->json(['message' => 'Serviço não encontrado'], 404);
        }

        return response()->json($servico);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servico $servico)
    {
        return response()->json([
            'data' => $servico,
            'mensagem' => 'Dados para edição carregados com sucesso.'
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        

        // Validação dos dados
        $validated = $request->validate([
            'servico' => 'required|string|max:255',
            'tempo' => 'required|integer|min:1',
            'valor' => 'required|numeric',
            'comissao' => 'required|numeric',
            'id_categoria' => 'required|integer|exists:categorias,id'
        ]);

        $servico = Servico::find($request->id);
        
        if (!$servico) {
            return response()->json(['mensagem' => 'Serviço não encontrado'], 404);
        }
        
        // Atualiza os dados do serviço
        $servico->update($validated);

        return response()->json([
            'mensagem' => 'Serviço atualizado com sucesso!',
            'data' => $servico
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $servico = Servico::find($id);

        if (!$servico) {
            return response()->json(['mensagem' => 'Serviço não encontrado'], 404);
        }

        $servico->delete();
        return response()->json([
            'mensagem' => 'Serviço deletado com sucesso.'
        ]);
    }
}
