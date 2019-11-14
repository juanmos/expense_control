<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institucion;

class CategoriaProducto extends Model
{
    protected $fillable=['institucion_id','categoria','descripcion','icono'];

    public function institucion(){
        return $this->belongsTo(Institucion::class,'institucion_id');
    }
}
