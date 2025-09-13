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

                    <label for="nomeCompleto" class="form-label" style="margin-top:20px;">👤 Nome Completo</label>
                    <input type="text" id="nomeCompleto" name="nomeCompleto" class="form-input"
                        placeholder="Digite nome completo..." minlength="3" required>

                    <label for="cpfCnpj" class="form-label" style="margin-top:20px;">🆔 CPF ou CNPJ</label>
                    <input type="text" id="cpfCnpj" name="cpfCnpj" class="form-input"
                        placeholder="Digite CPF ou CNPJ..." maxlength="18" required>

                    <label for="loja" class="form-label" style="margin-top:20px;">🏪 Loja</label>
                    <select id="loja" name="loja" class="form-input" required>
                        <option value="">Selecione a loja...</option>
                        <option value="loja007">Av. José João Muraro, 717 - Jardim Porto Alegre - Loja 007</option>
                        <option value="loja011">R. Rui Barbosa, 998 - Centro - Loja 011</option>
                    </select>

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
    // ======== Utilidades CPF/CNPJ ========
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

    // ======== DOM refs ========
    const form = document.getElementById('voucherForm');
    const inputNota = document.getElementById('numeroNota');
    const inputNome = document.getElementById('nomeCompleto');
    const inputCpfCnpj = document.getElementById('cpfCnpj');
    const inputLoja = document.getElementById('loja');
    const errorMessage = document.getElementById('errorMessage');
    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const voucherResult = document.getElementById('voucherResult');

    // Função para esconder erro se campo válido
    function hideErrorIfValid(input) {
        let isValid = false;
        if (input === inputNota) {
            isValid = !!inputNota.value.trim();
        } else if (input === inputNome) {
            isValid = inputNome.value.trim().length >= 3;
        } else if (input === inputCpfCnpj) {
            const val = inputCpfCnpj.value.trim().replace(/\D/g, '');
            isValid = (val.length === 11 && validarCPF(inputCpfCnpj.value)) ||
                (val.length === 14 && validarCNPJ(inputCpfCnpj.value));
        } else if (input === inputLoja) {
            isValid = !!inputLoja.value.trim();
        }
        if (isValid) {
            input.classList.remove('error');
            errorMessage.textContent = '';
            errorMessage.style.display = 'none';
        }
    }

    // Máscara ao digitar CPF/CNPJ
    inputCpfCnpj.addEventListener('input', (e) => {
        e.target.value = maskCpfCnpj(e.target.value);
        hideErrorIfValid(inputCpfCnpj);
    });

    // Esconde erro ao digitar/clicar se válido
    inputNota.addEventListener('input', () => hideErrorIfValid(inputNota));
    inputNome.addEventListener('input', () => hideErrorIfValid(inputNome));
    inputLoja.addEventListener('change', () => hideErrorIfValid(inputLoja));

    // Validação mínima do nome no submit
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearUI();

        const numeroNota = inputNota.value.trim();
        const nomeCompleto = inputNome.value.trim();
        const cpfCnpj = inputCpfCnpj.value.trim();
        const loja = inputLoja.value.trim();

        if (!numeroNota) {
            return uiError('Por favor, digite o número da nota fiscal!', inputNota);
        }
        if (nomeCompleto.length < 3) {
            return uiError('O nome completo deve ter pelo menos 3 caracteres!', inputNome);
        }

        const onlyNumbers = cpfCnpj.replace(/\D/g, '');
        let cpfCnpjValido = false;
        if (onlyNumbers.length === 11) cpfCnpjValido = validarCPF(cpfCnpj);
        else if (onlyNumbers.length === 14) cpfCnpjValido = validarCNPJ(cpfCnpj);

        if (!cpfCnpj || !cpfCnpjValido) {
            return uiError('CPF ou CNPJ inválido!', inputCpfCnpj);
        }
        if (!loja) {
            return uiError('Por favor, selecione a loja!', inputLoja);
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
                    numeroNota,
                    nomeCompleto,
                    cpfCnpj,
                    loja
                })
            })
            .then(async (res) => {
                const data = await res.json().catch(() => ({}));
                console.log('Response data:', data, res);
                if (!res.ok || !data.ok) {
                    // Mostra modal de erro customizado
                    showModalErro(data.message || 'Falha ao gerar voucher.');
                    throw new Error(data.message || 'Falha ao gerar voucher.');
                }

                // Sucesso
                inputNota.classList.add('success');
                inputCpfCnpj.classList.add('success');
                inputLoja.classList.add('success');
                inputNome.classList.add('success');

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
        [inputNota, inputNome, inputCpfCnpj, inputLoja].forEach(el => el.classList.remove('error', 'success'));
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

    function novaConsulta() {
        inputNota.value = '';
        inputNome.value = '';
        inputCpfCnpj.value = '';
        inputLoja.value = '';
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
