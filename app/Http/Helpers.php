<?php
namespace App\Http;

use Illuminate\Support\Facades\Crypt;
use App\Models\Tarjeta;
use App\Models\Cliente;
use App\Models\User;
use Carbon\Carbon;
use SoapClient;
use Storage;
use Auth;
use Mail;
use App;

class Helpers
{
    public static function clasifica($cliente)
    {
        $alimientacion=[];
        $vivienda=[];
        $salud=[];
        $gasolina=['ESTACION DE SERVICIO','PRIMAX','GASOLINERA'];
        $dirversion=[];
        $vestimenta=[];
        $vivienda=[];
        $arte=[];
    }

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

    public static function obtenereComprasSRI($compra)
    {
        $urlAutorizacion = 'https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl';
        $options = [
                'trace' => true,
                'cache_wsdl' => WSDL_CACHE_NONE
            ];

        $autorizacion = new SoapClient($urlAutorizacion, $options);
        $respAut = $autorizacion->autorizacionComprobante(['claveAccesoComprobante'=>$compra->claveAcceso]);
        if (is_soap_fault($respAut)) {
            print_r("SOAP Fault: (faultcode: {$respAut->faultcode}, faultstring: {$respAut->faultstring})");
        }
        if (
                $respAut->RespuestaAutorizacionComprobante->numeroComprobantes>0 &&
                $respAut->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado=='AUTORIZADO'
            ) {
            $comprobante=$respAut->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->comprobante;
            $xml = simplexml_load_string($comprobante, "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $array = json_decode($json, true);

            $cliente=Cliente::where('ruc', $array['infoTributaria']['ruc'])->first();
            if (strlen($array['infoTributaria']['dirMatriz'])>0) {
                $cliente->direccion=(strlen($array['infoTributaria']['dirMatriz'])>191)?substr($array['infoTributaria']['dirMatriz'], 0, 190):$array['infoTributaria']['dirMatriz'];
                $cliente->save();
            }

            $compra->detalles=$array['detalles'];
            $compra->sincronizado=1;
            $iva=array_reduce($array['infoFactura']['totalConImpuestos'], function ($carry, $item) {
                if (count($item) == count($item, COUNT_RECURSIVE)) {
                    $carry += $item['valor'];
                } else {
                    foreach ($item as $it) {
                        $carry+= $it['valor'];
                    }
                }
                return $carry;
            });
            $json=array(
                    "template"=>array("shortid" => "EkRZMhojP"),
                    "data"=>array(
                        "facturaNo"=> $compra->factura_numero,
                        "autorizacion"=>$compra->claveAcceso,
                        "clave"=>$compra->claveAcceso,
                        "razonSocial"=>$array['infoTributaria']['razonSocial'],
                        "rucVendedor"=>$array['infoTributaria']['ruc'],
                        "direccion"=>$array['infoTributaria']['dirMatriz'],
                        // "telefono"=>$configuraciones['telefono_facturacion'],
                        "fechaAut"=>Carbon::parse($compra->fecha)->format("d/m/Y H:m:s"),
                        "fecha"=>Carbon::parse($compra->fecha)->format("d/m/Y"),
                        "ambiente"=>'Produccion',
                        "emision"=>"NORMAL",
                        "comprador"=> $array['infoFactura']['razonSocialComprador'],
                        "ruc"=> $array['infoFactura']['identificacionComprador'],
                        "items" => $array['detalles'],
                        "subtotal"=>$array['infoFactura']['totalSinImpuestos'],
                        "iva"=>$iva,
                        "propina"=>array_key_exists('propina', $array['infoFactura']),
                        "total"=>$array['infoFactura']['importeTotal'],
                        // "imagen"=>$urlImg
                    ),
                    "options"=>array('timeout'=>60000)

                );

            $url = "https://facturas.doctopro.com/api/report";

            /*Convierte el array en el formato adecuado para cURL*/

            $handler = curl_init();
            curl_setopt($handler, CURLOPT_URL, $url);
            curl_setopt($handler, CURLOPT_POST, true);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($json));
            curl_setopt($handler, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            curl_setopt($handler, CURLOPT_VERBOSE, false);
            $response = curl_exec($handler);
            $ride='pdf/'.$compra->institucion_id.'/Compras/'. $compra->claveAcceso.'.pdf';
            Storage::put($ride, $response);
            curl_close($handler);
            $compra->pdf=$ride;
            $compra->save();
        } else {
            $compra->sincronizado=2;
            $compra->save();
        }
        return true;
    }
}
