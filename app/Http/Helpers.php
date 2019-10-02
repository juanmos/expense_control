<?php 
namespace App\Http;

use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Carbon\Carbon;
use Storaga;
use Auth;
use Mail;
use App;

class Helpers{
    public static function creaQR(){
        $usuario =User::find($alumno_id);
        $cryptId=base64_encode($usuario->id);
        $qr=[
            'c'=>$usuario->cedula,
            'n'=>$usuario->full_name,
            'i'=>$cryptId,
            'a'=>$usuario->alumno->ano_lectivo,
            'p'=>$usuario->alumno->curso,
            'v'=>$usuario->tarjeta
        ];
        $usuario->codigo=Crypt::encrypt($qr);
        $usuario->save();
        return true;
    }
}