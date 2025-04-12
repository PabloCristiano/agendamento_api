<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'hora_atendimento',
        'data_atendimento',
        'cliente_id',
        'usuario_id',
        'empresa_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Profissional::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function servicos()
    {
        return $this->belongsToMany(Servico::class, 'servico_agendamento');
    }
}
