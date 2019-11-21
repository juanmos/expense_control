<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Helpers;
use App\Models\ClienteInstitucion;
use App\Models\Institucion;
use App\Models\Cliente;
use App\Models\Compra;
use Carbon\Carbon;
use Crypt;

class ObtenerComprasAnterioresJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $institucion ;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($institucion)
    {
        $this->institucion=$institucion;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $anos=['2020','2019','2018'];
        $meses=[1,2,3,4,5,6,7,8,9,10,11,12];
        $sri_web='https://srienlinea.sri.gob.ec/movil-servicios/api/';
        // $instituciones = Institucion::with('configuracion')->get();
        // dd($this->institucion);
        $institucion=$this->institucion;
        $ruc = (
                array_key_exists('ruc', $institucion->configuracion->configuraciones) &&
                $institucion->configuracion->configuraciones['ruc']
            )?$institucion->configuracion->configuraciones['ruc']:null;
        $clave = (
                array_key_exists('clave_sri', $institucion->configuracion->configuraciones) &&
                $institucion->configuracion->configuraciones['clave_sri']
            )?Crypt::decrypt($institucion->configuracion->configuraciones['clave_sri']):null;
        if ($ruc!=null && $clave!=null) {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('POST', $sri_web.'v2.0/secured', [
                'headers' => [
                    'User-Agent' => 'PostmanRuntime/7.19.0',
                    'Accept'     => '*/*',
                    'Authorization'      => 'Basic '. base64_encode($ruc.':'.$clave)
                ]]);
            if ($res->getStatusCode()==200) {
                $json=(string) $res->getBody();
                $token= json_decode($json)->contenido;
                $hoy = Carbon::now();
                foreach ($anos as $ano) {
                    if ($ano <= $hoy->format('Y')) {
                        foreach ($meses as $mes) {
                            $fecha = Carbon::parse($ano.'-'.$mes.'-01');
                            if ($hoy->diffInDays($fecha, false) <=0) {
                                $resp = $client->request('GET', $sri_web.'v2.0/comprobantes/lista', [
                                    'headers' => [
                                        'User-Agent' => 'PostmanRuntime/7.19.0',
                                        'Accept'     => '*/*',
                                        'Authorization'      => $token
                                    ],
                                    'query' => [
                                        'tipoComprobante' => '1',
                                        'anio'=>$ano,
                                        'mes'=>$mes]
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
                                                            'Authorization'      => $token
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
                                                    if($cliente->nombre_comercial==null || $cliente->nombre_comercial==''){
                                                        $cliente->nombre_comercial=$detalle->nombreComercial;
                                                        $cliente->save();
                                                    }
                                                    if($cliente->categoria_id==1){
                                                        Helpers::clasifica($cliente);
                                                    }
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
                                                        'categoria_id'=>$cliente->categoria_id
                                                    ]);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
