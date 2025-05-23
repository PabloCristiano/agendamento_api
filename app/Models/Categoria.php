<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Categoria extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'categoria',
        'empresa_id',
    ];

    public function servicos()
    {
        return $this->hasMany(Servico::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

}
