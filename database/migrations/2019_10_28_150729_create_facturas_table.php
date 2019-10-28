<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('datos_facturacion_id');
            $table->integer('pago_id');
            $table->integer('estado_id');
            $table->string('factura_no',30);
            $table->date('fecha');
            $table->decimal('subtotal',10,2)->default(0);
            $table->decimal('subtotal0',10,2)->default(0);
            $table->decimal('propina',10,2)->default(0);
            $table->decimal('descuento',10,2)->default(0);
            $table->decimal('servicio',10,2)->default(0);
            $table->decimal('iva',10,2)->default(0);
            $table->decimal('total',10,2)->default(0);
            $table->string('clave',60)->nullable();
            $table->string('autorizacion',60)->nullable();;
            $table->string('pdf')->nullable();
            $table->string('xml')->nullable();
            $table->tinyInteger('ambiente')->default(2);
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
        Schema::dropIfExists('facturas');
    }
}
