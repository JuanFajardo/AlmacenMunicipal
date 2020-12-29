<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAperturasTable extends Migration
{
  public function up()
  {
      Schema::create('aperturas', function(Blueprint $table){
        $table->increments('id');
        $table->string('codigo', 50)->comment('codigo de la apertura');
        $table->string('apertura', 100)->comment('Nombre de la apertura');
        $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_gestion')->references('id')->on('gestiones')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->softDeletes();
        $table->timestamps();
      });
  }

  public function down()
  {
      Schema::drop('aperturas');
  }
}
