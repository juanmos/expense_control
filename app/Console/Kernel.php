<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\CodificarQRCommand::class,
        \App\Console\Commands\DetalleComprasSriCommand::class,
        \App\Console\Commands\FacturarCommand::class,
        \App\Console\Commands\ObtenerComprasSri::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        if(App::environment()=='production'){
            $schedule->command('sri:compras')->twiceDaily(1, 13);

            $schedule->command('sri:detalle-compras')->twiceDaily(2, 14);

            $schedule->command('facturar')->everyTenMinutes();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
