<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compre e Ganhe uma Picanha - Promoção</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
       
        body {
            background: linear-gradient(45deg, #1a1a1a, #2d2d2d);
            color: #ff6b35;
            font-family: 'Press Start 2P', cursive;
            text-align: center;
            margin: 0;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .logo {
            font-size: 1.5em;
            margin-bottom: 20px;
            animation: glitch 2s infinite alternate;
            text-shadow: 2px 2px 4px rgba(255, 107, 53, 0.5);
        }

        .promo-title {
            font-size: 2.5em;
            color: #ffff00;
            margin: 20px 0;
            animation: neonGlow 1.5s infinite alternate;
            text-shadow: 0 0 20px #ffff00;
        }

        .loading {
            font-size: 0.8em;
            margin: 20px 0;
            animation: blink 1s infinite;
            color: #33ff33;
        }

        .promo-details {
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid #ff6b35;
            border-radius: 10px;
            padding: 30px;
            margin: 20px 0;
            max-width: 800px;
            box-shadow: 0 0 30px rgba(255, 107, 53, 0.3);
        }

        .promo-item {
            margin: 15px 0;
            padding: 15px;
            background: rgba(255, 107, 53, 0.1);
            border-left: 4px solid #ff6b35;
            font-size: 0.7em;
            line-height: 1.8;
            text-align: left;
        }

        .highlight {
            color: #ffff00;
            font-weight: bold;
        }

        .validity {
            color: #ff3333;
            font-size: 0.8em;
            margin-top: 20px;
            animation: pulse 2s infinite;
        }

        .picanha-icon {
            font-size: 3em;
            margin: 20px 0;
            animation: bounce 2s infinite;
        }

        @keyframes blink {
            50% { opacity: 0; }
        }

        @keyframes glitch {
            0% { transform: skewX(0deg); }
            20% { transform: skewX(-2deg); }
            40% { transform: skewX(2deg); }
            60% { transform: skewX(-2deg); }
            80% { transform: skewX(2deg); }
            100% { transform: skewX(0deg); }
        }

        @keyframes neonGlow {
            0% { text-shadow: 0 0 20px #ffff00; }
            100% { text-shadow: 0 0 30px #ffff00, 0 0 40px #ffff00; }
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .stores {
            background: rgba(255, 107, 53, 0.2);
            border: 2px dashed #ff6b35;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
        }

        .store-item {
            color: #33ff33;
            font-size: 0.6em;
            margin: 10px 0;
        }

        .ip-address {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 0.5em;
            color: #888;
            background: rgba(0, 0, 0, 0.8);
            padding: 10px;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .logo {
                font-size: 1em;
            }
            .promo-title {
                font-size: 1.5em;
            }
            .promo-details {
                padding: 20px;
                margin: 10px;
            }
            .promo-item {
                font-size: 0.6em;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">PROMOÇÃO ESPECIAL</div>
        
        <div class="promo-title">COMPRE E GANHE</div>
        
        <div class="picanha-icon">🥩</div>
        
        <div class="loading">> Carregando oferta especial...</div>
        
        <div class="promo-details">
            <div class="promo-item">
                <span class="highlight">SUVINIL:</span><br>
                Nas compras acima de <span class="highlight">R$ 300,00</span> em produtos Suvinil, você ganha uma peça de picanha!
            </div>
            
            <div class="promo-item">
                <span class="highlight">SHERWIN-WILLIAMS AUTO:</span><br>
                Nas compras de <span class="highlight">R$ 500,00</span> em produtos Sherwin-Williams Auto, você ganha uma peça de picanha!
            </div>
            
            <div class="stores">
                <div style="color: #ffff00; font-size: 0.8em; margin-bottom: 15px;">LOJAS PARTICIPANTES EM TOLEDO:</div>
                <div class="store-item">► FILIAL 007</div>
                <div class="store-item">► FILIAL 011</div>
            </div>
            
            <div class="promo-item">
                <span class="highlight">CONDIÇÕES:</span><br>
                • Válido somente para compras com nota fiscal<br>
                • Uma peça de picanha por CPF/CNPJ<br>
                • Válido apenas nas lojas de Toledo participantes
            </div>
            
            <div class="validity">
                ⏰ AÇÃO VÁLIDA DE 22 A 27 DE SETEMBRO ⏰
            </div>
        </div>
    </div>
    
    <!-- <div class="ip-address">
        <script>
            // Simulação do IP (já que não temos PHP disponível)
            fetch('https://api.ipify.org?format=json')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('.ip-address').innerHTML = `Seu IP: ${data.ip}`;
                })
                .catch(() => {
                    document.querySelector('.ip-address').innerHTML = 'Seu IP: Não disponível';
                });
        </script>
    </div> -->

    <script>
        // Efeito de animação no carregamento
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.querySelector('.loading').textContent = '> Promoção ativa! Aproveite!';
            }, 2000);
        });

        // Efeito de partículas simples
        function createParticle() {
            const particle = document.createElement('div');
            particle.innerHTML = '🥩';
            particle.style.position = 'fixed';
            particle.style.fontSize = '20px';
            particle.style.left = Math.random() * window.innerWidth + 'px';
            particle.style.top = '-50px';
            particle.style.pointerEvents = 'none';
            particle.style.zIndex = '-1';
            particle.style.opacity = '0.3';
            
            document.body.appendChild(particle);
            
            let pos = -50;
            const interval = setInterval(() => {
                pos += 2;
                particle.style.top = pos + 'px';
                
                if (pos > window.innerHeight) {
                    clearInterval(interval);
                    document.body.removeChild(particle);
                }
            }, 50);
        }

        // Criar partículas ocasionalmente
        setInterval(createParticle, 3000);
    </script>
</body>
</html>