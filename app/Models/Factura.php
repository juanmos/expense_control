<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DatosFacturacion;
use App\Models\FacturaDetalle;
use App\Models\Institucion;
use App\Models\Estado;
use App\Models\Pago;
class Factura extends Model
{
    protected $fillable=['datos_facturacion_id','pago_id','estado_id','factura_no','fecha','subtotal','subtotal0','propina','descuento','servicio','iva','total','clave','autorizacion','pdf','xml','ambiente','institucion_id'];

    public function datos_facturacion()
    {
        return $this->belongsTo(DatosFacturacion::class, 'datos_facturacion_id');
    }
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }
    public function detalle(){
        return $this->hasMany(FacturaDetalle::class,'factura_id');
    }
}
