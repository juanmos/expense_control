<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TipoRefrigerio;
use App\Models\Institucion;

class Refrigerio extends Model
{
    protected $fillable=['tipo_refrigerio_id','institucion_id','userable','dias'];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }

    public function tipo_refrigerio()
    {
        return $this->belongsTo(TipoRefrigerio::class, 'tipo_refrigerio_id');
    }

    public function userable()
    {
        return $this->morphTo();
    }
}
