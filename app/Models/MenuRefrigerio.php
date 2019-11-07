<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institucion;
use App\Models\TipoRefrigerio;

class MenuRefrigerio extends Model
{
    protected $fillable=['institucion_id','tipo_refrigerio_id','fecha','titulo','descripcion','foto','tabla_nutricional'];

    public function tipo_refrigerio(){
        return $this->belongsTo(TipoRefrigerio::class,'tipo_refrigerio_id');
    }

    public function institucion(){
        return $this->belongsTo(Institucion::class,'institucion_id');
    }
}
