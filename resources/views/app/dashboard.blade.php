@extends('app.index')
@section('content')
@section('title', 'Dashboard')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: #372FA4;
        background-size: 400% 400%;
        animation: gradientFlow 15s ease infinite;
        min-height: 100vh;
        overflow-x: hidden;
    }

    @keyframes gradientFlow {
        0% {
            background-position: 0% 50%
        }

        50% {
            background-position: 100% 50%
        }

        100% {
            background-position: 0% 50%
        }
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    header {
        background: rgba(255, 255, 255, .95);
        backdrop-filter: blur(10px);
        padding: 15px 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .1);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        font-size: 2.5rem;
        font-weight: 800;
        background: #372FA4;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .nav-buttons {
        display: flex;
        gap: 15px;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: .3s ease;
        text-decoration: none;
        display: inline-block;
        font-size: 1rem;
    }

    .btn-primary {
        background: linear-gradient(45deg, #10b981, #3b82f6);
        color: #fff;
    }

    .btn-secondary {
        background: linear-gradient(45deg, #f59e0b, #ef4444);
        color: #fff;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, .2);
    }

    .btn:disabled {
        opacity: .6;
        cursor: not-allowed;
        transform: none;
    }

    .hero {
        text-align: center;
        padding: 60px 0 40px;
        color: #fff;
    }

    .hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, .3);
    }

    .hero p {
        font-size: 1.3rem;
        margin-bottom: 40px;
        opacity: .9;
    }

    .picanha-icon {
        font-size: 4rem;
        margin: 20px 0;
        animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0)
        }

        40% {
            transform: translateY(-10px)
        }

        60% {
            transform: translateY(-5px)
        }
    }

    .voucher-form-section {
        background: rgba(255, 255, 255, .95);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 50px;
        margin: 40px 0;
        box-shadow: 0 15px 40px rgba(0, 0, 0, .1);
        position: relative;
        overflow: hidden;
    }

    .voucher-form-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #6b46c1, #3b82f6, #10b981, #f59e0b, #ef4444);
    }

    .form-title {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(45deg, #6b46c1, #ef4444);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 40px;
        text-align: center;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .form-input {
        width: 100%;
        padding: 18px 25px;
        border: 3px solid #e5e7eb;
        border-radius: 15px;
        font-size: 1.2rem;
        font-weight: 500;
        transition: .3s ease;
        background: #fff;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 5px rgba(59, 130, 246, .1);
        transform: translateY(-2px);
    }

    .form-input.error {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .form-input.success {
        border-color: #10b981;
        background: #f0fdf4;
    }

    .error-message {
        color: #ef4444;
        font-size: .9rem;
        margin-top: 8px;
        font-weight: 500;
        min-height: 1.2em;
    }

    .loading-spinner {
        display: none;
        width: 24px;
        height: 24px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 12px auto 0;
    }

    @keyframes spin {
        0% {
            transform: rotate(0)
        }

        100% {
            transform: rotate(360deg)
        }
    }

    .voucher-result {
        display: none;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        padding: 40px;
        border-radius: 20px;
        text-align: center;
        margin-top: 30px;
        animation: slideIn .5s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    .voucher-number {
        font-size: 3rem;
        font-weight: 800;
        margin: 20px 0;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, .3);
        letter-spacing: 3px;
    }

    .voucher-details {
        background: rgba(255, 255, 255, .1);
        padding: 25px;
        border-radius: 15px;
        margin: 25px 0;
    }

    .voucher-details h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    .voucher-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        text-align: left;
    }

    .voucher-info-item {
        background: rgba(255, 255, 255, .1);
        padding: 15px;
        border-radius: 10px;
    }

    .voucher-info-label {
        font-size: .9rem;
        opacity: .8;
        margin-bottom: 5px;
    }

    .voucher-info-value {
        font-weight: 700;
        font-size: 1.1rem;
    }

    /* Estilos para o card de total de vouchers */
    .stats-card {
        background: rgba(255, 255, 255, .95);
        backdrop-filter: blur(15px);
        border-radius: 25px;
        padding: 40px;
        margin: 40px 0;
        box-shadow: 0 15px 50px rgba(0, 0, 0, .15);
        position: relative;
        overflow: hidden;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 60px rgba(0, 0, 0, .2);
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #6b46c1, #10b981, #3b82f6, #f59e0b);
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% {
            background-position: -200% center;
        }
        50% {
            background-position: 200% center;
        }
    }

    .stats-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        background: linear-gradient(45deg, #6b46c1, #10b981);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .stats-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 15px;
    }

    .stats-number {
        font-size: 4rem;
        font-weight: 800;
        background: linear-gradient(45deg, #10b981, #3b82f6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 20px 0;
        text-shadow: 0 4px 8px rgba(0, 0, 0, .1);
        line-height: 1;
    }

    .stats-description {
        font-size: 1.1rem;
        color: #6b7280;
        margin-bottom: 25px;
    }

    .stats-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .stat-detail-item {
        background: rgba(99, 102, 241, .1);
        padding: 20px;
        border-radius: 15px;
        border: 2px solid rgba(99, 102, 241, .2);
        transition: all 0.3s ease;
    }

    .stat-detail-item:hover {
        background: rgba(99, 102, 241, .15);
        border-color: rgba(99, 102, 241, .3);
        transform: translateY(-2px);
    }

    .stat-detail-label {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .stat-detail-value {
        font-size: 1.3rem;
        font-weight: 700;
        background: linear-gradient(45deg, #6b46c1, #3b82f6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .floating-elements {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
    }

    .floating-element {
        position: absolute;
        animation: float 6s ease-in-out infinite;
        opacity: .1;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0) rotate(0)
        }

        50% {
            transform: translateY(-20px) rotate(180deg)
        }
    }

    .alert {
        padding: 20px;
        border-radius: 15px;
        margin: 20px 0;
        font-weight: 500;
    }

    .alert-warning {
        background: #fffbeb;
        color: #92400e;
        border: 2px solid #f59e0b;
    }

    @media (max-width:768px) {
        .hero h1 {
            font-size: 2.5rem
        }

        .hero p {
            font-size: 1.1rem
        }

        .voucher-form-section, .stats-card {
            padding: 30px 25px
        }

        .form-title {
            font-size: 2rem
        }

        .voucher-number, .stats-number {
            font-size: 2.5rem
        }

        .logo {
            font-size: 2rem
        }

        .nav-buttons {
            flex-direction: column;
            gap: 10px
        }

        .voucher-info, .stats-details {
            grid-template-columns: 1fr
        }

        .stats-icon {
            font-size: 3rem
        }
    }
</style>

<div class="container">
    <!-- Card de Estatísticas de Vouchers -->
    <section class="row my-4">
        <div class="stats-card">
            <div class="stats-icon">🎫</div>
            <h2 class="stats-title">Total de Vouchers Gerados</h2>
            @php
                // Chama o método totalVouchers do VoucherController
                $totalVouchers = app(\App\Http\Controllers\VoucherController::class)->totalVouchers();
                $total007 = app(\App\Http\Controllers\VoucherController::class)->totalLoja007();
                $total011 = app(\App\Http\Controllers\VoucherController::class)->totalLoja011();
            @endphp
            <div class="stats-number" id="totalVouchers">{{ $totalVouchers ?? 0 }}</div>
            <p class="stats-description">Vouchers criados desde o início da promoção</p>
            
            <div class="stats-details">
                <div class="stat-detail-item">
                    <div class="stat-detail-label">LOJA 007</div>
                    <div class="stat-detail-value" id="vouchersToday">{{ $total007 ?? 0 }}</div>
                </div>
                <div class="stat-detail-item">
                    <div class="stat-detail-label">LOJA 011</div>
                    <div class="stat-detail-value" id="vouchersWeek">{{ $total011 ?? 0 }}</div>
                </div>
            </div>
            
            {{-- <a href="{{ route('vouchers.index') ?? '#' }}" class="btn btn-primary" style="margin-top: 30px; font-size: 1.1rem;">
                📊 Ver Detalhes
            </a> --}}
        </div>
    </section>
</div>

<script>

</script>
    
@endsection