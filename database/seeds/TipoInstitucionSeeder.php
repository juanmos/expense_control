<?php

use Illuminate\Database\Seeder;
use App\Models\TipoInstitucion;
class TipoInstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoInstitucion::create([
            'tipo'=>'Unidad Educativa'
        ]);
        TipoInstitucion::create([
            'tipo'=>'Persona Natural'
        ]);
        TipoInstitucion::create([
            'tipo'=>'Restaurant'
        ]);
    }
}
