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
use App\Http\Requests\StoreServicoRequest;

class ServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servico = Servico::with('categoria')->get();
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
    public function store(StoreServicoRequest $request)
    {
        // Validação dos dados
        try {

            $newServico = Servico::create($request->all());

        } catch (ValidationException $e) {

            Log::error('Erro ao cadastrar o serviço: ' . $e->getMessage());
            return response()->json([
                'mensagem' => 'Erro ao cadastrar o serviço.',
                'status' => false
            ], 500);
        
        }
        
        // Retorna a resposta de sucesso
        return response()->json([
            'status' => true,
            'data' => $newServico,
            'mensagem' => 'Serviço cadastrado com sucesso!',
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

        return response()->json([
            'data' => $servico,
            'message' => 'Empresa encontrada com sucesso'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servico $servico)
    {
        return response()->json([
            'data' => $servico,
            'message' => 'Dados para edição carregados com sucesso.'
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreServicoRequest $request, int $id)
    {
        
        $servico = Servico::find($id);
        
        if (!$servico) {
            return response()->json(['mensagem' => 'Serviço não encontrado'], 404);
        }
        
        // Atualiza os dados do serviço
        $servico->update($request->all());

        return response()->json([
            'message' => 'Serviço atualizado com sucesso!',
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
