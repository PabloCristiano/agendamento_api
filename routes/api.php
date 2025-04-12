<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\PaisesController;
use App\Http\Controllers\CategoriaController;

Route::apiResource('empresas', EmpresaController::class);
Route::apiResource('cargos', CargoController::class);

// Route::post('/clientes', [ClienteController::class, 'store']);
// Route::post('/profissionais', [ProfissionalController::class, 'store']);
// Route::post('/servicos', [ServicoController::class, 'store']);
// Route::get('/servicos/{id}', [ServicoController::class, 'show']);
// Route::apiResource('servicos', ServicoController::class);

Route::resource('servicos', ServicoController::class);
Route::resource('categorias', CategoriaController::class);

// Route::post('/agendamentos', [AgendamentoController::class, 'store']);
// Route::post('/paises', [PaisesController::class, 'store']);
// Route::get('/paises', [PaisesController::class, 'listarPaises']);




Route::get('/teste', function () {
    return response()->json([
        'mensagem' => 'API funcionando!',
        'status' => true
    ]);
});