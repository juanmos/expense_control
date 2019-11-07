<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TipoRefrigerio;
use App\Models\EstadoInstitucion;
use App\Models\Transaccion;
use App\Models\Configuracion;
use App\Models\MenuRefrigerio;
use App\Models\Ciudad;
use App\Models\User;

class Institucion extends Model
{
    protected $fillable=['nombre','siglas','direccion','telefono','celular','ruc','email','web','facebook','twitter','instagram','estado_id','ciudad_id','latitud','longitud'];

    public function ciudad(){
        return $this->belongsTo(Ciudad::class,'ciudad_id');
    }

    public function estado(){
        return $this->belongsTo(EstadoInstitucion::class,'estado_id');
    }

    public function configuracion(){
        return $this->hasOne(Configuracion::class,'institucion_id');
    }

    public function alumnos(){
        return $this->hasMany(User::class,'institucion_id');
    }

    public function transacciones()
    {
        return $this->morphMany('App\Models\Transaccion', 'transaccionable');
    }

    public function tipo_refrigerio()
    {
        return $this->hasMany(TipoRefrigerio::class, 'institucion_id');
    }

    public function menus(){
        return $this->hasMany(MenuRefrigerio::class,'institucion_id');
    }
}
