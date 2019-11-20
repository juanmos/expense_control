<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClienteInstitucion;
use App\Models\DatosFacturacion;
use App\Models\FacturaDetalle;
use App\Models\Institucion;
use App\Models\EstadoFactura;
use App\Models\Pago;

class Factura extends Model
{
    use SoftDeletes;
    
    protected $fillable=['datos_facturacion_id','pago_id','estado_id','factura_no','fecha','subtotal',
                        'subtotal0','propina','descuento','servicio','iva','total','clave','autorizacion',
                        'pdf','xml','ambiente','institucion_id','cliente_id','establecimiento','puntoEmision',
                        'secuencia'];
    public function cliente()
    {
        return $this->belongsTo(ClienteInstitucion::class,'cliente_id');
    }
    public function datosFacturacion()
    {
        return $this->belongsTo(DatosFacturacion::class, 'datos_facturacion_id');
    }
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }
    public function estado()
    {
        return $this->belongsTo(EstadoFactura::class, 'estado_id');
    }
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }
    public function detalle()
    {
        return $this->hasMany(FacturaDetalle::class, 'factura_id');
    }

    public function getFacturaNumeroAttribute()
    {
        return "{$this->establecimiento}-{$this->puntoEmision}-{$this->secuencial}";
    }
}
