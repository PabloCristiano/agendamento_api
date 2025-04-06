<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [ 
        'razao_social',
        'cnpj',
        'nome_responsavel',
        'telefone',
        'email',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'status',
        'observacao',
    ];
}
