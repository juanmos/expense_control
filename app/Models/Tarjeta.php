<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TipoTarjeta;
use App\Models\Transaccion;
use App\Models\User;

class Tarjeta extends Model
{
    use SoftDeletes;
    // use Encryptable;

    protected $fillable=['usuario_id','tipo_tarjeta_id','cupo_mensual','perdida','fecha_solicitud','fecha_emision','fecha_entrega','fecha_vencimiento','fecha_perdida','codigo','usuario_crea_id','estado'];
    // protected $encryptable = [
    //     'usuario_id','tipo_tarjeta_id','cupo_mensual','perdida','fecha_solicitud','fecha_emision','fecha_entrega','fecha_vencimiento','fecha_perdida'
    // ];
    // protected $casts = ['extended_data' => 'array'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function tipo_tarjeta()
    {
        return $this->belongsTo(TipoTarjeta::class, 'tipo_tarjeta_id');
    }

    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'tarjeta_id');
    }
}
