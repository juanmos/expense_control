<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ClienteInstitucion;

class Cliente extends Model
{
    use SoftDeletes;
    
    protected $fillable=['razon_social','ruc','telefono','direccion','usuario_crea_id'];

    public function clienteInstitucion()
    {
        return $this->hasMany(ClienteInstitucion::class, 'cliente_id');
    }
}
