<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institucion;

class TipoInstitucion extends Model
{
    protected $fillable=['tipo'];
    public $timestamps = false;
    
    public function instituciones()
    {
        return $this->hasMany(Institucion::class, 'tipo_institucion_id');
    }
}
