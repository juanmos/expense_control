<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaccion;
use App\Models\Refrigerio;
use App\Models\Factura;

class Pago extends Model
{
    protected $fillable=['transanccion_id','refrigerio_id','mes_pago','detalle','comprobante'];

    public function transaccion()
    {
        return $this->belongsTo(Transaccion::class, 'transanccion_id');
    }
    public function refrigerio()
    {
        return $this->belongsTo(Refrigerio::class, 'refrigerio_id');
    }
    public function factura()
    {
        return $this->hasOne(Factura::class, 'pago_id');
    }
}
