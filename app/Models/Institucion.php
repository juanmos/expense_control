<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EstadoInstitucion;
use App\Models\Ciudad;

class Institucion extends Model
{
    protected $fillable=['nombre','siglas','direccion','telefono','celular','ruc','email','web','facebook','twitter','instagram','estado_id','ciudad_id','latitud','longitud'];

    public function ciudad(){
        return $this->belongsTo(Ciudad::class,'ciudad_id');
    }

    public function estado(){
        return $this->belongsTo(EstadoInstitucion::class,'estado_id');
    }
}
