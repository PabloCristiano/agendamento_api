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
            {{-- 
            <form method="GET" action="" class="mb-3" style="margin-bottom: 16px;">
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
            </form> 
            --}}
            <!-- Exibir a contagem de vouchers -->
            <div class="voucher-list table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Número Nota</th>
                            <th>Nome Completo</th>
                            <th>CPF/CNPJ</th>
                            <th>Loja</th>
                            <th>Código do Voucher</th>
                            <th>Gerado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vouchers as $voucher)
                            <tr>
                                <td data-label="Número Nota">{{ $voucher['numero_nota'] ?? '-' }}</td>
                                <td data-label="Nome Completo">{{ $voucher['nome_completo'] ?? '-' }}</td>
                                <td data-label="CPF/CNPJ">{{ $voucher['cpf_cnpj'] ?? '-' }}</td>
                                <td data-label="Loja">{{ $voucher['loja'] ?? '-' }}</td>
                                <td data-label="Código do Voucher">{{ $voucher['voucher_code'] ?? '-' }}</td>
                                <td data-label="Gerado em">{{ \Carbon\Carbon::parse($voucher['gerado_em'])->format('d/m/Y') ?? '-' }}</td>
                                <td data-label="Ações">
                                    <form method="POST" action="{{ route('reimprimir-voucher.store', [
                                        'id' => $voucher['id'],
                                        'loja' => $voucher['loja'],
                                        'cpf_cnpj' => $voucher['cpf_cnpj'],
                                        'numero_nota' => $voucher['numero_nota']
                                    ]) }}" target="_blank" style="display:inline;">
                                        <button type="button" class="btn btn-sm btn-primary" title="Imprimir Declaração"
                                            onclick="imprimirVoucherEspecifico({!! htmlspecialchars(json_encode($voucher), ENT_QUOTES, 'UTF-8') !!})">
                                            <span aria-hidden="true">&#128424;</span>
                                        </button>
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Nenhum voucher encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
                .table-responsive {
                    width: 100%;
                    overflow-x: auto;
                }
                .table {
                    width: 100%;
                    min-width: 600px;
                    border-collapse: collapse;
                }
                .table th, .table td {
                    padding: 8px 12px;
                    border: 1px solid #e0e0ff;
                    text-align: left;
                    white-space: nowrap;
                }
                @media (max-width: 768px) {
                    .table, .table thead, .table tbody, .table th, .table td, .table tr {
                        display: block;
                    }
                    .table thead tr {
                        display: none;
                    }
                    .table tr {
                        margin-bottom: 16px;
                        border-bottom: 2px solid #e0e0ff;
                    }
                    .table td {
                        border: none;
                        border-bottom: 1px solid #e0e0ff;
                        position: relative;
                        padding-left: 50%;
                        min-height: 40px;
                        white-space: normal;
                    }
                    .table td:before {
                        position: absolute;
                        top: 8px;
                        left: 12px;
                        width: 45%;
                        padding-right: 10px;
                        white-space: nowrap;
                        font-weight: bold;
                        color: #2d2d8c;
                        content: attr(data-label);
                    }
                }
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

