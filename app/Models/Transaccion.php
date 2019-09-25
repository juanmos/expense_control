<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $fillable=[ 'tipo','usuario_id','fecha_hora','valor','usuario_crea_id','forma_pago'];
}
