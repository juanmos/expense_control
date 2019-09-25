<?php

use Illuminate\Database\Seeder;

class CiudadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ciudads')->insert([
            'ciudad' => "Guayaquil",
            'pais_id' => "1",
        ]);
        DB::table('ciudads')->insert([
            'ciudad' => "Quito",
            'pais_id' => "1",
        ]);
        DB::table('ciudads')->insert([
            'ciudad' => "Cuenca",
            'pais_id' => "1",
        ]);
        DB::table('ciudads')->insert([
            'ciudad' => "Manta",
            'pais_id' => "1",
        ]);
        DB::table('ciudads')->insert([
            'ciudad' => "Portoviejo",
            'pais_id' => "1",
        ]);
    }
}
