<?php

use Illuminate\Database\Seeder;

class FormaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forma_pagos')->insert([
            'forma_pago' => "Efectivo",
            "habilitado"=>1
        ]);
        DB::table('forma_pagos')->insert([
            'forma_pago' => "Tarjeta de credito",
            "habilitado"=>1
        ]);
        DB::table('forma_pagos')->insert([
            'forma_pago' => "Tarjeta de debito",
            "habilitado"=>1
        ]);
        DB::table('forma_pagos')->insert([
            'forma_pago' => "Transferencia",
            "habilitado"=>1
        ]);
        DB::table('forma_pagos')->insert([
            'forma_pago' => "Cheque",
            "habilitado"=>1
        ]);
        DB::table('forma_pagos')->insert([
            'forma_pago' => "Debito bancario",
            "habilitado"=>1
        ]);
    }
}
