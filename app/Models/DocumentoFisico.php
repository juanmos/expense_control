<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institucion;
use App\Models\CategoriaCompra;
use App\Models\Cliente;

class DocumentoFisico extends Model
{
    use SoftDeletes;
    
    protected $fillable=[
        'institucion_id',
        'documento',
        'fecha',
        'foto',
        'cliente',
        'ruc',
        'subtotal',
        'iva',
        'propina',
        'servicio',
        'total',
        'categoria_id',
        'cliente_id',
        'ret_renta',
        'ret_iva'
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }
    public function categoria()
    {
        return $this->belongsTo(CategoriaCompra::class, 'categoria_id');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
