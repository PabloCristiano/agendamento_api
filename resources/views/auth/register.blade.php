<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Sistema de Vouchers</title>
    <style>
        /* Mesmo CSS do login com pequenas adaptações */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: #372FA4;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .register-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            transform: translateY(-20px);
            animation: slideIn 0.6s ease-out forwards;
        }
        
        @keyframes slideIn {
            to {
                transform: translateY(0);
            }
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .logo p {
            color: #666;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-group input.error {
            border-color: #e74c3c;
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .register-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        
        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e1e8ed;
        }
        
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <h1>Cadastro</h1>
            <p>Crie sua conta para acessar o sistema</p>
        </div>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <label for="name">Nome</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    autofocus
                    class="{{ $errors->has('name') ? 'error' : '' }}"
                >
                @if($errors->has('name'))
                    <div class="error-message">{{ $errors->first('name') }}</div>
                @endif
            </div>
            
            <div class="form-group">
                <label for="email">E-mail</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                    class="{{ $errors->has('email') ? 'error' : '' }}"
                >
                @if($errors->has('email'))
                    <div class="error-message">{{ $errors->first('email') }}</div>
                @endif
            </div>
            
            <div class="form-group">
                <label for="password">Senha</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    class="{{ $errors->has('password') ? 'error' : '' }}"
                >
                @if($errors->has('password'))
                    <div class="error-message">{{ $errors->first('password') }}</div>
                @endif
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Confirmar Senha</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    required
                >
            </div>
            
            <button type="submit" class="register-btn">Cadastrar</button>
        </form>
        
        <div class="login-link">
            <p>Já tem uma conta? <a href="/login">Faça login aqui</a></p>
        </div>
    </div>
</body>
</html>
