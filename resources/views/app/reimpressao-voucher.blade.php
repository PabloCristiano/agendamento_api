@extends('app.dashboard')
@section('content')
@section('title', 'Reimpressão de Voucher')
<!-- CSRF para Laravel (Blade) -->
<meta name="csrf-token" content="{{ csrf_token() }}">

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
        font-size: 3.2rem;
        font-weight: 800;
        margin-bottom: 12px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, .3);
    }

    .hero p {
        font-size: 1.15rem;
        opacity: .95;
    }

    .voucher-form-section {
        background: rgba(255, 255, 255, .95);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 40px;
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
        font-size: 2.2rem;
        font-weight: 700;
        background: linear-gradient(45deg, #6b46c1, #ef4444);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 24px;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        font-size: 1.05rem;
    }

    .form-input {
        width: 100%;
        padding: 16px 20px;
        border: 3px solid #e5e7eb;
        border-radius: 15px;
        font-size: 1.1rem;
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

    .row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
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

    .error-message {
        display: none;
        justify-content: center;
        align-items: center;
        background: #fff0f0;
        border: 2px solid #ef4444;
        border-radius: 12px;
        padding: 14px 22px;
        margin: 10px auto 0;
        max-width: 520px;
        box-shadow: 0 2px 12px rgba(239, 68, 68, 0.07);
        font-size: 1.02rem;
        font-weight: 600;
        color: #b91c1c;
        text-align: center;
        letter-spacing: 0.01em;
        min-height: 1.2em;
        transition: all .2s;
    }

    .voucher-result {
        display: none;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        padding: 34px;
        border-radius: 20px;
        text-align: center;
        margin-top: 26px;
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
        font-size: 2.6rem;
        font-weight: 800;
        margin: 12px 0 6px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, .3);
        letter-spacing: 2px;
    }

    .voucher-details {
        background: rgba(255, 255, 255, .12);
        padding: 22px;
        border-radius: 15px;
        margin: 18px 0;
    }

    .voucher-details h3 {
        font-size: 1.35rem;
        margin-bottom: 12px;
    }

    .voucher-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        text-align: left;
    }

    .voucher-info-item {
        background: rgba(255, 255, 255, .12);
        padding: 14px;
        border-radius: 10px;
    }

    .voucher-info-label {
        font-size: .9rem;
        opacity: .85;
        margin-bottom: 4px;
    }

    .voucher-info-value {
        font-weight: 700;
        font-size: 1.05rem;
        word-break: break-word;
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
        padding: 18px;
        border-radius: 15px;
        margin: 14px 0;
        font-weight: 500;
    }

    .alert-warning {
        background: #fffbeb;
        color: #92400e;
        border: 2px solid #f59e0b;
    }

    @media (max-width:900px) {
        .row {
            grid-template-columns: 1fr
        }

        .hero h1 {
            font-size: 2.4rem
        }
    }
</style>
<main>
    <section class="hero">
        <div class="container">
            <h1>REIMPRIMIR VOUCHER</h1>
            <p>Informe CPF/CNPJ, número da nota fiscal e loja para localizar seu voucher.</p>
        </div>
    </section>

    <section class="container">
        <div class="voucher-form-section">
            <h2 class="form-title">🖨️ Procurar Voucher para Reimpressão</h2>

            <form id="reprintForm" method="POST" novalidate>
                @csrf

                <div class="row">
                    <div class="form-group">
                        <label for="cpfCnpj" class="form-label">🆔 CPF ou CNPJ</label>
                        <input type="text" id="cpfCnpj" name="cpfCnpj" class="form-input"
                            placeholder="Digite CPF ou CNPJ..." maxlength="18">
                    </div>
                    <div class="form-group">
                        <label for="numeroNota" class="form-label">📄 Número da Nota Fiscal</label>
                        <input type="text" id="numeroNota" name="numeroNota" class="form-input"
                            placeholder="Digite o número da nota..." maxlength="25">
                    </div>
                </div>
                <div class="form-group">
                    <label for="loja" class="form-label">🏪 Loja</label>
                    <select id="loja" name="loja" class="form-input">
                        <option value="">Selecione a loja...</option>
                        <option value="loja007">Av. José João Muraro, 717 - Jardim Porto Alegre - Loja 007</option>
                        <option value="loja011">R. Rui Barbosa, 998 - Centro - Loja 011</option>
                    </select>
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
            ⚠️ <strong>Importante:</strong> Informe o CPF ou CNPJ, número da nota fiscal e selecione a loja onde foi
            feita a compra.
        </div>
    </section>
