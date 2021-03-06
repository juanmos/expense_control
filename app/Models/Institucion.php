<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\ClienteInstitucion;
use App\Models\TipoInstitucion;
use App\Models\TipoRefrigerio;
use App\Models\EstadoInstitucion;
use App\Models\Transaccion;
use App\Models\Configuracion;
use App\Models\MenuRefrigerio;
use App\Models\DocumentoFisico;
use App\Models\TipoPlan;
use App\Models\Factura;
use App\Models\Ciudad;
use App\Models\Compra;
use App\Models\Retencion;
use App\Models\User;

class Institucion extends Model
{
    use SoftDeletes;
    use Notifiable;
    
    protected $fillable=[
        'nombre','siglas','direccion','telefono','celular','ruc','email','web','facebook',
        'twitter','instagram','estado_id','ciudad_id','latitud','longitud','tipo_institucion_id',
        'tipo_plan_id'
    ];

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoInstitucion::class, 'estado_id');
    }

    public function configuracion()
    {
        return $this->hasOne(Configuracion::class, 'institucion_id');
    }

    public function alumnos()
    {
        return $this->hasMany(User::class, 'institucion_id');
    }

    public function transacciones()
    {
        return $this->morphMany('App\Models\Transaccion', 'transaccionable');
    }

    public function tipoRefrigerio()
    {
        return $this->hasMany(TipoRefrigerio::class, 'institucion_id');
    }

    public function menus()
    {
        return $this->hasMany(MenuRefrigerio::class, 'institucion_id');
    }

    public function tipoInstitucion()
    {
        return $this->belongsTo(TipoInstitucion::class, 'tipo_institucion_id');
    }

    public function clientes()
    {
        return $this->hasMany(ClienteInstitucion::class, 'institucion_id');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'institucion_id');
    }

    public function retenciones()
    {
        return $this->hasMany(Retencion::class, 'institucion_id');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'institucion_id');
    }

    public function tipoPlan()
    {
        return $this->belongsTo(TipoPlan::class, 'tipo_plan_id');
    }

    public function documentos()
    {
        return $this->hasMany(DocumentoFisico::class, 'institucion_id');
    }
}
