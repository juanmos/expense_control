<?php 
namespace App\Http;

use Illuminate\Support\Facades\Crypt;
use App\Models\Tarjeta;
use App\Models\User;
use Carbon\Carbon;
use Storaga;
use Auth;
use Mail;
use App;

class Helpers{
    public static function creaQR($usuario_id,$tarjeta_id){
        $usuario =User::find($usuario_id);
        $tarjeta=Tarjeta::find($tarjeta_id);
        $cryptId=base64_encode($usuario->id);
        $qr=[
            'c'=>$usuario->cedula,
            'n'=>$usuario->full_name,
            'i'=>$cryptId,
            'a'=>$usuario->alumno->ano_lectivo,
            'p'=>$usuario->alumno->curso,
            //'v'=>Carbon::parse($tarjeta->fecha_vencimiento)->toDateString(),
            'ti'=>base64_encode($tarjeta_id)
        ];
        return base64_encode(gzcompress(json_encode(compact('qr')), 9)) ;
        return Crypt::encrypt(json_encode(compact('qr')),false);;
    }

    public static function validaTarjeta(){
        
    }
}