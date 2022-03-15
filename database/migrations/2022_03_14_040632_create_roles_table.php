<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->unique();
            $table->string('slug')->unique();
            $table->string('descripcion')->nullable();
            $table->enum('acceso_completo', ['SI', 'NO'])->nullable();
            $table->timestamps();
        });
    }

    /*
    * Nota
    * Campo: acceso_completo => si el campo acceso_completo esta en "SI" es considerado un rol admin
    * 
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
