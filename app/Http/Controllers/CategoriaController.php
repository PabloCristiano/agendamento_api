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
            'mensagem' => 'Categorias listadas com sucesso.'
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
        $categoria = new Categoria();

        $categoria->categoria = $request->input('categoria');

        $rules = [
            'categoria' => ['required', 'string', 'max:255', Rule::unique('categorias', 'categoria')],
        ];

        $messages = [
            'categoria.required' => 'O campo categoria é obrigatório.',
            'categoria.string' => 'O campo categoria deve ser uma string.',
            'categoria.max' => 'O campo categoria não pode ter mais que 255 caracteres.',
            'categoria.unique' => 'O campo categoria já está em uso.',
        ];

        // Validação dos dados
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'mensagem' => 'Erro ao cadastrar categoria.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $categoria->save();

        return response()->json([
            'data' => $categoria,
            'mensagem' => 'Categoria cadastrada com sucesso.'
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
                'mensagem' => 'Categoria não encontrada.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $categoria,
            'mensagem' => 'Categoria encontrada com sucesso.'
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return response()->json([
            'data' => $categoria,
            'mensagem' => 'Dados para edição carregados com sucesso.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $rules = [
            'categoria' => ['required', 'string', 'max:255', Rule::unique('categorias', 'categoria')->ignore($categoria->id)],
        ];

        // Validação dos dados
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'mensagem' => 'Erro ao atualizar categoria.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $categoria->update($request->all());

        return response()->json([
            'data' => $categoria,
            'mensagem' => 'Categoria atualizada com sucesso.'
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
                'mensagem' => 'Categoria não encontrada.'
            ], Response::HTTP_NOT_FOUND);
        }

        $categoria->delete();

        return response()->json([
            'mensagem' => 'Categoria excluída com sucesso.'
        ]);
    }
}
