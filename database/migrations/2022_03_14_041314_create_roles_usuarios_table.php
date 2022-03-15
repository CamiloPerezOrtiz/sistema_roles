<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('roles_id');
            $table->unsignedBigInteger('usuarios_id');
            
            $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('usuarios_id')->references('id')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('roles_usuarios');
    }
}
