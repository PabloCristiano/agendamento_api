<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\ClienteController;
// use App\Http\Controllers\AgendamentoController;

Route::apiResource('empresas', EmpresaController::class);

Route::apiResource('profissionais', ProfissionalController::class)
    ->parameters(['profissionais' => 'profissional']);

Route::apiResource('categorias', CategoriaController::class);

Route::apiResource('servicos', ServicoController::class);

Route::apiResource('clientes', ClienteController::class);

// Route::post('/agendamentos', [AgendamentoController::class, 'store']);

Route::get('/teste', function () {
    return response()->json([
        'mensagem' => 'API funcionando!',
        'status' => true
    ]);
});