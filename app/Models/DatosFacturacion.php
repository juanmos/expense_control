<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DatosFacturacion extends Model
{
    protected $fillable=['usuario_id','nombre','ruc','email','telefono','direccion'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
