@extends('app.index')
@section('content')
@section('title', 'Cadastro de Voucher')
<main>
    <section class="hero">
        <div class="container">
            <h1>GERAR VOUCHER</h1>
            <div class="picanha-icon">🎫</div>
            <p>Digite o número da sua nota fiscal e ganhe seu voucher!</p>
        </div>
    </section>

    <section class="container">
        <div class="voucher-form-section">
            <h2 class="form-title">🎯 Cadastrar Nota e Gerar Voucher</h2>

            <form id="voucherForm" method="POST" novalidate>
                @csrf
                <div class="form-group">
                    <label for="numeroNota" class="form-label">📄 Número da Nota Fiscal</label>
                    <input type="text" id="numeroNota" name="numeroNota" class="form-input"
                        placeholder="Digite o número da nota fiscal..." maxlength="20" required>
                    <div class="error-message" id="errorMessage"
                        style="
            display: none;
            justify-content: center;
            align-items: center;
            background: #fff0f0;
            border: 2px solid #ef4444;
            border-radius: 12px;
            padding: 14px 22px;
            margin: 18px auto 0;
            max-width: 420px;
            box-shadow: 0 2px 12px rgba(239,68,68,0.07);
            font-size: 1.08rem;
            font-weight: 600;
            color: #b91c1c;
            text-align: center;
            letter-spacing: 0.01em;
            min-height: 1.2em;
            transition: all .2s;
            ">
                        <!-- Mensagem de erro aparece aqui -->
                    </div>
                </div>

                <div style="text-align:center;">
                    <button type="submit" class="btn btn-primary" id="submitBtn"
                        style="font-size:1.2rem; padding:18px 40px;">
                        🔍 Cadastrar e Gerar Voucher
                    </button>
                    <div class="loading-spinner" id="loadingSpinner"></div>
                </div>
            </form>

            <div class="voucher-result" id="voucherResult">
                <h2>🎉 PARABÉNS! SEU VOUCHER FOI GERADO!</h2>
                <div class="voucher-number" id="voucherNumber">VOUCHER-XXXX</div>

                <div class="voucher-details">
                    <h3>📋 Detalhes da Compra</h3>
                    <div class="voucher-info" id="voucherInfo"></div>
                </div>

                <div style="margin-top:25px;">
                    <button class="btn btn-secondary" onclick="imprimirVoucher()" style="margin-right:10px;">🖨️
                        Imprimir Voucher</button>
                    <button class="btn btn-primary" onclick="novaConsulta()">🔄 Nova Consulta</button>
                </div>
            </div>
        </div>

        <div class="alert alert-warning">
            ⚠️ <strong>Importante:</strong> Guarde o número do seu voucher! Ele será necessário para retirar sua picanha
            na loja.
        </div>
    </section>
</main>

