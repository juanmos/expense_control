<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\ObtenerComprasMesJob;
use App\Http\Helpers;
use App\Models\ClienteInstitucion;
use App\Models\Institucion;
use App\Models\Cliente;
use App\Models\Compra;
use Carbon\Carbon;
use Artisan;
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
        )?Crypt::decryptString($institucion->configuracion->configuraciones['clave_sri']):null;
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
                                ObtenerComprasMesJob::dispatch([
                                    'token'=>$token,
                                    'ano'=>$ano,
                                    'mes'=>$mes,
                                    'institucion_id'=>$institucion->id
                                ], false)->delay(1);
                            }
                        }
                    }
                }
            }
        }
        Artisan::call('sri:detalle-compras');
    }
}
