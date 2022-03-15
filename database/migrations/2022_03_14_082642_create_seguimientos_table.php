<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeguimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('usuario');
            $table->string('rol');
            $table->tinyInteger('tipo_accion')->unsigned()->nullable();
            $table->text('accion')->nullable();
            $table->string('dispositivo');
            $table->string('plataforma');
            $table->string('plataforma_version');
            $table->string('navegador');
            $table->string('navegador_version');
            $table->string('ip_address');
            $table->timestamps();
        });
    }

    /**
     *  Nota
     *  Campo: tipo_accion
     *  1 = REGISTRO
     *  2 = VER
     *  3 = ACTUALIZACION
     *  4 = ELIMINACION
     *  5 = ERROR
     *  6 = ENVIO DE CORREO
     *  7 = LISTAR
     */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguimientos');
    }
}
