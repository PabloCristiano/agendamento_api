<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutcomVendasController;
use App\Http\Controllers\VoucherController;

Route::get('/', function () {
    return view('foztintas');
});

Route::get('/login', function () {
    return view('layouts.login');
});

Route::get('/register', function () {
    return view('layouts.register');
});

Route::get('/app', function () {
    return view('foztintas.index');
});

Route::resource('autcom-vendas', AutcomVendasController::class);
Route::get('/autcom-vendas/create', [AutcomVendasController::class, 'create'])->name('autcom-vendas.create');
Route::post('/autcom-vendas', [AutcomVendasController::class, 'store'])->name('autcom-vendas.store');
Route::get('/cadastro-voucher', [AutcomVendasController::class, 'index'])->name('cadastro-voucher.index');
Route::get('/reimprimir', [AutcomVendasController::class, 'reimprimir'])->name('cadastro-voucher.reimprimir');
Route::get('/cadastro-voucher/{id}', [AutcomVendasController::class, 'show'])->name('cadastro-voucher.show');
Route::get('/cadastro-voucher/{id}/edit', [AutcomVendasController::class, 'edit'])->name('cadastro-voucher.edit');
Route::put('/cadastro-voucher/{id}', [AutcomVendasController::class, 'update'])->name('cadastro-voucher.update');
Route::delete('/cadastro-voucher/{id}', [AutcomVendasController::class, 'destroy'])->name('cadastro-voucher.destroy');



//voucher
Route::post('/gerar-voucher', [VoucherController::class, 'store'])->name('gerar-voucher.store');
Route::post('/reimprimir-voucher', [VoucherController::class, 'reimprimir'])->name('reimprimir-voucher.store');