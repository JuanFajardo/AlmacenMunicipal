<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstructurasTable extends Migration
{

    public function up()
    {
      Schema::create('estructuras', function(Blueprint $table){
        $table->increments('id');
        $table->string('codigoEstructura',50)->comment('Codigo interno de la estructura Ej. 00001');
        $table->string('estructura',300)->comment('Estructura  Ej. Alcalde');
        $table->integer('id_estructura')->comment('1');
        $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_gestion')->references('id')->on('gestiones')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->softDeletes();
        $table->timestamps();

      });
  }

  public function down()
  {
      Schema::drop('estructuras');
  }
}
