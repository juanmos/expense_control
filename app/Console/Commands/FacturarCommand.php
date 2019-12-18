<?php

namespace App\Console\Commands;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Console\Command;
use App\Notifications\EnviarFacturaNotification;
use App\Models\Factura;
use App\Http\Helpers;
use Carbon\Carbon;
use App\Models\Configuracion;
use Notification;
use SoapClient;
use DateTime;
use Session;
use Storage;
use Crypt;
use Auth;

class FacturarCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sri:facturar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Facturacion del SRI';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
 
        $facturas = Factura::whereIn('estado_id', [1,6,7])
                    ->with(['institucion.configuracion','cliente.cliente','detalle'])
                    ->get();
        foreach ($facturas as $factura) {
            $urlEnvio='https://cel.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl';
            $urlAutorizacion='https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl';
            
            
            if ($factura->ambiente==1) {
                $urlEnvio='https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl';
                $urlAutorizacion=
                        'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl';
            }

            $configuraciones = Configuracion::where('institucion_id', $factura->institucion_id)
                                    ->first()
                                    ->configuraciones;
            $clave=Carbon::now()->format("dmY").
                    '01'.
                    $configuraciones['ruc'].
                    $factura->ambiente.
                    str_replace('-', '', $factura->factura_numero).rand(10000000, 99999999).
                    '1';
            $modulo = Helpers::modulo($clave);
            $clave.=$modulo;
            
            $tipoDoc=Helpers::obtieneTipoDoc($factura->cliente->ruc);
            $nombre=($tipoDoc!='07')?$factura->cliente->cliente->razon_social:'Consumidor Final';
            $nombreFinal=str_ireplace(' ', '', Helpers::normaliza($nombre));
            $nombreFinal=str_ireplace('/', '', $nombreFinal);
            $file=$factura->institucion_id.'/'. Carbon::now()->format('Ymd').'-';
            $documento ='xml/'.$file. $nombreFinal.'-SF.xml';
            $docFirmado ='xml/'.$file.preg_replace('/\s+/', '', $nombreFinal).'.xml';
            $ride='pdf/'.$file.preg_replace('/\s+/', '', $nombreFinal).'.pdf';
            $xmlAut='xml/'.$file.preg_replace('/\s+/', '', $nombreFinal).'_aut.xml';

            // $secuencia=explode('-', $factura->factura_no);
            if ($factura->estado_id==1) {
                $factura->clave=$clave;
                $detalles='';
                foreach ($factura->detalle as $detalle) {
                    $hayIva = intval($detalle->iva);
                    if($hayIva==1){
                        $valor=strval(number_format($detalle->precio*0.12, 2));
                        $impuestos='<impuestos>
                            <impuesto>
                            <codigo>2</codigo>
                            <codigoPorcentaje>2</codigoPorcentaje>
                            <tarifa>12.00</tarifa>
                            <baseImponible>'.$detalle->precio.'</baseImponible>
                            <valor>'.$valor.'</valor>
                            </impuesto>
                        </impuestos>';
                    }else{
                        $valor=0;
                        $impuestos='<impuestos>
                            <impuesto>
                            <codigo>2</codigo>
                            <codigoPorcentaje>0</codigoPorcentaje>
                            <tarifa>0.00</tarifa>
                            <baseImponible>'.$detalle->precio.'</baseImponible>
                            <valor>'.$valor.'</valor>
                            </impuesto>
                        </impuestos>';
                    }
                    
                    $detalles.='<detalle>
                        <codigoPrincipal>'.$detalle->codigo.'</codigoPrincipal>
                        <descripcion>'.$detalle->descripcion.'</descripcion>
                        <cantidad>'.$detalle->cantidad.'</cantidad>
                        <precioUnitario>'.$detalle->precio_unitario.'</precioUnitario>
                        <descuento>0.00</descuento>
                        <precioTotalSinImpuesto>'.$detalle->precio.'</precioTotalSinImpuesto>';
                    $detalles.=$impuestos;
                    $detalles.='</detalle>';
                }
                $direccion=$factura->cliente->cliente->direccion ?? 'Sin dreccion';
                $subtotal = $factura->subtotal+$factura->subtotal0;
                $xml='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                    <factura id="comprobante" version="1.0.0">
                    <infoTributaria>
                        <ambiente>'.$factura->ambiente.'</ambiente>
                        <tipoEmision>1</tipoEmision>
                        <razonSocial>'.$configuraciones['razon_social'].'</razonSocial>
                        <nombreComercial>'.$configuraciones['nombre_comercial'].'</nombreComercial>
                        <ruc>'.$configuraciones['ruc'].'</ruc>
                        <claveAcceso>'.$factura->clave.'</claveAcceso>
                        <codDoc>01</codDoc>
                        <estab>'.$factura->establecimiento.'</estab>
                        <ptoEmi>'.$factura->puntoEmision.'</ptoEmi>
                        <secuencial>'.$factura->secuencia.'</secuencial>
                        <dirMatriz>'.$configuraciones['direccion_facturacion'].'</dirMatriz>
                    </infoTributaria>
                    <infoFactura>
                        <fechaEmision>'.Carbon::now()->format("d/m/Y").'</fechaEmision>
                        <dirEstablecimiento>'.$configuraciones['direccion_facturacion'].'</dirEstablecimiento>
                        <obligadoContabilidad>'.$configuraciones['contabilidad'].'</obligadoContabilidad>
                        <tipoIdentificacionComprador>'.$tipoDoc.'</tipoIdentificacionComprador>
                        <razonSocialComprador>'.$nombre.'</razonSocialComprador>
                        <identificacionComprador>'.$factura->cliente->cliente->ruc.'</identificacionComprador>
                        <direccionComprador>'.$direccion.'</direccionComprador>
                        <totalSinImpuestos>'.$subtotal.'</totalSinImpuestos>
                        <totalDescuento>'.$factura->descuento.'</totalDescuento>
                        <totalConImpuestos>
                        <totalImpuesto>
                            <codigo>2</codigo>
                            <codigoPorcentaje>2</codigoPorcentaje>
                            <baseImponible>'.$factura->subtotal.'</baseImponible>
                            <valor>'.$factura->iva.'</valor>
                        </totalImpuesto>
                        </totalConImpuestos>
                        <propina>'.$factura->propina.'</propina>
                        <importeTotal>'.$factura->total.'</importeTotal>
                        <moneda>DOLAR</moneda>
                        <pagos>
                            <pago>
                            <formaPago>19</formaPago>
                            <total>'.$factura->total.'</total>
                            <plazo>0</plazo>
                            <unidadTiempo>dias</unidadTiempo>
                            </pago>
                        </pagos>
                    </infoFactura>
                    <detalles>'.$detalles.'</detalles>
                    <infoAdicional>
                        <campoAdicional nombre="email">'.$factura->cliente->email.'</campoAdicional>
                    </infoAdicional>
                    </factura>';
                    
                $claveFirma =Crypt::decrypt($configuraciones['clave']);
                
                Storage::put($documento, $xml);
                $fimado=exec('/usr/bin/java -jar sri.jar '.
                            storage_path('app/').
                            $configuraciones['firma'].' "'.
                            $claveFirma.'" '.
                            storage_path('app/'.$documento).' '.
                            storage_path('app').' '.
                            $docFirmado
                    );
                if(strpos($fimado, "Firma guardada") !==false){
                    Storage::delete($documento);
                    $factura->estado_id=6;
                }else{
                    $factura->estado_id=9;
                }
                
                $factura->save();
            }
            $options = [
                'trace' => true,
                'cache_wsdl' => WSDL_CACHE_NONE
            ];
            if ($factura->estado_id==6 || $factura->estado_id==3) {
                $envio = new SoapClient($urlEnvio, $options); // null for non-wsdl mode
                $respEnvio = $envio->validarComprobante(['xml'=>Storage::get($docFirmado)]);
                // 'GetResult' being the name of the soap method
                print_r($respEnvio->RespuestaRecepcionComprobante);
                print_r($nombre);
                if (is_soap_fault($respEnvio)) {
                    print_r("SOAP Fault: (faultcode: {$respEnvio->faultcode}, faultstring: {$respEnvio->faultstring})");
                    $factura['estado_id']=3;
                    $factura->save();
                } else {
                    print_r($respEnvio->RespuestaRecepcionComprobante->estado.' - ');
                    if ($respEnvio->RespuestaRecepcionComprobante->estado=='RECIBIDA') {
                        $factura->estado_id=7;
                        $factura->save();
                    }
                }
            }
            if ($factura->estado_id==7) {
                $autorizacion = new SoapClient($urlAutorizacion, $options);
                $respAut = $autorizacion->autorizacionComprobante(['claveAccesoComprobante'=>$factura->clave]);
                if (is_soap_fault($respAut)) {
                    print_r("SOAP Fault: (faultcode: {$respAut->faultcode}, faultstring: {$respAut->faultstring})");
                }
                print_r($respAut->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado.' - ');
                if ($respAut->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado=='AUTORIZADO') {
                    $detallesArray=[];
                    foreach ($factura->detalle as $detalle) {
                        // $this->line($detalle);
                        $detallesArray[]= ['detalle'=>array(
                            "codigoPrincipal"=>$detalle->codigo,
                            "descripcion"=>$detalle->descripcion,
                            "cantidad"=>$detalle->cantidad,
                            "precioUnitario"=>$detalle->precio_unitario,
                            "descuento"=>'0.00',
                            "precioTotalSinImpuesto"=>$detalle->precio
                        )];
                    }
                    $urlImg = \Config::get('app.url');
                    $urlImg.= Storage::url($configuraciones['logo']) ?? url('images/logo.png');
                    
                    $json=array(
                        "template"=>array("shortid" => "EkRZMhojP"),
                        "data"=>array(
                            "facturaNo"=> $factura->factura_numero,
                            "autorizacion"=>$factura->clave,
                            "clave"=>$factura->clave,
                            "razonSocial"=>$configuraciones['razon_social'],
                            "rucVendedor"=>$configuraciones['ruc'],
                            "direccion"=>$configuraciones['direccion_facturacion'],
                            "telefono"=>$configuraciones['telefono_facturacion'],
                            "fechaAut"=>Carbon::now()->format("d/m/Y H:m:s"),
                            "fecha"=>Carbon::now()->format("d/m/Y"),
                            "ambiente"=>($factura->ambiente==1)?'Pruebas':'Produccion',
                            "emision"=>"NORMAL",
                            "comprador"=> $nombre,
                            "ruc"=> $factura->cliente->cliente->ruc,
                            "items" => $detallesArray,
                            "subtotal"=>$factura->subtotal,
                            "iva"=>$factura->iva,
                            "propina"=>$factura->propina,
                            "total"=>$factura->total,
                            "imagen"=>$urlImg
                        ),
                        "options"=>array('timeout'=>60000)
                        
                    );
                    // dd($json);                    
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
                    
                    Storage::put(
                        $xmlAut,
                        $respAut->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->comprobante
                    );
                    Storage::put($ride, $response);
                    curl_close($handler);
                    Storage::delete($docFirmado);
                    $factura['xml']=$xmlAut;
                    $factura['pdf']=$ride;
                    $factura['autorizacion']=$respAut->RespuestaAutorizacionComprobante
                                    ->autorizaciones->autorizacion->numeroAutorizacion;
                    $factura['estado_id']=2;
                    
                    if (!filter_var($factura->cliente->email, FILTER_VALIDATE_EMAIL) === false) {
                        
                        $factura->cliente->notify(new EnviarFacturaNotification($factura));
                    }
                    $factura->save();
                } else {
                    Storage::delete($docFirmado);
                    Storage::delete($documento);
                    $factura->estado_id=5;
                    $factura->save();
                }
            }
        }
    }
}
