<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use App\Models\TipoTransaccion;
use App\Models\FormaPago;
use App\Models\Institucion;
use App\Models\Pago;
use App\Models\User;

//use App\Traits\Encryptable;

class Transaccion extends Model
{
    //use Encryptable;

    protected $fillable=[ 'tipo_transaccion_id','usuario_id','fecha_hora','valor','usuario_crea_id',
                        'forma_pago_id','ubicacion','telefono_uuid','transaccionable_id','transaccionable_type',
                        'usuario_crea_ip','dispositivo','tarjeta_id','transaccion_id'];
    protected $with =['tipoTransaccion:id,tipo,operacion','formaPago:id,forma_pago',
                        'usuario:id,nombre,apellido,foto,telefono,celular',
                        'usuarioCrea:id,nombre,apellido,telefono,celular'];
    protected $hidden = [
        'created_at','updated_at'
    ];
    

    public function tipoTransaccion()
    {
        return $this->belongsTo(TipoTransaccion::class, 'tipo_transaccion_id');
    }
    public function formaPago()
    {
        return $this->belongsTo(FormaPago::class, 'forma_pago_id');
    }
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }
    public function usuarioCrea()
    {
        return $this->belongsTo(User::class, 'usuario_crea_id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    public function transaccionable()
    {
        return $this->morphTo();
    }

    public function tarjeta()
    {
        return $this->belongsTo(Tarjeta::class, 'tarjeta_id');
    }

    public function pago()
    {
        return $this->hasOne(Pago::class, 'transanccion_id');
    }

    public function transaccionRelacionada()
    {
        return $this->belongsTo(Transaccion::class, 'transaccion_id');
    }
}
