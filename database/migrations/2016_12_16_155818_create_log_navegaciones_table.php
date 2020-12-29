<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogNavegacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_navegaciones', function (Blueprint $table) {
          $table->increments('id');
          $table->string('direccion')->comment('Nombre del almacene');
          $table->string('accion')->comment('insertar/actualizar/eliminar/ver');
          $table->string('ip');
          $table->string('navegador');
          $table->string('usuario');
          $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('log_navegaciones');
    }
}
