<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TipoRefrigerio;
use App\Models\Institucion;
use App\Models\Pago;

class Refrigerio extends Model
{
    use SoftDeletes;
    protected $fillable=['tipo_refrigerio_id','institucion_id','userable_id','userable_type','dias',
                        'costo','activo','fecha_inicio','fecha_fin'];
    protected $casts = [
        'dias' => 'array',
    ];
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }

    public function tipoRefrigerio()
    {
        return $this->belongsTo(TipoRefrigerio::class, 'tipo_refrigerio_id');
    }

    public function userable()
    {
        return $this->morphTo();
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'refrigerio_id');
    }
}
