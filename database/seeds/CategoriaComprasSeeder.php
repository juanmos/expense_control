<?php

use Illuminate\Database\Seeder;

class CategoriaComprasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categoria_compras')->insert([
            'categoria' => "Otros",
            "icono"=>"Otros",
            "color"=>""
        ]);
        DB::table('categoria_compras')->insert([
            'categoria' => "Alimentación",
            "icono"=>"Alimentacion",
            "color"=>""
        ]);
        DB::table('categoria_compras')->insert([
            'categoria' => "Educación",
            "icono"=>"Educacion",
            "color"=>""
        ]);
        DB::table('categoria_compras')->insert([
            'categoria' => "Vivienda",
            "icono"=>"Vivienda",
            "color"=>""
        ]);
        DB::table('categoria_compras')->insert([
            'categoria' => "Salud",
            "icono"=>"Salud",
            "color"=>""
        ]);
        DB::table('categoria_compras')->insert([
            'categoria' => "Arte y Cultura",
            "icono"=>"Arte",
            "color"=>""
        ]);
        DB::table('categoria_compras')->insert([
            'categoria' => "Vestimenta",
            "icono"=>"Vestimenta",
            "color"=>""
        ]);
        DB::table('categoria_compras')->insert([
            'categoria' => "Gasolina",
            "icono"=>"Gasolina",
            "color"=>""
        ]);
        DB::table('categoria_compras')->insert([
            'categoria' => "Diversión",
            "icono"=>"Diversion",
            "color"=>""
        ]);
    }
}
