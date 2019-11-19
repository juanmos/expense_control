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

    protected $fillable=[ 'tipo_transaccion_id','usuario_id','fecha_hora','valor','usuario_crea_id','forma_pago_id','ubicacion','telefono_uuid','transaccionable_id','transaccionable_type','usuario_crea_ip','dispositivo','tarjeta_id','transaccion_id'];
    protected $with =['tipo_transaccion:id,tipo,operacion','forma_pago:id,forma_pago','usuario:id,nombre,apellido,foto,telefono,celular','usuario_crea:id,nombre,apellido,telefono,celular'];
    protected $hidden = [
        'created_at','updated_at'
    ];
    

    public function tipo_transaccion()
    {
        return $this->belongsTo(TipoTransaccion::class, 'tipo_transaccion_id');
    }
    public function forma_pago()
    {
        return $this->belongsTo(FormaPago::class, 'forma_pago_id');
    }
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }
    public function usuario_crea()
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

    public function transaccion_relacionada()
    {
        return $this->belongsTo(Transaccion::class, 'transaccion_id');
    }

    // public function getUsuarioIdAttribute($value) {
    //     return Crypt::decryptString($value);
    // }

    // public function getValorAttribute($value) {
    //     return Crypt::decryptString($value);
    // }

    // public function setUsuarioIdAttribute($value) {
    //     $this->attributes['usuario_id'] = Crypt::encryptString($value);
    // }

    // public function setValorAttribute($value) {
    //     $this->attributes['valor'] = Crypt::encryptString($value);
    // }
}
