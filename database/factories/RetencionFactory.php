<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Retencion;
use App\Models\ClienteInstitucion;
use Faker\Generator as Faker;

$factory->define(Retencion::class, function (Faker $faker) {
    return [
        'institucion_id'=>1,
        'cliente_id'=>factory(ClienteInstitucion::class),
        'fecha'=>now()->toDateString(),
        'establecimiento'=>'001',
        'puntoEmision'=>'001',
        'secuencial'=>'00000001',
        'tipoComprobante'=>'Retencion',
        'codigoTipoDocumento'=>7,
        'codigoComprobanteRecibido'=>1,
        'claveAcceso'=>'2784392849234892',
        'impuestos'=>'[{"valor": 1.6, "baseImponible": 80, "nombreImpuesto": "RENTA", "valorPorcentaje": 2}, {"valor": 6.72, "baseImponible": 9.6, "nombreImpuesto": "IVA", "valorPorcentaje": 70}]'
        //'impuestos'=>json_encode([["valor"=> 1.6, "baseImponible"=> 80, "nombreImpuesto"=> "RENTA", "valorPorcentaje"=> 2], ["valor"=> 6.72, "baseImponible"=> 9.6, "nombreImpuesto"=> "IVA", "valorPorcentaje"=> 70]])
    ];
});
