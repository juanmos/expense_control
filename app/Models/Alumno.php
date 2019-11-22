<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Alumno extends Model
{
    use SoftDeletes;

    protected $fillable=['ano_lectivo','curso','usuario_id','profesor'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
