<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institucion;
use App\Models\Cliente;

class Retencion extends Model
{
    protected $fillable=[
        'institucion_id',
        'cliente_id',
        'fecha',
        'establecimiento',
        'puntoEmision',
        'secuencial',
        'tipoComprobante',
        'codigoTipoDocumento',
        'codigoComprobanteRecibido',
        'claveAcceso',
        'impuestos',
        'sincronizado'
    ];
    protected $casts = [
        'impuestos' => 'array'
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }

    public function cliente()
    {
        return $this->belongsTo(ClienteInstitucion::class, 'cliente_id');
    }

    public function getComprobanteNumeroAttribute()
    {
        return "{$this->establecimiento}-{$this->puntoEmision}-{$this->secuencial}";
    }
}
