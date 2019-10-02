<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoTarjeta extends Model
{
    public $timestamps = false;
    protected $fillable=['tipo_tarjeta'];
}
