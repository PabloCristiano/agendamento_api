<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foz Tintas - Gerar Voucher Picanha</title>
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
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(45deg, #10b981, #3b82f6);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(45deg, #f59e0b, #ef4444);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .hero {
            text-align: center;
            padding: 60px 0 40px;
            color: white;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        .picanha-icon {
            font-size: 4rem;
            margin: 20px 0;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .voucher-form-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 50px;
            margin: 40px 0;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
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
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 5px rgba(59, 130, 246, 0.1);
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
            font-size: 0.9rem;
            margin-top: 8px;
            font-weight: 500;
        }

        .loading-spinner {
            display: none;
            width: 24px;
            height: 24px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .voucher-result {
            display: none;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin-top: 30px;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .voucher-number {
            font-size: 3rem;
            font-weight: 800;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: 3px;
        }

        .voucher-details {
            background: rgba(255, 255, 255, 0.1);
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
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
        }

        .voucher-info-label {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .voucher-info-value {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .instructions {
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            color: white;
            border-radius: 20px;
            padding: 35px;
            margin: 30px 0;
        }

        .instructions h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .instructions ul {
            list-style: none;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .instructions li {
            position: relative;
            padding-left: 35px;
            margin-bottom: 10px;
        }

        .instructions li::before {
            content: '📋';
            position: absolute;
            left: 0;
            font-size: 1.2rem;
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
            opacity: 0.1;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .alert {
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
            font-weight: 500;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 2px solid #10b981;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 2px solid #ef4444;
        }

        .alert-warning {
            background: #fffbeb;
            color: #92400e;
            border: 2px solid #f59e0b;
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .hero p { font-size: 1.1rem; }
            .voucher-form-section { padding: 30px 25px; }
            .form-title { font-size: 2rem; }
            .voucher-number { font-size: 2.5rem; }
            .logo { font-size: 2rem; }
            .nav-buttons { flex-direction: column; gap: 10px; }
            .voucher-info { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-element" style="top: 10%; left: 10%; font-size: 3rem;">🎫</div>
        <div class="floating-element" style="top: 20%; right: 20%; font-size: 2rem;">🥩</div>
        <div class="floating-element" style="bottom: 30%; left: 15%; font-size: 2.5rem;">✨</div>
        <div class="floating-element" style="bottom: 10%; right: 10%; font-size: 3rem;">🎨</div>
    </div>

    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">FOZ TINTAS</div>
                <div class="nav-buttons">
                    <a href="/" class="btn btn-secondary">← Voltar à Promoção</a>
                </div>
            </div>
        </div>
    </header>

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
                <h2 class="form-title">🎯 Consultar Nota Fiscal</h2>
                
                <form id="voucherForm">
                    <div class="form-group">
                        <label for="numeroNota" class="form-label">
                            📄 Número da Nota Fiscal
                        </label>
                        <input 
                            type="text" 
                            id="numeroNota" 
                            name="numeroNota" 
                            class="form-input" 
                            placeholder="Digite o número da nota fiscal..."
                            maxlength="20"
                            required
                        >
                        <div class="error-message" id="errorMessage"></div>
                    </div>

                    <div style="text-align: center;">
                        <button type="submit" class="btn btn-primary" id="submitBtn" style="font-size: 1.2rem; padding: 18px 40px;">
                            🔍 Consultar e Gerar Voucher
                        </button>
                        <div class="loading-spinner" id="loadingSpinner"></div>
                    </div>
                </form>

                <!-- Resultado do Voucher -->
                <div class="voucher-result" id="voucherResult">
                    <h2>🎉 PARABÉNS! SEU VOUCHER FOI GERADO!</h2>
                    <div class="voucher-number" id="voucherNumber">VOUCHER-123456</div>
                    
                    <div class="voucher-details">
                        <h3>📋 Detalhes da Compra</h3>
                        <div class="voucher-info" id="voucherInfo">
                            <!-- Dados serão preenchidos via JavaScript -->
                        </div>
                    </div>

                    <div style="margin-top: 25px;">
                        <button class="btn btn-secondary" onclick="imprimirVoucher()" style="margin-right: 10px;">
                            🖨️ Imprimir Voucher
                        </button>
                        <button class="btn btn-primary" onclick="novaConsulta()">
                            🔄 Nova Consulta
                        </button>
                    </div>
                </div>
            </div>

            {{-- <div class="instructions">
                <h3>📋 COMO RESGATAR SEU VOUCHER</h3>
                <ul>
                    <li>Apresente este voucher em uma das lojas participantes</li>
                    <li>Leve um documento com foto (RG ou CNH)</li>
                    <li>O voucher é válido até 30 dias após a data da compra</li>
                    <li>Uma picanha por CPF/CNPJ participante</li>
                    <li>Sujeito à disponibilidade de estoque</li>
                </ul>
            </div> --}}

            <div class="alert alert-warning">
                ⚠️ <strong>Importante:</strong> Guarde bem o número do seu voucher! Ele será necessário para retirar sua picanha na loja.
            </div>
        </section>
    </main>

    <script>
        // Simulação de dados de notas fiscais (substitua pela sua API)
        const notasFiscais = {
            '12345': {
                cliente: 'João Silva Santos',
                cpf: '123.456.789-00',
                valor: 'R$ 350,00',
                marca: 'SUVINIL',
                data: '25/09/2024',
                loja: 'Av. José João Muraro, 717'
            },
            '67890': {
                cliente: 'Maria Oliveira Lima',
                cpf: '987.654.321-00',
                valor: 'R$ 520,00',
                marca: 'SHERWIN-WILLIAMS AUTO',
                data: '24/09/2024',
                loja: 'R. Rui Barbosa, 998'
            },
            '54321': {
                cliente: 'Carlos Pereira Costa',
                cpf: '456.789.123-00',
                valor: 'R$ 780,00',
                marca: 'SUVINIL',
                data: '23/09/2024',
                loja: 'Av. José João Muraro, 717'
            }
        };

        document.getElementById('voucherForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const numeroNota = document.getElementById('numeroNota').value.trim();
            const errorMessage = document.getElementById('errorMessage');
            const submitBtn = document.getElementById('submitBtn');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const voucherResult = document.getElementById('voucherResult');
            const input = document.getElementById('numeroNota');

            // Limpar mensagens anteriores
            errorMessage.textContent = '';
            input.classList.remove('error', 'success');
            voucherResult.style.display = 'none';

            // Validação
            if (!numeroNota) {
                showError('Por favor, digite o número da nota fiscal!');
                return;
            }

            // Mostrar loading
            submitBtn.disabled = true;
            submitBtn.textContent = 'Consultando...';
            loadingSpinner.style.display = 'block';

            // Simular consulta à API
            setTimeout(() => {
                const dadosNota = notasFiscais[numeroNota];
                
                if (dadosNota) {
                    // Nota encontrada - gerar voucher
                    input.classList.add('success');
                    gerarVoucher(numeroNota, dadosNota);
                } else {
                    // Nota não encontrada
                    showError('Nota fiscal não encontrada ou não elegível para a promoção!');
                }

                // Restaurar botão
                submitBtn.disabled = false;
                submitBtn.textContent = '🔍 Consultar e Gerar Voucher';
                loadingSpinner.style.display = 'none';
            }, 2000);
        });

        function showError(message) {
            const errorMessage = document.getElementById('errorMessage');
            const input = document.getElementById('numeroNota');
            
            errorMessage.textContent = message;
            input.classList.add('error');
            input.focus();
        }

        function gerarVoucher(numeroNota, dados) {
            // Gerar número do voucher único
            const timestamp = Date.now();
            const voucherNum = `PICANHA-${numeroNota}-${timestamp.toString().slice(-4)}`;
            
            // Preencher dados do voucher
            document.getElementById('voucherNumber').textContent = voucherNum;
            
            const voucherInfo = document.getElementById('voucherInfo');
            voucherInfo.innerHTML = `
                <div class="voucher-info-item">
                    <div class="voucher-info-label">👤 Cliente</div>
                    <div class="voucher-info-value">${dados.cliente}</div>
                </div>
                <div class="voucher-info-item">
                    <div class="voucher-info-label">📄 CPF</div>
                    <div class="voucher-info-value">${dados.cpf}</div>
                </div>
                <div class="voucher-info-item">
                    <div class="voucher-info-label">💰 Valor da Compra</div>
                    <div class="voucher-info-value">${dados.valor}</div>
                </div>
                <div class="voucher-info-item">
                    <div class="voucher-info-label">🎨 Marca</div>
                    <div class="voucher-info-value">${dados.marca}</div>
                </div>
                <div class="voucher-info-item">
                    <div class="voucher-info-label">📅 Data da Compra</div>
                    <div class="voucher-info-value">${dados.data}</div>
                </div>
                <div class="voucher-info-item">
                    <div class="voucher-info-label">🏪 Loja</div>
                    <div class="voucher-info-value">${dados.loja}</div>
                </div>
            `;
            
            // Mostrar resultado
            document.getElementById('voucherResult').style.display = 'block';
            document.getElementById('voucherResult').scrollIntoView({ 
                behavior: 'smooth',
                block: 'center'
            });

            // Salvar voucher no localStorage (para impressão)
            localStorage.setItem('ultimoVoucher', JSON.stringify({
                numero: voucherNum,
                dados: dados,
                geradoEm: new Date().toLocaleString('pt-BR')
            }));
        }

        function imprimirVoucher() {
            const voucher = JSON.parse(localStorage.getItem('ultimoVoucher'));
            if (!voucher) return;

            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Voucher Picanha - Foz Tintas</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; }
                        .voucher { border: 3px solid #372FA4; padding: 30px; text-align: center; max-width: 500px; margin: 0 auto; }
                        .logo { color: #372FA4; font-size: 2rem; font-weight: bold; margin-bottom: 20px; }
                        .voucher-number { font-size: 1.5rem; font-weight: bold; color: #10b981; margin: 20px 0; }
                        .details { text-align: left; margin: 20px 0; }
                        .detail-row { margin: 10px 0; }
                        .instructions { background: #f0f0f0; padding: 15px; margin-top: 20px; font-size: 12px; }
                    </style>
                </head>
                <body>
                    <div class="voucher">
                        <div class="logo">🥩 FOZ TINTAS - VOUCHER PICANHA</div>
                        <div class="voucher-number">${voucher.numero}</div>
                        <div class="details">
                            <div class="detail-row"><strong>Cliente:</strong> ${voucher.dados.cliente}</div>
                            <div class="detail-row"><strong>CPF:</strong> ${voucher.dados.cpf}</div>
                            <div class="detail-row"><strong>Valor:</strong> ${voucher.dados.valor}</div>
                            <div class="detail-row"><strong>Marca:</strong> ${voucher.dados.marca}</div>
                            <div class="detail-row"><strong>Data:</strong> ${voucher.dados.data}</div>
                            <div class="detail-row"><strong>Loja:</strong> ${voucher.dados.loja}</div>
                            <div class="detail-row"><strong>Gerado em:</strong> ${voucher.geradoEm}</div>
                        </div>
                        <div class="instructions">
                            <strong>INSTRUÇÕES:</strong><br>
                            • Apresente este voucher na loja<br>
                            • Leve documento com foto<br>
                            • Válido por 30 dias<br>
                            • Uma picanha por CPF
                        </div>
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }

        function novaConsulta() {
            document.getElementById('numeroNota').value = '';
            document.getElementById('numeroNota').classList.remove('error', 'success');
            document.getElementById('errorMessage').textContent = '';
            document.getElementById('voucherResult').style.display = 'none';
            document.getElementById('numeroNota').focus();
        }

        // Efeitos visuais
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });

        // Animação dos elementos flutuantes
        function animateFloatingElements() {
            const elements = document.querySelectorAll('.floating-element');
            elements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.7}s`;
            });
        }

        animateFloatingElements();

        // Auto-focus no campo de input
        document.getElementById('numeroNota').focus();
    </script>
</body>
</html>
