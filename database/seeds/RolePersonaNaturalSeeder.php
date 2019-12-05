<?php

use Illuminate\Database\Seeder;

class RolePersonaNaturalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name'=>'PersonaNatural',
            'guard_name'=>'web'
        ]);
        DB::table('roles')->insert([
            'name'=>'Restaurante',
            'guard_name'=>'web'
        ]);
    }
}
