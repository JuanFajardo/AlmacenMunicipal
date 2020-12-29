<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptosTable extends Migration
{
    public function up()
    {
      Schema::create('conceptos', function(Blueprint $table){
        $table->increments('id');
        $table->string('tipo')->comment('salida/entrada');
        $table->string('concepto', 300)->comment('Concepto Ej. Consumo');
        $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_gestion')->references('id')->on('gestiones')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->softDeletes();
        $table->timestamps();

      });
  }

  public function down()
  {
      Schema::drop('conceptos');
  }
}
