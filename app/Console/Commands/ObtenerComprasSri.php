<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClienteInstitucion;
use App\Models\Institucion;
use App\Models\Cliente;
use App\Models\Compra;
use Carbon\Carbon;
use Crypt;

class ObtenerComprasSri extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sri:compras';

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
        $anos=['2020','2019','2018'];
        $meses=[1,2,3,4,5,6,7,8,9,10,11,12];
        $sri_web='https://srienlinea.sri.gob.ec/movil-servicios/api/';
        $instituciones = Institucion::with('configuracion')->get();
        $hoy = Carbon::now();
        foreach ($instituciones as $institucion) {
            $ruc = (array_key_exists('ruc', $institucion->configuracion->configuraciones) && $institucion->configuracion->configuraciones['ruc'])?$institucion->configuracion->configuraciones['ruc']:null;
            $clave = (array_key_exists('clave_sri', $institucion->configuracion->configuraciones) && $institucion->configuracion->configuraciones['clave_sri'])?Crypt::decrypt($institucion->configuracion->configuraciones['clave_sri']):null;
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
                    foreach ($meses as $mes) {
                        $resp = $client->request('GET', $sri_web.'v2.0/comprobantes/lista', [
                            'headers' => [
                                'User-Agent' => 'PostmanRuntime/7.19.0',
                                'Accept'     => '*/*',
                                'Authorization'      => $token
                            ],
                            'query' => [
                                'tipoComprobante' => '1',
                                'anio'=>$hoy->format('Y'),
                                'mes'=>$hoy->format('m')]
                        ]);
                        if ($resp->getStatusCode()==200) {
                            $json=(string) $resp->getBody();
                            $compras= json_decode($json);
                            foreach ($compras as $compra) {
                                foreach ($compra->comprobantes as $comprobante) {
                                    $cliente = Cliente::where('ruc', $comprobante->rucEmisor)->first();
                                    if ($cliente==null) {
                                        $cliente=Cliente::create([
                                            'razon_social'=>$comprobante->razonSocialEmisor,
                                            'ruc'=>$comprobante->rucEmisor
                                        ]);
                                    }
                                    $cliente_institucion = ClienteInstitucion::where('institucion_id', $institucion->id)->where('cliente_id', $cliente->id)->first();
                                    if ($cliente_institucion==null) {
                                        $cliente_institucion =$institucion->clientes()->create([
                                            'cliente_id'=>$cliente->id,
                                            'nombre'=>$comprobante->razonSocialEmisor
                                        ]);
                                    }
                                    $compra = Compra::where('institucion_id', $institucion->id)
                                            ->where('cliente_id', $cliente_institucion->id)
                                            ->where('codigoComprobanteRecibido', $comprobante->codigoComprobanteRecibido)
                                            ->where('tipoComprobante', $comprobante->tipoComprobante)->first();
                                    if ($compra==null) {
                                        $respDetalle = $client->request('GET', $sri_web.'v2.0/comprobantes/detalle', [
                                            'headers' => [
                                                'User-Agent' => 'PostmanRuntime/7.19.0',
                                                'Accept'     => '*/*',
                                                'Authorization'      => $token
                                            ],
                                            'query' => [
                                                'codigoComprobanteRecibido' => $comprobante->codigoComprobanteRecibido,
                                                'tipoDeComprobante'=>$comprobante->codigoTipoDocumento,
                                                'fechaEmision'=>$comprobante->fechaEmisionFormato
                                            ]
                                        ]);
                                        if ($respDetalle->getStatusCode()==200) {
                                            $json=(string) $respDetalle->getBody();
                                            $detalle= json_decode($json);
                                            $compra= $institucion->compras()->create([
                                                'cliente_id'=>$cliente_institucion->id,
                                                'fecha'=>$comprobante->fechaEmision,
                                                'establecimiento'=>$comprobante->establecimiento,
                                                'puntoEmision'=>$comprobante->puntoEmision,
                                                'secuencial'=>$comprobante->secuencial,
                                                'tipoComprobante'=>$comprobante->tipoComprobante,
                                                'codigoTipoDocumento'=>$comprobante->codigoTipoDocumento,
                                                'codigoComprobanteRecibido'=>$comprobante->codigoComprobanteRecibido,
                                                'claveAcceso'=>$detalle->claveAcceso,
                                                'total'=>$detalle->importeTotal,
                                                'totalSinImpuestos'=>$detalle->totalSinImpuestos,
                                                'propina'=>$detalle->propina,
                                                'totalDescuento'=>$detalle->totalDescuento,
                                                'impuestos'=>$detalle->impuestos
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
