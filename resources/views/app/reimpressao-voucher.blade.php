@extends('app.index')
@section('content')
@section('title', 'Reimpressão de Voucher')
<meta name="csrf-token" content="{{ csrf_token() }}">
<main>
    <section class="hero">
        <div class="container">
            <h1>REIMPRIMIR VOUCHER</h1>
            <p>Informe apenas o número da nota fiscal para localizar seu voucher.</p>
        </div>
    </section>

    <section class="container">
        <div class="voucher-form-section">
            <h2 class="form-title">🖨️ Procurar Voucher para Reimpressão</h2>

            <form id="reprintForm" method="POST" novalidate>
                @csrf

                <div class="form-group">
                    <label for="numeroNota" class="form-label">📄 Número da Nota Fiscal</label>
                    <input type="text" id="numeroNota" name="numeroNota" class="form-input"
                        placeholder="Digite o número da nota..." maxlength="25">
                </div>

                <div id="errorMessage" class="error-message"></div>

                <div style="text-align:center; margin-top:12px;">
                    <button type="submit" class="btn btn-primary" id="submitBtn"
                        style="font-size:1.1rem; padding:16px 34px;">
                        🔍 Buscar e Mostrar Voucher
                    </button>
                    <div class="loading-spinner" id="loadingSpinner"></div>
                </div>
            </form>

            <div class="voucher-result" id="voucherResult">
                <h2>🎉 Voucher localizado!</h2>
                <div class="voucher-number" id="voucherNumber">VOUCHER-XXXX</div>

                <div class="voucher-details">
                    <h3>📋 Detalhes</h3>
                    <div class="voucher-info" id="voucherInfo"></div>
                </div>

                <div style="margin-top:12px;">
                    <button class="btn btn-secondary" id="btnImprimir">🖨️ Imprimir Declaração</button>
                    <button class="btn btn-primary" id="btnNovaBusca">🔄 Nova Busca</button>
                </div>
            </div>
        </div>

        <div class="alert alert-warning">
            ⚠️ <strong>Importante:</strong> Informe apenas o número da nota fiscal.
        </div>
    </section>
</main>

