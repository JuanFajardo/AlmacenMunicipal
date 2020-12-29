<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadesTable extends Migration
{
  public function up()
  {
    /* unidades
          id
          unidad
    */
    Schema::create('unidades', function(Blueprint $table){
      $table->increments('id');
      $table->string('unidad', 250);
      $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
      $table->integer('id_gestion')->references('id')->on('gestiones')->onUpdate('cascade'|'restrict'|'set null'|'no action');
      $table->softDeletes();
      $table->timestamps();
    });
}

  public function down()
  {
    Schema::drop('unidades');
  }
}
