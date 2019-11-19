<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institucion;
use App\Models\ClienteInstitucion;
use App\Models\CategoriaCompra;

class Compra extends Model
{
    protected $fillable=['institucion_id','cliente_id','fecha','establecimiento','puntoEmision','secuencial','tipoComprobante','codigoTipoDocumento','codigoComprobanteRecibido','claveAcceso','total','totalSinImpuestos','propina','totalDescuento','impuestos','sincronizado','detalles','categoria_id'];
    protected $casts = [
        'impuestos' => 'array',
        'detalles' => 'array',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }

    public function cliente()
    {
        return $this->belongsTo(ClienteInstitucion::class, 'cliente_id');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaCompra::class, 'categoria_id');
    }

    public function getFacturaNumeroAttribute()
    {
        return "{$this->establecimiento}-{$this->puntoEmision}-{$this->secuencial}";
    }
}
