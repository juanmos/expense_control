<?php

use Illuminate\Database\Seeder;

class InstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('institucions')->insert([
            'id'=>1,
            'nombre'=>'Unidad Educativa Alborada',
            'siglas'=>'uepa',
            'direccion'=>'Avenida Ordoñez Lazo Km. 5, Sector Santa María de Sayausí Cuenca-Ecuador',
            'telefono'=>'+593 7-419 3000',
            'celular'=>'+593 99 998 35 17',
            'email'=>'info@alborada.edu.ec',
            'web'=>'http://www.alborada.edu.ec',
            'facebook'=>'https://www.facebook.com/uealborada/',
            'estado_id'=>'3',
            'ciudad_id'=>'3'
        ]);
    }
}
