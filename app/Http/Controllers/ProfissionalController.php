<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use App\Http\Requests\StoreProfissionalRequest;
use Illuminate\Http\Request;

class ProfissionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profissionais = Profissional::all();
        
        return response()->json([
            'data' => $profissionais,
            'message' => 'Profissionais listados com sucesso',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfissionalRequest $request)
    {   
        $profissional = Profissional::create($request->all());

        return response()->json([
            'data' => $profissional,
            'message' => 'Profissional cadastrado com sucesso'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $profissional = Profissional::find($id);

        if (!$profissional) {
            return response()->json(['message' => 'Profissional não encontrado']);
        }

        return response()->json([
            'data' => $profissional,
            'message' => 'Profissional encontrado com sucesso',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProfissionalRequest $request, $id)
    {
        $profissional = Profissional::find($id);

        if (!$profissional) {
            return response()->json(['message' => 'Profissional não encontrado']);
        }

        $profissional->update($request->all());
        return response()->json([
            'data' => $profissional,
            'message' => 'Profissional editado com sucesso',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $profissional = Profissional::find($id);

        if (!$profissional) {
            return response()->json(['message' => 'Profissional não encontrado']);
        }
        
        $profissional->status = 0;
        $profissional->update();

        return response()->json([
            'data' => $profissional,
            'message' => 'Profissional deletado com sucesso',
        ]);
    }
}
