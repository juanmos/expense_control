<?php

use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estado_institucions')->insert([
            'estado' => "Creada",
        ]);
        DB::table('estado_institucions')->insert([
            'estado' => "Visitada",
        ]);
        DB::table('estado_institucions')->insert([
            'estado' => "Interesada",
        ]);
        DB::table('estado_institucions')->insert([
            'estado' => "Cotizada",
        ]);
        DB::table('estado_institucions')->insert([
            'estado' => "Pagando",
        ]);
        DB::table('estado_institucions')->insert([
            'estado' => "En mora",
        ]);
        DB::table('estado_institucions')->insert([
            'estado' => "Suspendida",
        ]);
        DB::table('estado_institucions')->insert([
            'estado' => "Rechazada",
        ]);
        DB::table('estado_institucions')->insert([
            'estado' => "Cerrada",
        ]);
    }
}
