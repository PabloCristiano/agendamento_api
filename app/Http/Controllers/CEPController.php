<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CEPController extends Controller
{
    public function findCEP(string $cep)
    {
        $newCep = str_replace("-", "", $cep);
        $response = Http::get("http://viacep.com.br/ws/$newCep/json/")->json();

        if ($response == null) {
            return response()->json([
                'message' => 'CEP inválido ou inexistente.',
            ], 422);
        }

        return response($response);
    }
}
