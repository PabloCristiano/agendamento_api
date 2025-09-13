@extends('app.index')

@section('title', 'Dashboard')

@section('content')

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
                    <div class="stat-tile-value">{{ $loja007Vouchers ?? 0 }}</div>
                </div>

                <div class="stat-tile">
                    <div class="stat-tile-label">LOJA 011</div>
                    <div class="stat-tile-value">{{ $loja011Vouchers ?? 0 }}</div>
                </div>
            </div>
        </div>
    </section>
    <section class="dashboard-section">
        <div class="stats-card">
            <div class="stats-icon" aria-hidden="true">🎫</div>
            <h2 class="stats-title">Lista de Vouchers Gerados</h2>
            <!-- Formulário de busca por CPF/CNPJ -->
            {{-- <form method="GET" action="" class="mb-3" style="margin-bottom: 16px;">
            <div style="display: flex; gap: 8px; align-items: center;">
                <input
                type="text"
                name="cpf_cnpj"
                value="{{ request('cpf_cnpj') }}"
                placeholder="Buscar por CPF ou CNPJ"
                class="form-control"
                style="max-width: 220px;"
                autocomplete="off"
                >
                <button type="submit" class="btn btn-primary">Buscar</button>
                @if(request('cpf_cnpj'))
                <a href="" class="btn btn-secondary" style="margin-left: 4px;">Limpar</a>
                @endif
            </div>
            </form> --}}
            <!-- Exibir a contagem de vouchers -->
            <div class="voucher-list">
            <table class="table">
            <thead>
            <tr>
                <th>Número Nota</th>
                <th>Nome Completo</th>
                <th>CPF/CNPJ</th>
                <th>Loja</th>
                <th>Código do Voucher</th>
                <th>Gerado em</th>
            </tr>
            </thead>
            <tbody>
            @forelse($vouchers as $voucher)
                <tr>
                <td>{{ $voucher['numero_nota'] ?? '-' }}</td>
                <td>{{ $voucher['nome_completo'] ?? '-' }}</td>
                <td>{{ $voucher['cpf_cnpj'] ?? '-' }}</td>
                <td>{{ $voucher['loja'] ?? '-' }}</td>
                <td>{{ $voucher['voucher_code'] ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($voucher['gerado_em'])->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                <td colspan="6">Nenhum voucher encontrado.</td>
                </tr>
            @endforelse
            </tbody>
            </table>
            @if ($vouchers->hasPages())
            <div class="pagination">
                <nav>
                <ul class="flex pagination-list" style="list-style: none; padding: 0; margin: 0;">
                    {{-- Página anterior --}}
                    @if ($vouchers->onFirstPage())
                    <li><span style="color: #aaa;">Anterior</span></li>
                    @else
                    <li>
                        <a href="{{ $vouchers->appends(request()->except('page'))->previousPageUrl() }}" rel="prev" class="pagination-link">Anterior</a>
                    </li>
                    @endif

                    {{-- Números das páginas --}}
                    @foreach ($vouchers->getUrlRange(1, $vouchers->lastPage()) as $page => $url)
                    @php
                        $url = $vouchers->appends(request()->except('page'))->url($page);
                    @endphp
                    @if ($page == $vouchers->currentPage())
                        <li><span aria-current="page">{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}" class="pagination-link">{{ $page }}</a></li>
                    @endif
                    @endforeach

                    {{-- Próxima página --}}
                    @if ($vouchers->hasMorePages())
                    <li>
                        <a href="{{ $vouchers->appends(request()->except('page'))->nextPageUrl() }}" rel="next" class="pagination-link">Próxima</a>
                    </li>
                    @else
                    <li><span style="color: #aaa;">Próxima</span></li>
                    @endif
                </ul>
                </nav>
                <div id="pagination-spinner" style="display:none; margin-top:10px; text-align:center;">
                <span class="spinner" aria-label="Carregando"></span>
                </div>
            </div>
            <script>
                document.querySelectorAll('.pagination-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    document.getElementById('pagination-spinner').style.display = 'block';
                    sessionStorage.setItem('dashboardScroll', window.scrollY);
                });
                });
                window.addEventListener('DOMContentLoaded', function() {
                const scroll = sessionStorage.getItem('dashboardScroll');
                if (scroll !== null) {
                    window.scrollTo(0, parseInt(scroll));
                    sessionStorage.removeItem('dashboardScroll');
                }
                });
            </script>
            <style>
                .spinner {
                display: inline-block;
                width: 28px;
                height: 28px;
                border: 3px solid #e0e0ff;
                border-top: 3px solid #2d2d8c;
                border-radius: 50%;
                animation: spin 0.8s linear infinite;
                vertical-align: middle;
                }
                @keyframes spin {
                0% { transform: rotate(0deg);}
                100% { transform: rotate(360deg);}
                }
            </style>
            @endif
            <style>
            .pagination {
                margin-top: 16px;
                width: 100%;
                display: flex;
                justify-content: center;
            }
            .pagination nav {
                width: 100%;
                display: flex;
                justify-content: center;
            }
            .pagination-list {
                display: flex !important;
                flex-direction: row !important;
                justify-content: center !important;
                align-items: center !important;
                gap: 6px;
                width: 100%;
            }
            .pagination .flex span,
            .pagination .flex a {
                font-size: 1rem !important;
                padding: 4px 10px !important;
                border-radius: 4px;
                transition: background 0.2s, color 0.2s;
            }
            .pagination .flex a {
                color: #2d2d8c;
                text-decoration: none;
            }
            .pagination .flex a:hover {
                background: #e0e0ff;
            }
            .pagination .flex span[aria-current] {
                background: #2d2d8c;
                color: #fff !important;
                font-weight: bold;
            }
            .pagination svg {
                height: 20px !important;
                width: 20px !important;
                vertical-align: middle;
            }
            </style>
        </div>
    </section>
</div>
@endsection
