<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cargo extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'cargo',
        'empresa_id',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
