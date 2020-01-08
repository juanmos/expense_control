<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Helpers;
use App\Models\Configuracion;
use Storage;
use Config;

class CrearFacturaPDFJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $factura;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($factura)
    {
        $this->factura=$factura;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $configuraciones = Configuracion::where('institucion_id', $this->factura->institucion_id)
                                    ->first()
                                    ->configuraciones;

        foreach ($this->factura->detalle as $detalle) {
            $detallesArray[]= [
                'detalle'=>array(
                "codigoPrincipal"=>$detalle->codigo,
                "descripcion"=>$detalle->descripcion,
                "cantidad"=>$detalle->cantidad,
                "precioUnitario"=>$detalle->precio_unitario,
                "descuento"=>'0.00',
                "precioTotalSinImpuesto"=>$detalle->precio
            )];
        }
        $urlImg = \Config::get('app.url');
        $urlImg.= (array_key_exists('logo', $configuraciones))?Storage::url($configuraciones['logo']) : url('images/logo.png');
                    
        $json=array(
            "template"=>array("shortid" => "EkRZMhojP"),
            "data"=>array(
                "facturaNo"=> $this->factura->factura_numero,
                "autorizacion"=>$this->factura->clave,
                "clave"=>$this->factura->clave,
                "razonSocial"=>$configuraciones['razon_social'],
                "rucVendedor"=>$configuraciones['ruc'],
                "direccion"=>$configuraciones['direccion_facturacion'],
                "telefono"=>$configuraciones['telefono_facturacion'],
                "contabilidad"=>$configuraciones['contabilidad'],
                "fechaAut"=>date('d/m/Y', strtotime($this->factura->fecha)),
                "fecha"=>date('d/m/Y', strtotime($this->factura->fecha)),
                "ambiente"=>($this->factura->ambiente==1)?'Pruebas':'Produccion',
                "emision"=>"NORMAL",
                "comprador"=> $this->factura->cliente->cliente->razon_social,
                "ruc"=> $this->factura->cliente->cliente->ruc,
                "items" => $detallesArray,
                "subtotal"=>$this->factura->subtotal,
                "subtotal0"=>$this->factura->subtotal0,
                "iva"=>$this->factura->iva,
                "propina"=>$this->factura->propina,
                "total"=>$this->factura->total,
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
        $file=$this->factura->institucion_id.'/'. now()->format('Ymd').'-';
        $nombreFinal=str_ireplace(' ', '', Helpers::normaliza($this->factura->cliente->cliente->razon_social));
        $nombreFinal=str_ireplace('/', '', $nombreFinal);
        $ride='pdf/'.$file.preg_replace('/\s+/', '', $nombreFinal).'.pdf';
                    
        Storage::put($ride, $response);
        curl_close($handler);
        $this->factura['pdf']=$ride;
        $this->factura->save();
    }
}
