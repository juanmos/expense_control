<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use App\Traits\Encryptable;
use App\Models\TipoTarjeta;
use App\Models\User;
class Tarjeta extends Model
{
    // use Encryptable;

    protected $fillable=['usuario_id','tipo_tarjeta_id','cupo_mensual','perdida','fecha_solicitud','fecha_emision','fecha_entrega','fecha_vencimiento','fecha_perdida','codigo'];
    // protected $encryptable = [
    //     'usuario_id','tipo_tarjeta_id','cupo_mensual','perdida','fecha_solicitud','fecha_emision','fecha_entrega','fecha_vencimiento','fecha_perdida'
    // ];
    // protected $casts = ['extended_data' => 'array'];

    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id');
    }

    public function tipo_tarjeta(){
        return $this->belongsTo(TipoTarjeta::class,'tipo_tarjeta_id');
    }
}
