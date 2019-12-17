<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ClienteInstitucion;
use App\Models\Cliente;
use Faker\Generator as Faker;

$factory->define(ClienteInstitucion::class, function (Faker $faker) {
    return [
        'institucion_id'=>1,
        'nombre'=>$faker->company,
        'cliente_id'=>factory(Cliente::class),
    ];
});
