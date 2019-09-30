<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Auth;
use Crypt;


class CodificarQRCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alumno:qr';

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
        $usuarios =User::whereNull('codigo')->whereHas('roles',function($query){
            $query->where('name','Alumno');
        })->with('alumno')->get();
        foreach($usuarios as $usuario){
            $cryptId=base64_encode($usuario->id);
            $usuario->codigo=Crypt::encryptString($usuario->cedula.'|'.$usuario->full_name.'|'.$usuario->alumno->ano_lectivo.'|'.$usuario->alumno->curso.'|'. $cryptId);
            $usuario->save();
        }
        
    }
}
