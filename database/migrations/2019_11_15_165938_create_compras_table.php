<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('institucion_id');
            $table->integer('cliente_id');
            $table->date('fecha');
            $table->string('establecimiento')->nullable();
            $table->string('puntoEmision')->nullable();
            $table->string('secuencial')->nullable();
            $table->string('tipoComprobante')->nullable();
            $table->string('codigoTipoDocumento')->nullable();
            $table->string('codigoComprobanteRecibido')->nullable();
            $table->string('claveAcceso')->nullable();
            $table->decimal('total',10,2)->default(0);
            $table->decimal('totalSinImpuestos',10,2)->default(0);
            $table->decimal('propina',10,2)->default(0);
            $table->decimal('totalDescuento',10,2)->default(0);
            $table->json('impuestos')->nullable();
            $table->boolean('sincronizado')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
