<?php

namespace App\Console\Commands;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Console\Command;
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
    protected $signature = 'facturar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
 
        $facturas = Factura::whereIn('estado_id', [1,7])->with(['institucion.configuracion','datos_facturacion','detalle'])->get();
        foreach ($facturas as $factura) {
            $urlEnvio = 'https://cel.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl';
            $urlAutorizacion = 'https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl';
            $urlImg = "https://doctopro.com/images/logo.png";
            
            if ($factura->ambiente==1) {
                $urlEnvio = 'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl';
                $urlAutorizacion = 'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl';
            }

            $configuraciones = Configuracion::where('institucion_id', $factura->institucion_id)->first()->configuraciones;
            $clave=Carbon::now()->format("dmY") . '01' . $configuraciones['ruc']. $factura->ambiente.str_replace('-', '', $factura->factura_no). rand(10000000, 99999999).'1' ;
            $modulo = Helpers::modulo($clave);
            $clave.=$modulo;
            $tipoDoc=Helpers::obtieneTipoDoc($factura->datos_facturacion->ruc);
            $nombre=($tipoDoc!='07')?$factura->datos_facturacion->nombre:'Consumidor Final';
            $nombreFinal=str_ireplace(' ', '', Helpers::normaliza($nombre));
            $nombreFinal=str_ireplace('/', '', $nombreFinal);
            $documento ='xml/'.$factura->institucion_id.'/'. Carbon::now()->format('Ymd').'-'. $nombreFinal.'-SF.xml';
            $docFirmado ='xml/'.$factura->institucion_id.'/'. Carbon::now()->format('Ymd').'-'.preg_replace('/\s+/', '', $nombreFinal).'.xml';
            $ride='pdf/'.$factura->institucion_id.'/'.Carbon::now()->format('Ymd').'-'.preg_replace('/\s+/', '', $nombreFinal).'.pdf';
            $xmlAut='xml/'.$factura->institucion_id.'/'.Carbon::now()->format('Ymd').'-'.preg_replace('/\s+/', '', $nombreFinal).'_aut.xml';

            $secuencia=explode('-', $factura->factura_no);
            if ($factura->estado_id==1) {
                $factura->clave=$clave;
                $detalles='';
                foreach ($factura->detalle as $detalle) {
                    $valor=strval(number_format($detalle->iva, 2));
                    $detalles.='<detalle>
                        <codigoPrincipal>'.$detalle->codigo.'</codigoPrincipal>
                        <descripcion>'.$detalle->descripcion.'</descripcion>
                        <cantidad>'.$detalle->cantidad.'</cantidad>
                        <precioUnitario>'.$detalle->precio_unitario.'</precioUnitario>
                        <descuento>0.00</descuento>
                        <precioTotalSinImpuesto>'.$detalle->precio.'</precioTotalSinImpuesto>
                        <impuestos>
                            <impuesto>
                            <codigo>2</codigo>
                            <codigoPorcentaje>2</codigoPorcentaje>
                            <tarifa>12.00</tarifa>
                            <baseImponible>'.$detalle->precio.'</baseImponible>
                            <valor>'.$valor.'</valor>
                            </impuesto>
                        </impuestos>
                        </detalle>';
                }
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
                        <estab>'.$secuencia[0].'</estab>
                        <ptoEmi>'.$secuencia[1].'</ptoEmi>
                        <secuencial>'.$secuencia[2].'</secuencial>
                        <dirMatriz>'.$configuraciones['direccion_facturacion'].'</dirMatriz>
                    </infoTributaria>
                    <infoFactura>
                        <fechaEmision>'.Carbon::now()->format("d/m/Y").'</fechaEmision>
                        <dirEstablecimiento>'.$configuraciones['direccion_facturacion'].'</dirEstablecimiento>
                        <obligadoContabilidad>'.$configuraciones['contabilidad'].'</obligadoContabilidad>
                        <tipoIdentificacionComprador>'.$tipoDoc.'</tipoIdentificacionComprador>
                        <razonSocialComprador>'.$nombre.'</razonSocialComprador>
                        <identificacionComprador>'.$factura->datos_facturacion->ruc.'</identificacionComprador>
                        <direccionComprador>'.$factura->datos_facturacion->direccion.'</direccionComprador>
                        <totalSinImpuestos>'.$factura->subtotal.'</totalSinImpuestos>
                        <totalDescuento>0.00</totalDescuento>
                        <totalConImpuestos>
                        <totalImpuesto>
                            <codigo>2</codigo>
                            <codigoPorcentaje>2</codigoPorcentaje>
                            <baseImponible>'.$factura->subtotal.'</baseImponible>
                            <valor>'.$factura->iva.'</valor>
                        </totalImpuesto>
                        </totalConImpuestos>
                        <propina>0.00</propina>
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
                        <campoAdicional nombre="email">'.$factura->datos_facturacion->email.'</campoAdicional>
                    </infoAdicional>
                    </factura>';
                    
                    
                $claveFirma =Crypt::decrypt($configuraciones['clave']);
                
                Storage::put($documento, $xml);
                exec('/usr/bin/java -jar sri.jar '.storage_path('app/').$configuraciones['firma'].' '.$claveFirma.' '.storage_path('app/'.$documento).' '.storage_path('app/').' '.$docFirmado);
                Storage::delete($documento);
                $factura->estado_id=6;
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
                        $detallesArray['detalle']= array(
                            "codigoPrincipal"=>$detalle->codigo,
                            "descripcion"=>$detalle->descripcion,
                            "cantidad"=>$detalle->cantidad,
                            "precioUnitario"=>$detalle->precio_unitario,
                            "descuento"=>'0.00',
                            "precioTotalSinImpuesto"=>$detalle->precio
                        );
                    }
                    $json=array(
                        "template"=>array("shortid" => "NJTN-fPUm"),
                        "data"=>array(
                            "facturaNo"=> $factura->factura_no,
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
                            "ruc"=> $factura->datos_facturacion->ruc,
                            "items" => $detallesArray,
                            "subtotal"=>$factura->subtotal,
                            "iva"=>$factura->iva,
                            "propina"=>"0.00",
                            "total"=>$factura->total,
                            "imagen"=>$urlImg
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
                    
                    Storage::put($xmlAut, $respAut->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->comprobante);
                    Storage::put($ride, $response);
                    curl_close($handler);
                    Storage::delete($docFirmado);
                    $factura['xml']=$xmlAut;
                    $factura['pdf']=$ride;
                    $factura['autorizacion']=$respAut->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->numeroAutorizacion;
                    $factura['estado_id']=2;
                    $factura->save();
                    // if (!filter_var($u->email, FILTER_VALIDATE_EMAIL) === false) {
                    //     Session::put('facturaEmail',(Config::get('constants.AMBIENTE')==1)?'juan.moscoso@primme.tech':$u->email);

                    //     $info['nombre'] = $u->nombre;
                    //     $info['apellido'] = $u->apellido;
                    //     $info['fecha'] = $factura->fecha;
                    //     $info['total'] = $factura->total;
                    //     $info['pdf_factura'] = $ride;
                    //     $info['xml_factura'] = $xmlAut;

                    //     try{
                            
                    //         Mail::to(Session::get('facturaEmail'))
                    //             ->send(new MailsFacturacion($info));

                    //     }catch(Exception $e){
                    //         print_r("Error email");
                    //         $factura->estado_id=5;
                    //         $factura->save();
                    //     }
                        
                    // }
                } else {
                    Storage::delete($docFirmado);
                    Storage::delete($documento);
                    $factura->estado_id=5;
                    $factura->save();
                }
            }
            //Slack::to('#facturacion')->send('Nueva factura # '.$factura->facturaNo.' id '.$factura->id.' de '.$u->nombre." ".$u->apellido.'. Estado de factura: '.$factura->estado_id);

            // $task['title'] = 'Nueva factura';
            // $task['facturaNo'] = $factura->facturaNo;
            // $task['id'] = $factura->id;
            // $task['nombre'] = $u->nombre;
            // $task['apellido'] = $u->apellido;
            // $task['estado_id'] = $factura->estado_id;
            // Notification::send(Doctor::first(), new SlackFacturacion($task));
        }
    }
}
