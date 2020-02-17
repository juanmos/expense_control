<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\NuevaCompraNotification;
use App\Http\Helpers;
use App\Models\ClienteInstitucion;
use App\Models\Institucion;
use App\Models\Cliente;
use App\Models\Compra;
use Carbon\Carbon;
use Artisan;
use Crypt;

class ObtenerComprasMesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $datos;
    private $notifica;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($datos, $notifica = true)
    {
        $this->datos =$datos;
        $this->notifica = $notifica;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sri_web='https://srienlinea.sri.gob.ec/movil-servicios/api/';
        $institucion=Institucion::find($this->datos['institucion_id']);
        $client = new \GuzzleHttp\Client();
        $resp = $client->request('GET', $sri_web.'v2.0/comprobantes/lista', [
            'headers' => [
                'User-Agent' => 'PostmanRuntime/7.19.0',
                'Accept'     => '*/*',
                'Authorization'      => $this->datos['token']
            ],
            'query' => [
                'tipoComprobante' => '1',
                'anio'=>$this->datos['ano'],
                'mes'=>$this->datos['mes']
            ]
        ]);
        if ($resp->getStatusCode()==200) {
            $json=(string) $resp->getBody();
            $comprasSRI= json_decode($json);
            foreach ($comprasSRI as $compraSRI) {
                foreach ($compraSRI->comprobantes as $comp) {
                    $cliente = Cliente::where('ruc', $comp->rucEmisor)->first();
                    if ($cliente==null) {
                        $cliente=Cliente::create([
                            'razon_social'=>$comp->razonSocialEmisor,
                            'ruc'=>$comp->rucEmisor
                        ]);
                    }
                    $cliente_institucion = ClienteInstitucion::
                                            where('institucion_id', $institucion->id)
                                            ->where('cliente_id', $cliente->id)->first();
                    if ($cliente_institucion==null) {
                        $cliente_institucion =$institucion->clientes()->create([
                            'cliente_id'=>$cliente->id,
                            'nombre'=>$comp->razonSocialEmisor
                        ]);
                    }
                    $compra = Compra::where('institucion_id', $institucion->id)
                            ->where('cliente_id', $cliente_institucion->id)
                            ->where(
                                'codigoComprobanteRecibido',
                                $comp->codigoComprobanteRecibido
                            )
                            ->where('tipoComprobante', $comp->tipoComprobante)->first();
                    if ($compra==null) {
                        $respDetalle = $client->request(
                            'GET',
                            $sri_web.'v2.0/comprobantes/detalle',
                            [
                                'headers' => [
                                    'User-Agent' => 'PostmanRuntime/7.19.0',
                                    'Accept'     => '*/*',
                                    'Authorization'      => $this->datos['token']
                                ],
                                'query' => [
                                    'codigoComprobanteRecibido' =>
                                                            $comp->codigoComprobanteRecibido,
                                    'tipoDeComprobante'=>$comp->codigoTipoDocumento,
                                    'fechaEmision'=>$comp->fechaEmisionFormato
                                ]
                            ]
                        );
                        if ($respDetalle->getStatusCode()==200) {
                            $json=(string) $respDetalle->getBody();
                            $detalle= json_decode($json);
                            if ($cliente->nombre_comercial==null || $cliente->nombre_comercial=='') {
                                $cliente->nombre_comercial=($detalle->nombreComercial!=null)?trim($detalle->nombreComercial):trim($cliente->razon_social);
                                $cliente->save();
                            }
                            // if($cliente->categoria_id==1){
                            //     Helpers::clasifica($cliente);
                            // }
                            $compra= $institucion->compras()->create([
                                'cliente_id'=>$cliente_institucion->id,
                                'fecha'=>$comp->fechaEmision,
                                'establecimiento'=>$comp->establecimiento,
                                'puntoEmision'=>$comp->puntoEmision,
                                'secuencial'=>$comp->secuencial,
                                'tipoComprobante'=>$comp->tipoComprobante,
                                'codigoTipoDocumento'=>$comp->codigoTipoDocumento,
                                'codigoComprobanteRecibido'=>$comp->codigoComprobanteRecibido,
                                'claveAcceso'=>$detalle->claveAcceso,
                                'total'=>$detalle->importeTotal,
                                'totalSinImpuestos'=>$detalle->totalSinImpuestos,
                                'propina'=>$detalle->propina,
                                'totalDescuento'=>$detalle->totalDescuento,
                                'impuestos'=>$detalle->impuestos,
                                'categoria_id'=>($cliente->categoria_id!=null)?$cliente->categoria_id:1
                            ]);
                            if ($this->notifica) {
                                foreach ($institucion->alumnos as $user) {
                                    $user->notify(new NuevaCompraNotification());
                                }
                                $this->notifica=false;
                            }
                        }
                    }
                }
            }
        }
    }
}
