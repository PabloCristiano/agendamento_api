<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();

        return response()->json([
            'data' => $clientes,
            'message' => 'Clientes listados com sucesso',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
    {
        $cliente = Cliente::create($request->all());

        return response()->json([
            'data' => $cliente,
            'message' => 'Cliente cadastrado com sucesso',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado']);
        }

        return response()->json([
            'data' => $cliente,
            'message' => 'Cliente encontrado com sucesso',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClienteRequest $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado']);
        }

        $cliente->update($request->all());

        return response()->json([
            'data' => $cliente,
            'message' => 'Cliente encontrado com sucesso',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        throw new \BadMethodCallException('Função destroy não implementada.');
    }
}
