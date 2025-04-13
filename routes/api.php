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

use App\Http\Controllers\AuthClienteController;

// Route::apiResource('empresas', EmpresaController::class);

Route::apiResource('profissionais', ProfissionalController::class)
    ->parameters(['profissionais' => 'profissional']);

// Route::post('/clientes', [ClienteController::class, 'store']);
// Route::post('/servicos', [ServicoController::class, 'store']);
// Route::get('/servicos/{id}', [ServicoController::class, 'show']);
// Route::apiResource('servicos', ServicoController::class);

// Route::apiResource('servicos', ServicoController::class);
// Route::apiResource('categorias', CategoriaController::class);

// Route::post('/agendamentos', [AgendamentoController::class, 'store']);


Route::prefix('cliente')->group(function () {

    Route::post('/register', [AuthClienteController::class, 'register']);
    Route::post('/login', [AuthClienteController::class, 'login']);
    Route::post('/refresh', [AuthClienteController::class, 'refresh']); //Nova rota para renovar token

    Route::middleware(['auth:cliente'])->group(function () {
        Route::get('/me', [AuthClienteController::class, 'me']);
        Route::post('/logout', [AuthClienteController::class, 'logout']);


        // Exemplo de rota protegida
        Route::get('/dashboard', function () {
            return response()->json(['message' => 'Você está autenticado como cliente!']);
        });

        Route::apiResource('servicos', ServicoController::class);
        Route::apiResource('categorias', CategoriaController::class);
        Route::apiResource('empresas', EmpresaController::class);
        
    });

});


Route::get('/teste', function () {
    return response()->json([
        'mensagem' => 'API funcionando!',
        'status' => true
    ]);
});