<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Factura;

class FacturaDetalle extends Model
{
    use SoftDeletes;
    
    protected $fillable=['factura_id','codigo','descripcion','cantidad','precio_unitario','descuento','iva','precio'];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }
}