</main>

<script>
    // ====== Utilidades CPF/CNPJ ======
    function maskCpfCnpj(value) {
        value = value.replace(/\D/g, '');
        if (value.length <= 11) {
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        } else {
            value = value.replace(/^(\d{2})(\d)/, '$1.$2');
            value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
            value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
        }
        return value;
    }

    function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;
        let soma = 0,
            resto;
        for (let i = 1; i <= 9; i++) soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.substring(9, 10))) return false;
        soma = 0;
        for (let i = 1; i <= 10; i++) soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.substring(10, 11))) return false;
        return true;
    }

    function validarCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]+/g, '');
        if (cnpj.length !== 14 || /^(\d)\1+$/.test(cnpj)) return false;
        let tamanho = cnpj.length - 2;
        let numeros = cnpj.substring(0, tamanho);
        let digitos = cnpj.substring(tamanho);
        let soma = 0;
        let pos = tamanho - 7;
        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado !== parseInt(digitos.charAt(0))) return false;
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado !== parseInt(digitos.charAt(1))) return false;
        return true;
    }

    // ====== DOM ======
    const reprintForm = document.getElementById('reprintForm');
    const cpfCnpj = document.getElementById('cpfCnpj');
    const numeroNota = document.getElementById('numeroNota');
    const loja = document.getElementById('loja');
    const errorMessage = document.getElementById('errorMessage');
    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const voucherResult = document.getElementById('voucherResult');
    const voucherNumberEl = document.getElementById('voucherNumber');
    const voucherInfoEl = document.getElementById('voucherInfo');
    const btnImprimir = document.getElementById('btnImprimir');
    const btnNovaBusca = document.getElementById('btnNovaBusca');

    // Máscara CPF/CNPJ
    cpfCnpj && cpfCnpj.addEventListener('input', (e) => e.target.value = maskCpfCnpj(e.target.value));

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
        [cpfCnpj, numeroNota, loja].forEach(el => el && el.classList.remove('error', 'success'));
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

        // Validações
        const doc = (cpfCnpj.value || '').trim();
        const nota = (numeroNota.value || '').trim();
        const lj = (loja.value || '').trim();

        if (!doc || !nota || !lj) {
            return uiError('Preencha todos os campos: CPF/CNPJ, número da nota e loja.');
        }

        const only = doc.replace(/\D/g, '');
        let okDoc = false;
        if (only.length === 11) okDoc = validarCPF(doc);
        else if (only.length === 14) okDoc = validarCNPJ(doc);
        if (!okDoc) return uiError('CPF/CNPJ inválido.', cpfCnpj);

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
                cpfCnpj: cpfCnpj.value.trim(),
                numeroNota: numeroNota.value.trim(),
                loja: loja.value.trim()
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
                showModalErro(data?.message || 'Voucher não encontrado para os dados informados.');
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

            // Guarda para impressão usando variáveis JavaScript em vez de localStorage
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

        // Data extenso
        const meses = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro',
            'outubro', 'novembro', 'dezembro'
        ];
        const hoje = new Date();
        const dia = hoje.getDate();
        const mes = meses[hoje.getMonth()];
        const ano = hoje.getFullYear();
        const dataFormatada = `${dia} de ${mes} de ${ano}`;

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
              <img src="{{ asset('images/logo.png') }}" alt="Foz Tintas Logo">
            </div>
            <div class="titulo">DECLARAÇÃO DE RECEBIMENTO DE PRÊMIO</div>
            <div class="subtitulo">Promoção Compre e ganhe uma picanha</div>
            <div class="info">
              <div><strong>Voucher:</strong> ${voucher.numero}</div>
              <div><strong>Nome:</strong> ${voucher.dados.cliente ?? ''}</div>
              <div><strong>CPF/CNPJ:</strong> ${voucher.dados.cpf ?? ''}</div>
              <div><strong>Número de Nota:</strong> ${voucher.dados.numeroNota ?? ''}</div>
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
    }

    // Botões
    btnImprimir.addEventListener('click', imprimirVoucher);
    btnNovaBusca.addEventListener('click', () => {
        reprintForm.reset();
        limpaErros();
        clearResult();
        cpfCnpj.focus();
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
    cpfCnpj.focus();
</script>

@endsection
