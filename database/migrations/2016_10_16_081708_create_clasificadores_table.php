<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasificadoresTable extends Migration
{
  public function up(){
  Schema::create('clasificadores', function(Blueprint $table){
    $table->increments('id');
    $table->integer('id_clasificador');
    $table->string('codigo', 100);
    $table->string('clasificador', 100);
    $table->text('descripcion');
    $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
    $table->integer('id_gestion')->references('id')->on('gestiones')->onUpdate('cascade'|'restrict'|'set null'|'no action');
    $table->softDeletes();
    $table->timestamps();
    });
  }

  public function down()
  {
    Schema::drop('clasificadores');
  }
}
