<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Institucion;
use Faker\Generator as Faker;

$factory->define(Institucion::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'tipo_institucion_id'=>2,
        'tipo_plan_id'=>2,
        'estado_id'=>2
    ];
});
