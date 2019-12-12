<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Ayuda extends Model
{
    use HasTrixRichText;
    
    protected $guarded = [];
}
