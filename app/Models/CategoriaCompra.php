<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DocumentoFisico;
use App\Models\Cliente;
use App\Models\Compra;

class CategoriaCompra extends Model
{
    public $timestamps = false;
    protected $fillable =['categoria','icono','color'];

    public function compras()
    {
        return $this->hasMany(Compra::class, 'categoria_id');
    }

    public function cliente()
    {
        return $this->hasMany(Cliente::class, 'categoria_id');
    }

    public function documentos()
    {
        return $this->hasMany(DocumentoFisico::class,'categoria_id');
    }
}
