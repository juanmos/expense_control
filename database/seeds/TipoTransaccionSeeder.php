<?php

use Illuminate\Database\Seeder;

class TipoTransaccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_transaccions')->insert([
            'tipo' => "Compra",
            "operacion"=>"-"
        ]);
        DB::table('tipo_transaccions')->insert([
            'tipo' => "Recarga",
            "operacion"=>"+"
        ]);
        DB::table('tipo_transaccions')->insert([
            'tipo' => "Reverso de compra",
            "operacion"=>"+"
        ]);
        DB::table('tipo_transaccions')->insert([
            'tipo' => "Reverso de recarga",
            "operacion"=>"-"
        ]);
         DB::table('tipo_transaccions')->insert([
            'tipo' => "Refrigerio",
            "operacion"=>"-"
        ]);
    }
}
