<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Factura;
use App\Http\Helpers;
use Carbon\Carbon;
use Notification;
use SoapClient;
use DateTime;
use Session;
use Storage;
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
        $facturas = Factura::where('estado_id',1)->with(['institucion.configuracion','datos_facturacion'])->get();
        foreach($facturas as $factura){
            $clave=Carbon::now()->format("dmY") . '01' . $factura->ruc. $factura->ambiente.str_replace('-','',$factura->factura_no ). rand(10000000,99999999).'1' ;
            $modulo = Helpers::modulo($clave);
            $clave.=$modulo;
            $tipoDoc=Helpers::obtieneTipoDoc($factura->datos_facturacion->ruc);
            $nombre=($tipoDoc!='07')?$factura->datos_facturacion->nombre:'Consumidor Final';
            $nombreFinal=str_ireplace(' ', '',Helpers::normaliza($nombre));
            $nombreFinal=str_ireplace('/','',$nombreFinal);
            $documento ='xml/'.$factura->institucion_id.'/'. Carbon::now()->format('Ymd').'-'. $nombreFinal.'-SF.xml';
            $docFirmado ='xml/'.$factura->institucion_id.'/'. Carbon::now()->format('Ymd').'-'.preg_replace('/\s+/', '', $nombreFinal).'.xml';
            $ride='pdf/'.$factura->institucion_id.'/'.Carbon::now()->format('Ymd').'-'.preg_replace('/\s+/', '', $nombreFinal).'.pdf';
            $xmlAut='xml/'.$factura->institucion_id.'/'.Carbon::now()->format('Ymd').'-'.preg_replace('/\s+/', '', $nombreFinal).'_aut.xml';

            $secuencia=explode('-',$factura->factura_no);
            if($factura->estadoAutorizacionId==1){
                $factura->clave=$clave;
                $xml='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                    <factura id="comprobante" version="1.0.0">
                    <infoTributaria>
                        <ambiente>'.Config::get('constants.AMBIENTE').'</ambiente>
                        <tipoEmision>1</tipoEmision>
                        <razonSocial>PRIMMELABS TECNOLOGIA S.A.</razonSocial>
                        <nombreComercial>PRIMMELABS TECNOLOGIA S.A.</nombreComercial>
                        <ruc>0190434109001</ruc>
                        <claveAcceso>'.$factura->clave.'</claveAcceso>
                        <codDoc>01</codDoc>
                        <estab>'.$secuencia[0].'</estab>
                        <ptoEmi>'.$secuencia[1].'</ptoEmi>
                        <secuencial>'.$secuencia[2].'</secuencial>
                        <dirMatriz>Esmeraldas y Remigio Crespo</dirMatriz>
                    </infoTributaria>
                    <infoFactura>
                        <fechaEmision>'.Carbon::now()->format("d/m/Y").'</fechaEmision>
                        <dirEstablecimiento>Esmeraldas y Remigio Crespo</dirEstablecimiento>
                        <obligadoContabilidad>SI</obligadoContabilidad>
                        <tipoIdentificacionComprador>'.$tipoDoc.'</tipoIdentificacionComprador>
                        <razonSocialComprador>'.$nombre.'</razonSocialComprador>
                        <identificacionComprador>'.$ruc.'</identificacionComprador>
                        <direccionComprador>No especifica</direccionComprador>
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
                    <detalles>
                        <detalle>
                        <codigoPrincipal>0001</codigoPrincipal>
                        <descripcion>'.$descripcionFactura.'</descripcion>
                        <cantidad>1</cantidad>
                        <precioUnitario>'.$factura->subtotal.'</precioUnitario>
                        <descuento>0.00</descuento>
                        <precioTotalSinImpuesto>'.$factura->subtotal.'</precioTotalSinImpuesto>
                        <impuestos>
                            <impuesto>
                            <codigo>2</codigo>
                            <codigoPorcentaje>2</codigoPorcentaje>
                            <tarifa>12.00</tarifa>
                            <baseImponible>'.$factura->subtotal.'</baseImponible>
                            <valor>'.$factura->iva.'</valor>
                            </impuesto>
                        </impuestos>
                        </detalle>
                    </detalles>
                    <infoAdicional>
                        <campoAdicional nombre="email">'.$u->email.'</campoAdicional>
                    </infoAdicional>
                    </factura>';
                    
                    
                    Storage::put( $documento,$xml );
                    exec('/usr/bin/java -jar sri.jar firma/juan_francisco_merchan_martinez.p12 Primme2019 '.storage_path('app/'.$documento).' '.storage_path('app/').' '.$docFirmado);
                    Storage::delete($documento);
                    $factura->estadoAutorizacionId=6;   
                    $factura->save();
                }
        }
    }
}
