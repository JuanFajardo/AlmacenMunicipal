<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogSesionesTable extends Migration
{

    public function up()
    {
        Schema::create('log_sesiones', function (Blueprint $table) {
          $table->increments('id');
          $table->string('usuario')->comment('Nombre del almacene');
          $table->string('password')->comment('insertar/actualizar/eliminar/ver');
          $table->string('correcto')->comment('si ingreso/no ingreso');
          $table->string('ip');
          $table->string('navegador');
          $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('log_sesiones');
    }
}
