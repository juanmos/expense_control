<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use App\Models\TipoTransaccion;
use App\Models\FormaPago;
use App\Models\Institucion;
use App\Models\User;
use App\Traits\Encryptable;

class Transaccion extends Model
{
    use Encryptable;

    protected $fillable=[ 'tipo_transaccion_id','usuario_id','fecha_hora','valor','usuario_crea_id','forma_pago_id','ubicacion','telefono_uuid','transaccionable_id','transaccionable_type','usuario_crea_ip'];
    protected $with =['tipo_transaccion:id,tipo,operacion','forma_pago:id,forma_pago','usuario:id,nombre,apellido,foto,telefono,celular','usuario_crea:id,nombre,apellido,telefono,celular'];
    protected $hidden = [
        'created_at','updated_at'
    ];
    protected $encryptable = [
        'usuario_id','fecha_hora','valor','usuario_crea_id','forma_pago_id','ubicacion','telefono_uuid','usuario_crea_ip','tipo_transaccion_id'
        // ,'transaccionable_id'
        // ,'transaccionable_type'
    ];
    // protected $casts = [
    //     'fecha_hora' => 'datetime:Y-m-d H:i:s',
    //     'valor'=>'decimal:10',
    //     'usuario_id'=>'integer',
    //     'usuario_crea_id'=>'integer',
    //     'forma_pago_id'=>'integer',
    //     'tipo_transaccion_id'=>'integer',
    //     // 'transaccionable_id'=>'integer',
    // ];

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
    public function transaccionable()
    {
        return $this->morphTo();
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
