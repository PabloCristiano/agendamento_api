<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VendasVoucher extends Model
{
    protected $table = 'vendas_voucher';
    public $timestamps = false;

    // Não há ID auto-increment — usamos chave composta (EMPRESA, NUM_DOC, COD_ITEM)
    public $incrementing = false;

    protected $fillable = [
        'EMPRESA','NUM_DOC','ESP_DOC','SERIE','DATA','HORA',
        'COD_ITEM','DESCRICAO_ITEM','UNIDADE','QTD','PRECO_UNIT','TOTAL_BRUTO','VALOR_LIQUIDO',
        'CLIENTE','CPF_CNPJ','CPF_CNPJ_FORMATADO',
        'COD_FORNECEDOR','FORNECEDOR','FORNECEDOR_FANTASIA',
    ];

    protected $casts = [
        'DATA'          => 'date',
        'HORA'          => 'string',     // TIME -> deixe como string
        'QTD'           => 'decimal:4',
        'PRECO_UNIT'    => 'decimal:4',
        'TOTAL_BRUTO'   => 'decimal:2',
        'VALOR_LIQUIDO' => 'decimal:2',
    ];

    /* Scopes úteis */
    public function scopeEmpresa(Builder $q, $empresa): Builder
    {
        return $q->where('EMPRESA', $empresa);
    }

    public function scopeNumDoc(Builder $q, $num): Builder
    {
        return $q->where('NUM_DOC', $num);
    }

    public function scopePeriodo(Builder $q, $ini, $fim): Builder
    {
        if ($ini) $q->whereDate('DATA', '>=', $ini);
        if ($fim) $q->whereDate('DATA', '<=', $fim);
        return $q;
    }

    public function scopeClienteContem(Builder $q, $nome): Builder
    {
        return $q->where('CLIENTE', 'like', '%'.$nome.'%');
    }

    public function scopeCpfCnpj(Builder $q, $doc): Builder
    {
        return $q->where('CPF_CNPJ', $doc);
    }

    public function scopeFornecedorContem(Builder $q, $nome): Builder
    {
        return $q->where('FORNECEDOR', 'like', '%'.$nome.'%');
    }

    /* (Opcional) permitir update com chave composta se usar $model->save() */
    protected function setKeysForSaveQuery($query)
    {
        return $query->where('EMPRESA', $this->getAttribute('EMPRESA'))
                     ->where('NUM_DOC', $this->getAttribute('NUM_DOC'))
                     ->where('COD_ITEM', $this->getAttribute('COD_ITEM'));
    }
}
