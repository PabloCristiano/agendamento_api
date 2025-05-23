<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'data_nascimento',
        'whatsapp',
        'telefone',
        'email',
    ];

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}
