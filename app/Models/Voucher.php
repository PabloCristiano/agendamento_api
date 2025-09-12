<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'numero_nota',
        'nome_completo',
        'cpf_cnpj',
        'loja',
        'voucher_code',
        'gerado_em',
    ];

    protected $casts = [
        'gerado_em' => 'datetime',
    ];
}
