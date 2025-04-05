<?php

namespace App\Http\Controllers;

use App\Models\Paises;
use Illuminate\Http\Request;

class PaisesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
        
        try {
            $request->validate([
                'pais' => 'required|string|unique:paises,pais',
                'sigla' => 'required|string|max:3',
                'ddi' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'mensagem' => 'Erro de validação.',
                'status' => false,
                'erros' => $e->errors()
            ], 422);
        }

        $paises = new Paises();
        $paises->fill($request->only(['pais', 'sigla', 'ddi']));
        $paises->save();

        if ($paises->wasRecentlyCreated) {
            return response()->json([
            'mensagem' => 'País cadastrado com sucesso!',
            'status' => true,
            'paises' => $paises
            ]);
        } else {
            return response()->json([
            'mensagem' => 'Erro ao cadastrar o país.',
            'status' => false
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Paises $paises)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paises $paises)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paises $paises)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paises $paises)
    {
        //
    }

    public function listarPaises()
    {
        $paises = Paises::all(); // Busca todos os registros da tabela 'paises'
        return response()->json($paises);
    }
}
