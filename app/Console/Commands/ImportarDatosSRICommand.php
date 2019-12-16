<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\ClienteImport;

class ImportarDatosSRICommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sri:importar';

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
        $this->output->title('Starting import');
        // (new ClienteImport)->withOutput($this->output)->import('sri/AZUAY.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/GUAYAS.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/PICHINCHA.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/MANABI.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/LOJA.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/BOLIVAR.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/CANAR.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/CARCHI.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/CHIMBORAZO.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/COTOPAXI.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/EL_ORO.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/ESMERALDAS.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/GALAPAGOS.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/IMBABURA.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/LOS_RIOS.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/MORONA_SANTIAGO.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/ORELLANA.txt');
        // (new ClienteImport)->withOutput($this->output)->import('sri/NAPO.txt');
        (new ClienteImport)->withOutput($this->output)->import('sri/PASTAZA.txt');
        (new ClienteImport)->withOutput($this->output)->import('sri/SANTA_ELENA.txt');
        (new ClienteImport)->withOutput($this->output)->import('sri/SANTO_DOMINGO.txt');
        (new ClienteImport)->withOutput($this->output)->import('sri/SUCUMBIOS.txt');
        (new ClienteImport)->withOutput($this->output)->import('sri/TUNGURAHUA.txt');
        (new ClienteImport)->withOutput($this->output)->import('sri/ZAMORA_CHINCHIPE.txt');
        $this->output->success('Import successful');
        
    }
}
