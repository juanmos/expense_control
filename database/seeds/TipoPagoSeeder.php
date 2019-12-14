<?php

use Illuminate\Database\Seeder;

class TipoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_plans')->insert([
            'tipo' => "Gratuito",
            "valor"=>"0"
        ]);
        DB::table('tipo_plans')->insert([
            'tipo' => "Persona Natural",
            "valor"=>"9.99"
        ]);
        DB::table('tipo_plans')->insert([
            'tipo' => "Restaurante",
            "valor"=>"14.99"
        ]);
        DB::table('tipo_plans')->insert([
            'tipo' => "Unidad Educativa",
            "valor"=>"34.99"
        ]);
    }
}
