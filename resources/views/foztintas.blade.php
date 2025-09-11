<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foz Tintas - Compre e Ganhe uma Picanha</title>
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

        .hero {
            text-align: center;
            padding: 80px 0;
            color: white;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        .picanha-icon {
            font-size: 6rem;
            margin: 30px 0;
            animation: rotate 3s ease-in-out infinite;
        }

        @keyframes rotate {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(10deg); }
        }

        .promo-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin: 60px 0;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #6b46c1, #3b82f6, #10b981, #f59e0b, #ef4444);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 20px;
        }

        .card .brand {
            background: linear-gradient(45deg, #6b46c1, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card .price {
            font-size: 3rem;
            font-weight: 800;
            color: #10b981;
            margin: 20px 0;
        }

        .card .description {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .stores-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 40px;
            margin: 40px 0;
            text-align: center;
        }

        .stores-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, #6b46c1, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 30px;
        }

        .stores-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .store-card {
            background: #372FA4;
            color: white;
            padding: 30px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .conditions {
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            color: white;
            border-radius: 25px;
            padding: 40px;
            margin: 40px 0;
        }

        .conditions h3 {
            font-size: 2rem;
            margin-bottom: 25px;
            text-align: center;
        }

        .conditions ul {
            list-style: none;
            font-size: 1.1rem;
            line-height: 2;
        }

        .conditions li {
            position: relative;
            padding-left: 30px;
        }

        .conditions li::before {
            content: '✓';
            position: absolute;
            left: 0;
            font-weight: bold;
            color: #fbbf24;
        }

        .validity-banner {
            background: linear-gradient(45deg, #ef4444, #dc2626);
            color: white;
            text-align: center;
            padding: 30px;
            border-radius: 15px;
            margin: 30px 0;
            font-size: 1.5rem;
            font-weight: 700;
            animation: pulse 2s infinite;
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
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

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .hero p { font-size: 1.2rem; }
            .promo-cards { grid-template-columns: 1fr; }
            .card { padding: 25px; }
            .logo { font-size: 2rem; }
            .nav-buttons { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-element" style="top: 10%; left: 10%; font-size: 3rem;">🎨</div>
        <div class="floating-element" style="top: 20%; right: 20%; font-size: 2rem;">🏪</div>
        <div class="floating-element" style="bottom: 30%; left: 15%; font-size: 2.5rem;">✨</div>
        <div class="floating-element" style="bottom: 10%; right: 10%; font-size: 3rem;">🥩</div>
    </div>

    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">FOZ TINTAS</div>
                <div class="nav-buttons">
                    <a href="#" class="btn btn-primary">Cadastrar Nota e Gerar Voucher</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <h1>COMPRE E GANHE</h1>
                <div class="picanha-icon">🥩</div>
                <p>Uma deliciosa picanha te espera!</p>
            </div>
        </section>

        <section class="container">
            <div class="promo-cards">
                <div class="card">
                    <h3 class="brand">SUVINIL</h3>
                    <div class="price">R$ 300</div>
                    <div class="description">
                        Nas compras acima de R$ 300,00 em produtos Suvinil, você ganha uma peça de picanha fresquinha! 
                        Aproveite esta oportunidade única de colorir sua casa e ainda garantir aquele churrasco especial.
                    </div>
                </div>

                <div class="card">
                    <h3 class="brand">SHERWIN-WILLIAMS AUTO</h3>
                    <div class="price">R$ 500</div>
                    <div class="description">
                        Nas compras de R$ 500,00 em produtos Sherwin-Williams Auto, você leva uma picanha de presente! 
                        Qualidade profissional para seu veículo e sabor garantido para sua mesa.
                    </div>
                </div>
            </div>

            <div class="stores-section">
                <h2 class="stores-title">LOJAS PARTICIPANTES EM TOLEDO</h2>
                <div class="stores-grid">
                    <div class="store-card">Av. José João Muraro, 717 - Jardim Porto Alegre</div>
                    <div class="store-card">R. Rui Barbosa, 998 - Centro</div>
                </div>
            </div>

            <div class="conditions">
                <h3>CONDIÇÕES DA PROMOÇÃO</h3>
                <ul>
                    <li>Válido somente para compras com nota fiscal</li>
                    <li>Uma peça de picanha por CPF/CNPJ</li>
                    <li>Promoção válida apenas nas lojas de Toledo participantes</li>
                    <li>Não cumulativo com outras promoções</li>
                    <li>Sujeito à disponibilidade de estoque</li>
                </ul>
            </div>

            <div class="validity-banner">
                ⏰ PROMOÇÃO VÁLIDA DE 22 A 27 DE SETEMBRO ⏰
            </div>
        </section>
    </main>

    <script>
        // Animação de entrada suave
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });

        // Efeito parallax suave no scroll
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('.hero');
            if (hero) {
                hero.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });

        // Animação dos elementos flutuantes
        function animateFloatingElements() {
            const elements = document.querySelectorAll('.floating-element');
            elements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.5}s`;
            });
        }

        animateFloatingElements();
    </script>
</body>
</html>