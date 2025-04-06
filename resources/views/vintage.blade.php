<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vintage Code - Apresentação</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
        
        body {
            background-color: black;
            color: #33ff33;
            font-family: 'Press Start 2P', cursive;
            text-align: center;
            margin: 0;
            overflow: hidden;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .logo {
            font-size: 2em;
            animation: glitch 1.5s infinite alternate;
        }
        .loading {
            font-size: 1em;
            margin-top: 20px;
            animation: blink 1s infinite;
        }
        @keyframes blink {
            50% { opacity: 0; }
        }
        @keyframes glitch {
            0% { transform: skewX(0deg); }
            20% { transform: skewX(-5deg); }
            40% { transform: skewX(5deg); }
            60% { transform: skewX(-5deg); }
            80% { transform: skewX(5deg); }
            100% { transform: skewX(0deg); }
        }
        .carousel {
            position: relative;
            width: 80%;
            max-width: 600px;
            margin: auto;
            overflow: hidden;
        }
        .carousel-images {
            display: flex;
            width: 300%;
            transition: transform 0.5s ease-in-out;
        }
        .carousel-images img {
            width: 100%;
            height: auto;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            position: absolute;
            top: 50%;
            width: 100%;
            transform: translateY(-50%);
        }
        .buttons button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">Vintage Code - O Passado Encontra o Futuro !!!</div>
        <!-- <div class="logo">VINTAGE CODE</div> -->
        <div class="loading">> Loading...</div>
    </div>
    <div class="carousel">
        <div class="carousel-images">
            <img src="frame1.png" alt="Nova Tendência no Mercado">
            <img src="frame2.png" alt="O Velho Bem Feito com Novas Tecnologias">
            <img src="frame3.png" alt="Vintage Code - O Passado Encontra o Futuro">
        </div>
        <div class="buttons">
            <button onclick="prevSlide()">&#10094;</button>
            <button onclick="nextSlide()">&#10095;</button>
        </div>
    </div>
    <script>
        let index = 0;
        function showSlide(n) {
            const slides = document.querySelector('.carousel-images');
            const totalSlides = document.querySelectorAll('.carousel-images img').length;
            if (n >= totalSlides) { index = 0; }
            else if (n < 0) { index = totalSlides - 1; }
            else { index = n; }
            slides.style.transform = `translateX(-${index * 100}%)`;
        }
        function nextSlide() { showSlide(index + 1); }
        function prevSlide() { showSlide(index - 1); }
    </script>
</body>
</html>