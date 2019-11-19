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

class Helpers
{
    public static function creaQR($usuario_id, $tarjeta_id)
    {
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
        // return Crypt::encrypt(json_encode(compact('qr')),false);;
    }

    public static function modulo($clave)
    {
        $digits = str_split($clave);
        $suma = 0;
        $num = 7;
        foreach ($digits as $d) {
            $suma+= ($d*$num);
            $num=$num-1;
            if ($num<2) {
                $num=7;
            }
        }
        $m = $suma % 11;
        if ($m==11) {
            return 0;
        } elseif ($m==10) {
            return 1;
        } elseif ($m==0) {
            return 0;
        } elseif ($m==1) {
            return 1;
        } else {
            return 11 - $m;
        }
    }

    public static function obtieneTipoDoc($numero)
    {
        if ($numero == '9999999999999') {
            return '07';
        } elseif (strlen($numero) == 10) {
            return '05';
        } elseif (strlen($numero) ==13) {
            return '04';
        } else {
            return '06';
        }
    }
    public static function normaliza($cadena)
    {

        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
    ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
    bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = utf8_decode($cadena);
        $cadena = str_ireplace(' ', '', $cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        return utf8_encode($cadena);
    }

    public static function validaTarjeta()
    {
    }
}
