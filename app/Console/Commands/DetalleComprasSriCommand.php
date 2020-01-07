<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Compra;
use App\Http\Helpers;
use Carbon\Carbon;

use Crypt;

class DetalleComprasSriCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sri:detalle-compras';

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
        $compras =Compra::where('sincronizado', 0)->get();
        $bar = $this->output->createProgressBar($compras->count());
        $bar->start();


        foreach ($compras as $compra) {
            Helpers::obtenereComprasSRI($compra);
            $bar->advance();
        }
        $bar->finish();
    }
}
