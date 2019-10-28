<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('factura_id');
            $table->string('codigo');
            $table->string('descripcion');
            $table->integer('cantidad');
            $table->decimal('precio_unitario',10,2)->default(0);
            $table->decimal('descuento',10,2)->default(0);
            $table->decimal('iva',10,2)->default(0);
            $table->decimal('precio',10,2)->default(0);
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
        Schema::dropIfExists('factura_detalles');
    }
}
