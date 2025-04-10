<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Empresa extends Model
{
    use HasFactory;

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

    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }

    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }

    public function categorias()
    {
        return $this->hasMany(Categoria::class);
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}
