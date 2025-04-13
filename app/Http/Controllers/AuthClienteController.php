<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cliente;

class AuthClienteController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'cpf' => 'required|string|unique:clientes,cpf',
            'data_nascimento' => 'required|date',
            'whatsapp' => 'required|string',
            'telefone' => 'required|string',
            'email' => 'required|email|unique:clientes,email',
            'password' => 'required|string|min:6',
        ]);

        $cliente = Cliente::create([
            'name' => $request->name,
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento,
            'whatsapp' => $request->whatsapp,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Cliente registrado com sucesso', 'cliente' => $cliente]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('cliente')->attempt($credentials)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(Auth::guard('cliente')->user());
    }

    public function logout()
    {
        Auth::guard('cliente')->logout();
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('cliente')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('cliente')->factory()->getTTL() * 60
        ]);
    }
}
