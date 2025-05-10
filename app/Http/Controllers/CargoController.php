<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCargoRequest;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cargos = Cargo::All();

        return response()->json([
            'data' => $cargos,
            'message' => 'Cargos listados com sucesso',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCargoRequest $request)
    {
        $cargo = Cargo::create($request->all());

        return response()->json([
            'data' => $cargo,
            'message' => 'Cargo cadastrado com sucesso'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cargo = Cargo::find($id);

        if (!$cargo) {
            return response()->json(['message' => 'Cargo não encontrado']);
        }

        return response()->json([
            'data' => $cargo,
            'message' => 'Cargo encontrado com sucesso',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCargoRequest $request, string $id)
    {
        $cargo = Cargo::find($id);

        if (!$cargo) {
            return response()->json(['message' => 'Cargo não encontrado']);
        }

        $cargo->update($request->all());

        return response()->json([
            'data' => $cargo,
            'message' => 'Cargo editado com sucesso',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cargo = Cargo::find($id);

        if (!$cargo) {
            return response()->json(['message' => 'Cargo não encontrado']);
        }

        $cargo->status = 0;
        $cargo->update();

        return response()->json([
            'data' => $cargo,
            'message' => 'Cargo deletado com sucesso',
        ]);
    }
}
