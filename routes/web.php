<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutcomVendasController;

Route::get('/', function () {
    return view('foztintas');
});

Route::resource('autcom-vendas', AutcomVendasController::class);
Route::get('/autcom-vendas/create', [AutcomVendasController::class, 'create'])->name('autcom-vendas.create');
Route::post('/autcom-vendas', [AutcomVendasController::class, 'store'])->name('autcom-vendas.store');
Route::get('/cadastro-voucher', [AutcomVendasController::class, 'index'])->name('cadastro-voucher.index');
Route::get('/cadastro-voucher/{id}', [AutcomVendasController::class, 'show'])->name('cadastro-voucher.show');
Route::get('/cadastro-voucher/{id}/edit', [AutcomVendasController::class, 'edit'])->name('cadastro-voucher.edit');
Route::put('/cadastro-voucher/{id}', [AutcomVendasController::class, 'update'])->name('cadastro-voucher.update');
Route::delete('/cadastro-voucher/{id}', [AutcomVendasController::class, 'destroy'])->name('cadastro-voucher.destroy');