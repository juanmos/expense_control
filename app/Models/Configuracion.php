<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $fillable=['institucion_id','establecimiento','punto','secuencial','firma','clave'];
}