<script>
    // ====== DOM ======
    const reprintForm = document.getElementById('reprintForm');
    const numeroNota = document.getElementById('numeroNota');
    const errorMessage = document.getElementById('errorMessage');
    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const voucherResult = document.getElementById('voucherResult');
    const voucherNumberEl = document.getElementById('voucherNumber');
    const voucherInfoEl = document.getElementById('voucherInfo');
    const btnImprimir = document.getElementById('btnImprimir');
    const btnNovaBusca = document.getElementById('btnNovaBusca');

    function uiError(message, inputToMark) {
        errorMessage.textContent = message;
        errorMessage.style.display = 'flex';
        if (inputToMark) {
            inputToMark.classList.add('error');
            inputToMark.focus();
        }
    }

    function limpaErros() {
        errorMessage.textContent = '';
        errorMessage.style.display = 'none';
        numeroNota && numeroNota.classList.remove('error', 'success');
    }

    function clearResult() {
        voucherResult.style.display = 'none';
        voucherNumberEl.textContent = '';
        voucherInfoEl.innerHTML = '';
    }

    // Busca/Reimpressão
    reprintForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        limpaErros();
        clearResult();

        // Validação
        const nota = (numeroNota.value || '').trim();

        if (!nota) {
            return uiError('Preencha o número da nota fiscal.', numeroNota);
        }

        // CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            document.querySelector('input[name="_token"]')?.value;
        if (!csrfToken) return uiError('Token CSRF não encontrado. Recarregue a página.');

        // Loading
        submitBtn.disabled = true;
        submitBtn.textContent = 'Buscando...';
        loadingSpinner.style.display = 'block';

        try {
            const payload = {
                numeroNota: numeroNota.value.trim()
            };

            const res = await fetch('/reimprimir-voucher', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json().catch(() => ({}));
            if (!res.ok || !data || data.ok !== true) {
                showModalErro(data?.message || 'Voucher não encontrado para o número da nota informado.');
                throw new Error(data?.message || 'Voucher não encontrado.');
            }

            // SUCESSO
            const v = data.dados || {};
            voucherNumberEl.textContent = data.voucherNumber || '';
            voucherInfoEl.innerHTML = `
          <div class="voucher-info-item">
            <div class="voucher-info-label">👤 Cliente</div>
            <div class="voucher-info-value">${v.cliente ?? ''}</div>
          </div>
          <div class="voucher-info-item">
            <div class="voucher-info-label">🧾 Nº Nota</div>
            <div class="voucher-info-value">${v.numeroNota ?? ''}</div>
          </div>
          <div class="voucher-info-item">
            <div class="voucher-info-label">🆔 CPF/CNPJ</div>
            <div class="voucher-info-value">${v.cpf ?? ''}</div>
          </div>
          <div class="voucher-info-item">
            <div class="voucher-info-label">📅 Data</div>
            <div class="voucher-info-value">${v.data ?? ''}</div>
          </div>
          <div class="voucher-info-item">
            <div class="voucher-info-label">🏪 Loja</div>
            <div class="voucher-info-value">${v.loja ?? ''}</div>
          </div>
        `;
            voucherResult.style.display = 'block';
            voucherResult.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            window.ultimoVoucher = {
                numero: data.voucherNumber,
                dados: v,
                geradoEm: new Date().toLocaleString('pt-BR')
            };

        } catch (err) {
            uiError(err.message);
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = '🔍 Buscar e Mostrar Voucher';
            loadingSpinner.style.display = 'none';
        }
    });

    // Impressão
    function imprimirVoucher() {
        const voucher = window.ultimoVoucher;
        if (!voucher) return;

        const meses = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro',
            'outubro', 'novembro', 'dezembro'
        ];
        const hoje = new Date();
        const dia = hoje.getDate();
        const mes = meses[hoje.getMonth()];
        const ano = hoje.getFullYear();
        const dataFormatada = `${dia} de ${mes} de ${ano}`;

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
                            <img src="${window.location.origin}/images/logo.png" alt="Foz Tintas Logo" onload="window.print();window.close();">
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
        }, 500);
    }

    // Botões
    btnImprimir.addEventListener('click', imprimirVoucher);
    btnNovaBusca.addEventListener('click', () => {
        reprintForm.reset();
        limpaErros();
        clearResult();
        numeroNota.focus();
    });

    // Modal de erro
    function showModalErro(message) {
        let modal = document.getElementById('modalErroVoucher');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'modalErroVoucher';
            modal.innerHTML = `
        <div style="
          position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(30,23,80,0.45); z-index:9999; display:flex; align-items:center; justify-content:center;">
          <div style="
            background:#fff; border-radius:18px; max-width:420px; width:90%; box-shadow:0 8px 32px rgba(0,0,0,0.18); padding:38px 28px 28px; text-align:center; position:relative;">
            <div style="font-size:2.5rem; margin-bottom:10px;">❌</div>
            <div style="font-size:1.2rem; font-weight:600; color:#b91c1c; margin-bottom:18px;">Não foi possível localizar</div>
            <div id="modalMsg" style="color:#374151; font-size:1rem; margin-bottom:25px;">${message}</div>
            <button id="fecharModalErroVoucher" style="
              background:linear-gradient(45deg,#ef4444,#f59e0b); color:#fff; border:none; border-radius:25px; padding:12px 32px; font-size:1rem; font-weight:600; cursor:pointer; transition:.2s;">
              OK
            </button>
          </div>
        </div>`;
            document.body.appendChild(modal);
        } else {
            modal.querySelector('#modalMsg').textContent = message;
            modal.style.display = 'flex';
        }
        document.getElementById('fecharModalErroVoucher').onclick = function() {
            modal.style.display = 'none';
        };
        document.addEventListener('keydown', function escClose(e) {
            if (e.key === 'Escape') {
                modal.style.display = 'none';
                document.removeEventListener('keydown', escClose);
            }
        });
    }

    // Efeitos visuais
    window.addEventListener('load', function() {
        document.body.style.opacity = '0';
        document.body.style.transition = 'opacity .5s ease';
        setTimeout(() => {
            document.body.style.opacity = '1';
        }, 100);
    });
    (function animateFloatingElements() {
        document.querySelectorAll('.floating-element').forEach((el, i) => el.style.animationDelay = `${i*0.7}s`);
    })();

    // Autofocus inicial
    numeroNota.focus();
</script>

@endsection
