<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
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
use App\Http\Requests\StoreCategoriaRequest;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return response()->json([
            'data' => $categorias,
            'message' => 'Categorias listadas com sucesso.'
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
    public function store(StoreCategoriaRequest $request)
    {
        

        try {

            $newCategoria = Categoria::create($request->all());

        } catch (ValidationException $e) {

            Log::error('Erro ao cadastrar o serviço: ' . $e->getMessage());
            return response()->json([
                'mensagem' => 'Erro ao cadastrar o serviço.',
                'status' => false
            ], 500);
        
        }


        return response()->json([
            'data' => $newCategoria,
            'message' => 'Categoria cadastrada com sucesso.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'message' => 'Categoria não encontrada.'
            ], 404);
        }

        return response()->json([
            'data' => $categoria,
            'message' => 'Categoria encontrada com sucesso.'
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return response()->json([
            'data' => $categoria,
            'message' => 'Dados para edição carregados com sucesso.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoriaRequest $request, int $id)
    {
        $categoria = Categoria::find($id);
        
        if (!$categoria) {
            return response()->json([
                'message' => 'Categoria não encontrada.'
            ], 404);
        }

        $categoria->update($request->all());

        return response()->json([
            'data' => $categoria,
            'message' => 'Categoria atualizada com sucesso.'
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'message' => 'Categoria não encontrada.'
            ], 404);
        }

        $categoria->delete();

        return response()->json([
            'message' => 'Categoria excluída com sucesso.'
        ]);
    }
}
