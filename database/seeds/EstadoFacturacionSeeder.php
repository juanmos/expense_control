<?php

use Illuminate\Database\Seeder;
use App\Models\EstadoFactura;

class EstadoFacturacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoFactura::create([
            'estado'=>'Procesando',
        ]);
        EstadoFactura::create([
            'estado'=>'Autorizada',
        ]);
        EstadoFactura::create([
            'estado'=>'No recibida',
        ]);
        EstadoFactura::create([
            'estado'=>'Devuelta',
        ]);
        EstadoFactura::create([
            'estado'=>'Mail no enviada',
        ]);
        EstadoFactura::create([
            'estado'=>'Lista para enviar',
        ]);
        EstadoFactura::create([
            'estado'=>'Recibida',
        ]);
        EstadoFactura::create([
            'estado'=>'Anulada',
        ]);
    }
}
