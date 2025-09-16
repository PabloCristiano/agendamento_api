<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\VendasVoucherController;

class VoucherController extends Controller
{
    protected $vendasVoucherController;
    
    public function __construct()
    {
        $this->vendasVoucherController = new VendasVoucherController();
    }

    public function store(Request $request)
    {

        // Normaliza CPF/CNPJ (só dígitos)
        $cpfCnpjRaw = preg_replace('/\D/', '', (string) $request->input('cpfCnpj'));

        $validated = $request->validate([
            'numeroNota'   => ['required','string','max:30'],
            'nomeCompleto' => ['required','string','min:3','max:150'],
            'cpfCnpj'      => ['required','string', function($attr,$value,$fail) use ($cpfCnpjRaw) {
            if (!in_array(strlen($cpfCnpjRaw), [11,14])) {
                $fail('CPF/CNPJ inválido.');
                return;
            }
            // (Opcional) Validação algorítmica de CPF/CNPJ pode ser adicionada aqui
            }],
            'loja'         => ['required', Rule::in(['loja007','loja011'])],
        ],[
            'numeroNota.unique' => 'Esta nota já gerou um voucher.',
        ]);

        // Verifica se a nota já foi cadastrada
        if (Voucher::where('numero_nota', $validated['numeroNota'])->exists()) {
            return response()->json([
            'ok' => false,
            'message' => 'Esta nota já gerou um voucher.'
            ], 422);
        }

        // Verifica se o CPF/CNPJ já foi cadastrado
        if (Voucher::where('cpf_cnpj', $cpfCnpjRaw)->exists()) {
            return response()->json([
            'ok' => false,
            'message' => 'Este CPF/CNPJ já possui um voucher.'
            ], 422);
        }

        $voucherCode = $this->gerarCodigoVoucher($validated['numeroNota']);

        $voucher = null;
        DB::transaction(function () use (&$voucher, $validated, $cpfCnpjRaw, $voucherCode) {
            $voucher = Voucher::create([
            'numero_nota' => $validated['numeroNota'],
            'nome_completo' => $validated['nomeCompleto'],
            'cpf_cnpj' => $cpfCnpjRaw,
            'loja' => $validated['loja'],
            'voucher_code' => $voucherCode,
            'gerado_em' => now(),
            ]);
        });

        // Resposta pensada para “preencher” o seu front
        return response()->json([
            'ok' => true,
            'voucherNumber' => $voucher->voucher_code,
            'dados' => [
            'cliente' => $voucher->nome_completo,
            'cpf'     => $this->formatarCpfCnpj($voucher->cpf_cnpj),
            'numeroNota' => $voucher->numero_nota,
            'data'    => optional($voucher->gerado_em)->format('d/m/Y H:i'),
            'loja'    => $this->nomeLoja($voucher->loja),
            ]
        ], 201);
    }

    private function gerarCodigoVoucher(string $numeroNota): string
    {
        // Assegura que a nota existe em vendas_voucher (opcional)
        // $nota_nf = $this->vendasVoucherController->porNumero($numeroNota);            
        // Gera algo tipo: FOZTINTAS-12345-7G8H
        $sufixo = strtoupper(Str::random(4));
        $code = "FOZTINTAS-{$numeroNota}-{$sufixo}";

        // Garante unicidade
        while (Voucher::where('voucher_code', $code)->exists()) {
            $sufixo = strtoupper(Str::random(4));
            $code = "FOZTINTAS-{$numeroNota}-{$sufixo}";
        }
        return $code;
    }

    private function formatarCpfCnpj(string $digits): string
    {
        if (strlen($digits) === 11) {
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $digits);
        }
        if (strlen($digits) === 14) {
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $digits);
        }
        return $digits;
    }

    private function nomeLoja(string $codigo): string
    {
        return match ($codigo) {
            'loja007' => 'Av. José João Muraro, 717 - Jardim Porto Alegre - Loja 007',
            'loja011' => 'R. Rui Barbosa, 998 - Centro - Loja 011',
            default   => $codigo,
        };
    }

    public function reimprimir(Request $request)
    {
       
        
        $validated = $request->validate([
            'numeroNota' => ['required', 'string', 'max:30'],
            'cpfCnpj'    => ['required', 'string'],
        ]);

        $cpfCnpjRaw = preg_replace('/\D/', '', (string) $validated['cpfCnpj']);

        $voucher = Voucher::where('numero_nota', $validated['numeroNota'])
            ->where('cpf_cnpj', $cpfCnpjRaw)
            ->first();

        if (!$voucher) {
            return response()->json([
                'ok' => false,
                'message' => 'Voucher não encontrado para os dados informados.'
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'voucherNumber' => $voucher->voucher_code,
            'dados' => [
                'cliente' => $voucher->nome_completo,
                'cpf'     => $this->formatarCpfCnpj($voucher->cpf_cnpj),
                'numeroNota' => $voucher->numero_nota,
                'data'    => optional($voucher->gerado_em)->format('d/m/Y H:i'),
                'loja'    => $this->nomeLoja($voucher->loja),
            ]
        ]);
    }

    public function totalVouchers()
    {
        $total = Voucher::count();
        return $total;
        // return response()->json([
        //     'ok' => true,
        //     'total' => $total
        // ]);
    }

    public function totalLoja007()
    {
        $total = Voucher::where('loja', 'loja007')->count();
        return $total;
        // return response()->json([
        //     'loja007' => $total,
        // ]);
    }

    public function totalLoja011()
    {
        $total = Voucher::where('loja', 'loja011')->count();
        return $total;
        // return response()->json([
        //     'loja011' => $total,
        // ]);
    }



}
