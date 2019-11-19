<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Helpers;
use App\Models\TipoTarjeta;
use App\Models\Tarjeta;
use App\Models\User;
use carbon\Carbon;
use Auth;
use Crypt;

class CodificarQRCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alumno:qr {user}';

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
        $usuarios =User::doesntHave('tarjetas')->whereHas('roles', function ($query) {
            $query->where('name', 'Alumno');
        })->with('alumno')->get();
        foreach ($usuarios as $usuario) {
            $tarjeta=$usuario->tarjetas()->create([
                'tipo_tarjeta_id'=>1,
                'cupo_mensual'=>0,
                'fecha_solicitud'=>Carbon::now()->toDateTimeString(),
                'fecha_vencimiento'=>Carbon::now()->addDays(270)->toDateTimeString(),
                'usuario_crea_id'=> $this->argument('user')
            ]);
            $tarjeta->codigo=Helpers::creaQR($usuario->id, $tarjeta->id);
            $tarjeta->save();
        }
        
        $tarjetas = Tarjeta::whereNull('codigo')
                ->where('perdida', 0)
                ->where('fecha_solicitud', '<=', Carbon::now()->toDateTimeString())
                ->where('fecha_vencimiento', '>', Carbon::now()->toDateTimeString())
                ->get();
        foreach ($tarjetas as $tarjeta) {
            $tarjeta->codigo=Helpers::creaQR($tarjeta->usuario_id, $tarjeta->id);
            $tarjeta->save();
        }
    }
}
