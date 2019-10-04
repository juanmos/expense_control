<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoRefrigeriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_refrigerios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('institucion_id');
            $table->string('tipo');
            $table->text('descripcion')->nullable();
            $table->decimal('costo',10,2)->default(0);
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
        Schema::dropIfExists('tipo_refrigerios');
    }
}
