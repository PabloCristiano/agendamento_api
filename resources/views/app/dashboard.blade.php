@extends('app.index')

@section('title', 'Dashboard')

@section('content')
@php
    $totalVouchers = app(\App\Http\Controllers\VoucherController::class)->totalVouchers();
    $total007       = app(\App\Http\Controllers\VoucherController::class)->totalLoja007();
    $total011       = app(\App\Http\Controllers\VoucherController::class)->totalLoja011();
@endphp

<div class="container">
    <section class="dashboard-section">
        <div class="stats-card">
            <div class="stats-icon" aria-hidden="true">🎫</div>
            <h2 class="stats-title">Total de Vouchers Gerados</h2>

            <div class="stats-number" id="totalVouchers">{{ $totalVouchers ?? 0 }}</div>
            <p class="stats-description">Vouchers criados desde o início da promoção</p>

            <div class="stat-grid">
                <div class="stat-tile">
                    <div class="stat-tile-label">LOJA 007</div>
                    <div class="stat-tile-value">{{ $total007 ?? 0 }}</div>
                </div>

                <div class="stat-tile">
                    <div class="stat-tile-label">LOJA 011</div>
                    <div class="stat-tile-value">{{ $total011 ?? 0 }}</div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