<script>
    // ======== DOM refs ========
    const form = document.getElementById('voucherForm');
    const inputNota = document.getElementById('numeroNota');
    const errorMessage = document.getElementById('errorMessage');
    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const voucherResult = document.getElementById('voucherResult');

    // Função para esconder erro se campo válido
    function hideErrorIfValid(input) {
        let isValid = false;
        if (input === inputNota) {
            isValid = !!inputNota.value.trim();
        }
        if (isValid) {
            input.classList.remove('error');
            errorMessage.textContent = '';
            errorMessage.style.display = 'none';
        }
    }

    // Esconde erro ao digitar/clicar se válido
    inputNota.addEventListener('input', () => hideErrorIfValid(inputNota));

    // Validação mínima do número da nota no submit
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearUI();

        const numeroNota = inputNota.value.trim();

        if (!numeroNota) {
            return uiError('Por favor, digite o número da nota fiscal!', inputNota);
        }

        // CSRF token do meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            document.querySelector('input[name="_token"]')?.value;

        if (!csrfToken) {
            return uiError('Token CSRF não encontrado. Recarregue a página.');
        }

        // Loading
        submitBtn.disabled = true;
        submitBtn.textContent = 'Consultando...';
        loadingSpinner.style.display = 'block';

        // Chamada real para sua route Laravel
        fetch('/gerar-voucher', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    numeroNota
                })
            })
            .then(async (res) => {
                const data = await res.json().catch(() => ({}));
                if (!res.ok || !data.ok) {
                    showModalErro(data.message || 'Falha ao gerar voucher.');
                    throw new Error(data.message || 'Falha ao gerar voucher.');
                }

                inputNota.classList.add('success');

                document.getElementById('voucherNumber').textContent = data.voucherNumber;
                const v = data.dados || {};
                document.getElementById('voucherInfo').innerHTML = `
          <div class="voucher-info-item">
            <div class="voucher-info-label">👤 Cliente</div>
            <div class="voucher-info-value">${v.cliente ?? ''}</div>
          </div>
          <div class="voucher-info-item">
            <div class="voucher-info-label">🧾 Número da Nota</div>
            <div class="voucher-info-value">${v.numeroNota ?? ''}</div>
          </div>
          <div class="voucher-info-item">
            <div class="voucher-info-label">📄 CPF/CNPJ</div>
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

                // Salva para impressão
                localStorage.setItem('ultimoVoucher', JSON.stringify({
                    numero: data.voucherNumber,
                    dados: v,
                    geradoEm: new Date().toLocaleString('pt-BR')
                }));
            })
            .catch((err) => {
                uiError(err.message, inputNota);
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = '🔍 Cadastrar e Gerar Voucher';
                loadingSpinner.style.display = 'none';
            });
    });

    function uiError(message, inputToMark) {
        errorMessage.textContent = message;
        errorMessage.style.display = 'flex';
        if (inputToMark) {
            inputToMark.classList.add('error');
            inputToMark.focus();
        }
    }

    function clearUI() {
        errorMessage.textContent = '';
        errorMessage.style.display = 'none';
        [inputNota].forEach(el => el.classList.remove('error', 'success'));
        voucherResult.style.display = 'none';
    }

    function imprimirVoucher() {
        const voucher = JSON.parse(localStorage.getItem('ultimoVoucher'));
        if (!voucher) return;

        // Data atual formatada
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
            // A impressão será chamada automaticamente após o carregamento da logo (onload do img)
        }, 500);
    }

    function novaConsulta() {
        inputNota.value = '';
        clearUI();
        inputNota.focus();
    }

    function showModalErro(message) {
        // Cria modal de erro customizado
        let modal = document.getElementById('modalErroVoucher');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'modalErroVoucher';
            modal.innerHTML = `
        <div style="
        position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(30,23,80,0.45); z-index:9999; display:flex; align-items:center; justify-content:center;">
        <div style="
          background:#fff; border-radius:18px; max-width:400px; width:90%; box-shadow:0 8px 32px rgba(0,0,0,0.18); padding:38px 28px 28px; text-align:center; position:relative;">
          <div style="font-size:2.5rem; margin-bottom:10px;">❌</div>
          <div style="font-size:1.2rem; font-weight:600; color:#b91c1c; margin-bottom:18px;">Erro ao gerar voucher</div>
          <div style="color:#374151; font-size:1rem; margin-bottom:25px;">${message}</div>
          <button id="fecharModalErroVoucher" style="
            background:linear-gradient(45deg,#ef4444,#f59e0b); color:#fff; border:none; border-radius:25px; padding:12px 32px; font-size:1rem; font-weight:600; cursor:pointer; transition:.2s;">
            OK
          </button>
        </div>
        </div>
          `;
            document.body.appendChild(modal);
        } else {
            modal.querySelector('div[style*="background:#fff"]').children[2].textContent = message;
            modal.style.display = 'flex';
        }
        // Fecha ao clicar no botão
        document.getElementById('fecharModalErroVoucher').onclick = function() {
            modal.style.display = 'none';
            novaConsulta();
        };
        // Fecha ao pressionar ESC
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

    // Animação elementos flutuantes
    (function animateFloatingElements() {
        document.querySelectorAll('.floating-element').forEach((el, i) => el.style.animationDelay = `${i*0.7}s`);
    })();

    // Autofocus
    inputNota.focus();
</script>

@endsection
