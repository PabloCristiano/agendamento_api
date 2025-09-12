<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\PaisesController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CEPController;
use App\Http\Controllers\AutcomVendasController;

Route::apiResource('empresas', EmpresaController::class);

Route::apiResource('profissionais', ProfissionalController::class)
    ->parameters(['profissionais' => 'profissional']);

// Route::post('/clientes', [ClienteController::class, 'store']);

Route::apiResource('servicos', ServicoController::class);

Route::apiResource('categorias', CategoriaController::class);

// Route::post('/agendamentos', [AgendamentoController::class, 'store']);

Route::get('/cep/buscar/{cep}', [CEPController::class, 'findCEP']);

Route::apiResource('autcom-vendas', AutcomVendasController::class);

Route::get('/teste', function () {
    return response()->json([
        'mensagem' => 'API funcionando!',
        'status' => true
    ]);
});