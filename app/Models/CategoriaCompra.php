<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Compra;

class CategoriaCompra extends Model
{
    protected $fillable =['categoria'];

    public function compras(){
        return $this->hasMany(Compra::class,'categoria_id');
    }
}
