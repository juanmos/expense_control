<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('cedula')->nullable();
            $table->string('foto')->default('images/default_user.png');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('token_and')->nullable();
            $table->string('token_ios')->nullable();
            $table->integer('institucion_id')->default(0);
            $table->boolean('activo')->default(1);
            $table->boolean('primer_login')->default(1);
            $table->decimal('latitud',16,10)->default(0);
            $table->decimal('longitud',16,10)->default(0);
            $table->string('codigo',500)->nullable()->unique();
            $table->rememberToken();
            $table->timestamps();
             $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
