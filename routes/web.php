<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutcomVendasController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('foztintas');
});

// Route::get('/login', function () {
//     return view('layouts.login');
// });

// Route::get('/register', function () {
//     return view('layouts.register');
// });

// Route::get('/app', function () {
//     return view('foztintas.index');
// });

// Login e Registro
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');




Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {return view('app.dashboard');})->name('dashboard');
    
    // Adicione aqui outras rotas protegidas   
    Route::get('/cadastro-voucher', [AutcomVendasController::class, 'index'])->name('cadastro-voucher.index');
    Route::get('/reimprimir', [AutcomVendasController::class, 'reimprimir'])->name('cadastro-voucher.reimprimir');    

    //voucher
    Route::post('/gerar-voucher', [VoucherController::class, 'store'])->name('gerar-voucher.store');
    Route::post('/reimprimir-voucher', [VoucherController::class, 'reimprimir'])->name('reimprimir-voucher.store');

});