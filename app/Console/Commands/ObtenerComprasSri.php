<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ObtenerRetencionesMesJob;
use App\Jobs\ObtenerComprasMesJob;
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
        $sri_web='https://srienlinea.sri.gob.ec/movil-servicios/api/';
        $instituciones = Institucion::with('configuracion')->get();
        $hoy = Carbon::now();
        $bar = $this->output->createProgressBar($instituciones->count());
        $bar->start();
        foreach ($instituciones as $institucion) {
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
                    ObtenerComprasMesJob::dispatch([
                        'token'=>$token,
                        'ano'=>$hoy->format('Y'),
                        'mes'=>$hoy->format('m'),
                        'institucion_id'=>$institucion->id
                    ])->delay(1);
                    ObtenerRetencionesMesJob::dispatch([
                        'token'=>$token,
                        'ano'=>$hoy->format('Y'),
                        'mes'=>$hoy->format('m'),
                        'institucion_id'=>$institucion->id
                    ])->delay(1);
                }
            }
            $bar->advance();
        }
        $bar->finish();
    }
}