<script>
function imprimirVoucherEspecifico(voucher) {
    if (!voucher) return;

    // Data extenso
    const meses = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro',
        'outubro', 'novembro', 'dezembro'
    ];
    const hoje = new Date();
    const dia = hoje.getDate();
    const mes = meses[hoje.getMonth()];
    const ano = hoje.getFullYear();
    const dataFormatada = `${dia} de ${mes} de ${ano}`;
    
    // Cria o spinner centralizado
    const spinnerOverlay = document.createElement('div');
    spinnerOverlay.style.position = 'fixed';
    spinnerOverlay.style.top = 0;
    spinnerOverlay.style.left = 0;
    spinnerOverlay.style.width = '100vw';
    spinnerOverlay.style.height = '100vh';
    spinnerOverlay.style.background = 'rgba(255,255,255,0.8)';
    spinnerOverlay.style.display = 'flex';
    spinnerOverlay.style.alignItems = 'center';
    spinnerOverlay.style.justifyContent = 'center';
    spinnerOverlay.style.zIndex = 9999;

    const spinner = document.createElement('div');
    spinner.style.width = '60px';
    spinner.style.height = '60px';
    spinner.style.border = '6px solid #e0e0ff';
    spinner.style.borderTop = '6px solid #372FA4';
    spinner.style.borderRadius = '50%';
    spinner.style.animation = 'spin 1s linear infinite';

    // Adiciona animação ao spinner
    const style = document.createElement('style');
    style.innerHTML = `
        @keyframes spin {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }
    `;
    document.head.appendChild(style);

    spinnerOverlay.appendChild(spinner);
    document.body.appendChild(spinnerOverlay);

        setTimeout(function() {
            document.body.removeChild(spinnerOverlay);

            const w = window.open('', '_blank');
            w.document.write(`
                <html>
                <head>
                    <title>Declaração de Recebimento de Prêmio - Foz Tintas</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 30px; background: #fff; }
                        .declaracao-container { max-width: 700px; margin: 0 auto; border: 2px solid #372FA4; border-radius: 12px; padding: 40px 30px; }
                        .logo { text-align: right; margin-bottom: 20px; }
                        .logo img { max-width: 180px; }
                        .titulo { text-align: center; font-size: 1.5rem; font-weight: bold; color: #372FA4; margin-bottom: 10px; }
                        .subtitulo { text-align: center; font-size: 1.1rem; margin-bottom: 30px; }
                        .info { margin-bottom: 25px; }
                        .info strong { display: inline-block; width: 140px; }
                        .texto { font-size: 1.05rem; margin-bottom: 35px; text-align: justify; }
                        .assinatura-area { margin-top: 50px; }
                        .linha { border-bottom: 1px solid #333; width: 350px; margin: 40px auto 0; height: 2em; }
                        .assinatura-label { text-align: center; margin-top: 8px; font-size: 1rem; }
                        .data-local { margin: 40px 0 0 0; text-align: left; }
                    </style>
                </head>
                <body>
                    <div class="declaracao-container">
                        <div class="logo">
                            <img src="{{ asset('images/logo.png') }}?t={{ time() }}" alt="Foz Tintas Logo">
                        </div>
                        <div class="titulo">DECLARAÇÃO DE RECEBIMENTO DE PRÊMIO</div>
                        <div class="subtitulo">Promoção Compre e ganhe uma picanha</div>
                        <div class="info">
                            <div><strong>Voucher:</strong> ${voucher.voucher_code ?? voucher.numero ?? ''}</div>
                            <div><strong>Nome:</strong> ${voucher.nome_completo ?? (voucher.dados && voucher.dados.cliente) ?? ''}</div>
                            <div><strong>CPF/CNPJ:</strong> ${voucher.cpf_cnpj ?? (voucher.dados && voucher.dados.cpf) ?? ''}</div>
                            <div><strong>Número de Nota:</strong> ${voucher.numero_nota ?? (voucher.dados && voucher.dados.numeroNota) ?? ''}</div>
                        </div>
                        <div class="texto">
                            Para fins legais, declaro ter recebido de <strong>AGFABI COMÉRCIO DE TINTAS LTDA</strong>, inscrita no CNPJ sob o nº 03.053.280/0006-07, na data infra-assinada, o prêmio de uma peça de picanha, referente à campanha <strong>Promoção Compre e ganhe uma picanha</strong>, realizada na cidade de Toledo / PR, de 22 a 27 de setembro de 2025. Declaro ainda que não tive nenhuma despesa com o recebimento da premiação acima, sendo-me entregue, portanto, sem nenhum ônus, conforme previsto no regulamento. Autorizo, também, a inclusão de meu nome, imagem e som de voz para fins de divulgação dos contemplados na promoção, pelo prazo de 01 (um) ano a partir da data de apuração, sem acarretar qualquer ônus ou encargo à empresa.
                        </div>
                        <div class="data-local">
                            Toledo/PR, ${dataFormatada}.
                        </div>
                        <div style="margin-top: 30px;">De acordo</div>
                        <div class="assinatura-area">
                            <div class="linha"></div>
                            <div class="assinatura-label">Assinatura do contemplado</div>
                        </div>
                    </div>
                </body>
                </html>
            `);
            w.document.close();
            w.print();
        }, 2000);
        w.document.close();
    // w.print();
}
</script>

@endsection
