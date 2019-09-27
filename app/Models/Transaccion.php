<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TipoTransaccion;
use App\Models\FormaPago;
use App\Models\Institucion;
use App\Models\User;

class Transaccion extends Model
{
    protected $fillable=[ 'tipo_transaccion_id','usuario_id','fecha_hora','valor','usuario_crea_id','forma_pago_id','institucion_id'];
    protected $with =['tipo_transaccion:id,tipo,operacion','forma_pago:id,forma_pago','usuario:id,nombre,apellido,foto,telefono,celular','usuario_crea:id,nombre,apellido,telefono,celular'];
    protected $hidden = [
        'created_at','updated_at'
    ];

    public function tipo_transaccion(){
        return $this->belongsTo(TipoTransaccion::class,'tipo_transaccion_id');
    }
    public function forma_pago(){
        return $this->belongsTo(FormaPago::class,'forma_pago_id');
    }
    public function institucion(){
        return $this->belongsTo(Institucion::class,'institucion_id');
    }
    public function usuario_crea(){
        return $this->belongsTo(User::class,'usuario_crea_id');
    }
    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id');
    }
}
