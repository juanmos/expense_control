<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institucion;
use App\Models\Cliente;

class ClienteInstitucion extends Model
{
    use SoftDeletes;
    use Notifiable;
    
    protected $fillable=['institucion_id','cliente_id','nombre','apellido','telefono','email','email_facturacion'];

    
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
