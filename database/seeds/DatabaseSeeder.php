<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PaisSeeder::class);
        $this->call(CiudadSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(InstitucionSeeder::class);
        $this->call(FormaPagoSeeder::class);
        $this->call(TipoTransaccionSeeder::class);
        $this->call(TipoTarjetaSeeder::class);
        
        $this->call(UsuarioSeeder::class);
    }
}
