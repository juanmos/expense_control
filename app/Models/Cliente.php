<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ClienteInstitucion;
use App\Models\CategoriaCompra;

class Cliente extends Model
{
    use SoftDeletes;
    
    protected $fillable=['razon_social','nombre_comercial','ruc','telefono','direccion','usuario_crea_id','categoria_id'];

    public function clienteInstitucion()
    {
        return $this->hasMany(ClienteInstitucion::class, 'cliente_id');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaCompra::class, 'categoria_id');
    }
}
