<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\PaisesController;



Route::post('/clientes', [ClienteController::class, 'store']);
Route::post('/profissionais', [ProfissionalController::class, 'store']);
Route::post('/servicos', [ServicoController::class, 'store']);
Route::post('/agendamentos', [AgendamentoController::class, 'store']);
Route::post('/paises', [PaisesController::class, 'store']);
Route::get('/paises', [PaisesController::class, 'listarPaises']);




Route::get('/teste', function () {
    return response()->json([
        'mensagem' => 'API funcionando!',
        'status' => true
    ]);
});