<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    protected $fillable=['forma_pago','habilitado'];

    protected $hidden = [
        'habilitado', 'created_at','updated_at'
    ];
}
