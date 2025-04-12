<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmpresaRequest;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = Empresa::with(['usuarios', 'cargos', 'categorias', 'agendamentos'])->get();
        return response()->json([
            'data' => $empresas,
            'message' => 'Empresas listadas com sucesso.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmpresaRequest $request)
    {
        $newEmpresa = Empresa::create($request->all());

        return response()->json([
            'data' => $newEmpresa,
            'message' => 'Empresa cadastrada com sucesso'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa não encontrada']);
        }

        return response()->json([
            'data' => $empresa,
            'message' => 'Empresa encontrada com sucesso'   
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEmpresaRequest $request, int $id)
    {
        $empresa = Empresa::find($id);
        
        if (!$empresa) {
            return response()->json(['message' => 'Empresa não encontrada']);
        }

        $empresa->update($request->all());

        return response()->json([
            'mensagem' => 'Serviço atualizado com sucesso!',
            'data' => $empresa
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa não encontrada']);
        }

        $empresa->status = 0;
        $empresa->update();
        
        return response()->json(['message' => 'Empresa deletada com sucesso']);
    }
}