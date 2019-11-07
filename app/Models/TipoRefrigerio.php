<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\MenuRefrigerio;
use App\Models\Institucion;

class TipoRefrigerio extends Model
{
    use SoftDeletes;
    protected $fillable=['institucion_id','tipo','descripcion','costo','forma_pago'];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }

    public function menus(){
        return $this->hasMany(MenuRefrigerio::class,'tipo_refrigerio_id');
    }
}
