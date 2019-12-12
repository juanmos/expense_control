<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institucion;

class TipoPlan extends Model
{
    public $timestamps = false;
    protected $fillable=['tipo','valor'];

    public function institucion()
    {
        return $this->hasMany(Institucion::class, 'tipo_plan_id');
    }
}
