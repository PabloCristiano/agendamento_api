<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foz Tintas - Promoções</title>
   
    <link rel="stylesheet" href="{{ asset('css/ft.css') }}?v={{ filemtime(public_path('css/ft.css')) }}">
    @vite(['resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <nav class="navbar" style="position: sticky; top: 0; z-index: 1000;">
        <div class="navbar-container">
            <a href="/app" class="navbar-brand">Promoções Foz Tintas</a>
            
            <ul class="navbar-nav">
                <li><a href="{{ route('vouchers.create') }}">Novo Cadastro de Vouchers</a></li>
                <li><a href="/reimprimir">Reimprimir Vouchers</a></li>
            </ul>
            
            <div class="user-info">
                <p>Bem-vindo, {{ auth()->user()->name }}</p>
                <form method="POST" action="/logout" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">Sair</button>
                </form>
            </div>
        </div>
    </nav>
    
    <div class="container">
        @yield('content')
    </div>    
        
</body>
</html>