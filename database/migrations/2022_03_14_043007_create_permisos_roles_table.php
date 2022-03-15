<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisosRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('roles_id');
            $table->unsignedBigInteger('permisos_id');
            
            $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('permisos_id')->references('id')->on('permisos')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('permisos_roles');
    }
}
