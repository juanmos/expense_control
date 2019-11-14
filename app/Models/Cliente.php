<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable=['razon_social','ruc','telefono','direccion'];
}
