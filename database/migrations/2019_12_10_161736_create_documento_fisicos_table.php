<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoFisicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_fisicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('institucion_id');
            $table->enum('documento',['factura','compra','retencion'])->default('compra');
            $table->string('foto')->nullable();
            $table->string('cliente')->nullable();
            $table->string('ruc',20)->nullable();
            $table->decimal('subtotal',10,2)->default(0);
            $table->decimal('iva',10,2)->default(0);
            $table->decimal('propina',10,2)->default(0);
            $table->decimal('servicio',10,2)->default(0);
            $table->decimal('total',10,2)->default(0);
            $table->integer('categoria_id')->default(1);
            $table->integer('cliente_id')->default(0);
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
        Schema::dropIfExists('documento_fisicos');
    }
}
