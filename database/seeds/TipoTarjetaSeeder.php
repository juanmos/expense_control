<?php

use Illuminate\Database\Seeder;
use App\Models\TipoTarjeta;

class TipoTarjetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoTarjeta::create([
            'tipo_tarjeta'=>'QR'
        ]);
    }
}
