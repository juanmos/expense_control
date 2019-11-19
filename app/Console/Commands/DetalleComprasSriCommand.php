<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cliente;
use App\Models\Compra;
use Carbon\Carbon;
use SoapClient;
use Storage;
use Crypt;

class DetalleComprasSriCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sri:detalle-compras';

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
        
        $urlAutorizacion = 'https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl';
        $options = [
                'trace' => true,
                'cache_wsdl' => WSDL_CACHE_NONE
            ];
        $compras =Compra::where('sincronizado', 0)->get();
        foreach ($compras as $compra) {
            $autorizacion = new SoapClient($urlAutorizacion, $options);
            $respAut = $autorizacion->autorizacionComprobante(['claveAccesoComprobante'=>$compra->claveAcceso]);
            if (is_soap_fault($respAut)) {
                print_r("SOAP Fault: (faultcode: {$respAut->faultcode}, faultstring: {$respAut->faultstring})");
            }
            // print_r($respAut->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado);
            if ($respAut->RespuestaAutorizacionComprobante->numeroComprobantes>0 && 
                $respAut->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado=='AUTORIZADO') {
                $comprobante=$respAut->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->comprobante;
                $xml = simplexml_load_string($comprobante, "SimpleXMLElement", LIBXML_NOCDATA);
                $json = json_encode($xml);
                $array = json_decode($json, true);
                
                $cliente=Cliente::where('ruc', $array['infoTributaria']['ruc'])->first();
                $cliente->direccion=$array['infoTributaria']['dirMatriz'];
                $cliente->save();
                $compra->detalles=$array['detalles'];
                $compra->sincronizado=1;
                print_r($array);
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
                        "propina"=>$array['infoFactura']['propina'],
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
            }
        }
    }
}
