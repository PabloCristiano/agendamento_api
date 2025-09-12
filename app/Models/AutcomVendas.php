<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class AutcomVendas extends Model
{
    use HasFactory;

    protected $table = 'autcom_vendas';

    protected $fillable = [
        // Campos MOVDET
        'det_codemp',
        'det_codven',
        'det_codite',
        'det_codmar',
        'det_codcli',
        'det_numdoc',
        'det_espdoc',
        'det_serie_',
        'det_dtaent',
        'det_horent',
        'det_dtadoc',
        'det_conpag',
        'det_tip_fc',
        'det_estado',
        'det_descri',
        'det_qtdite',
        'det_totite',
        
        // Campos CADCLI
        'cli_codcli',
        'cli_codati',
        'cli_nomcli',
        'cli_cgccpf',
        'cli_c_g_c_',
        'cli_i_e_s_',
        'cli_iesuni',
        'cli_fone01',
        'cli_status',
        'cli_consum',
        'cli_limcre',
        'cli_ultalt',
        'cli_vrucom',
        'cli_ultcom',
        'cli_celula',
        'cli_qtdeti',
        'cli_dtmcom',
        'cli_vrmcom',
        'cli_domcom',
        'cli_doucom',
        'cli_sufram',
        'cli_permmi',
        'cli_permff',
        'cli_atrmax',
        'cli_crdfis',
        'cli_eminfe',
        'cli_capsoc',
        
        // Campos CADITE
        'ite_ultalt',
        
        // Campos CADFOR
        'fornecedor',
        'for_nomfan',
        'for_codfor',
        
        // Campo calculado
        'valor_total',
    ];

    protected $casts = [
        'det_dtaent' => 'date',
        'det_horent' => 'datetime:H:i:s',
        'det_dtadoc' => 'date',
        'det_qtdite' => 'decimal:4',
        'det_totite' => 'decimal:2',
        'cli_limcre' => 'decimal:2',
        'cli_ultalt' => 'date',
        'cli_vrucom' => 'decimal:2',
        'cli_ultcom' => 'date',
        'cli_dtmcom' => 'date',
        'cli_vrmcom' => 'decimal:2',
        'cli_permmi' => 'decimal:2',
        'cli_permff' => 'decimal:2',
        'cli_crdfis' => 'decimal:2',
        'cli_capsoc' => 'decimal:2',
        'ite_ultalt' => 'date',
        'valor_total' => 'decimal:2',
    ];

    /**
     * Accessor para formatar o valor total
     */
    protected function valorTotal(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 2, ',', '.'),
        );
    }

    /**
     * Accessor para formatar CNPJ/CPF
     */
    protected function cliCgccpf(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (strlen($value) == 11) {
                    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $value);
                } elseif (strlen($value) == 14) {
                    return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $value);
                }
                return $value;
            }
        );
    }

    /**
     * Scope para filtrar por empresa
     */
    public function scopePorEmpresa($query, $codigoEmpresa)
    {
        return $query->where('det_codemp', $codigoEmpresa);
    }

    /**
     * Scope para filtrar por período
     */
    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('det_dtadoc', [$dataInicio, $dataFim]);
    }

    /**
     * Scope para filtrar por vendedor
     */
    public function scopePorVendedor($query, $codigoVendedor)
    {
        return $query->where('det_codven', $codigoVendedor);
    }

    /**
     * Scope para filtrar por cliente
     */
    public function scopePorCliente($query, $codigoCliente)
    {
        return $query->where('det_codcli', $codigoCliente);
    }

    /**
     * Scope para excluir bonificações
     */
    public function scopeSemBonificacao($query)
    {
        return $query->where('det_espdoc', '!=', 'BR');
    }

    /**
     * Relacionamento com outras tabelas (se existirem)
     */
    
    // public function cliente()
    // {
    //     return $this->belongsTo(Cliente::class, 'cli_codcli', 'codigo');
    // }
    
    // public function vendedor()
    // {
    //     return $this->belongsTo(Vendedor::class, 'det_codven', 'codigo');
    // }
    
    // public function item()
    // {
    //     return $this->belongsTo(Item::class, 'det_codite', 'codigo');
    // }
    
    // public function fornecedor()
    // {
    //     return $this->belongsTo(Fornecedor::class, 'for_codfor', 'codigo');
    // }
}