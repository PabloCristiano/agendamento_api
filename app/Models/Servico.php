<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $table = 'servicos';
    protected $fillable = ['servico', 'tempo', 'valor', 'comissao','id_categoria'];
}
