<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBienesTable extends Migration
{
  public function up()
  {
     Schema::create('bienes', function(Blueprint $table){
       $table->increments('id');
       $table->integer('codigo')->comment('Codigo Corelativo de los bienes comenzando de 1 por cada clasificador');
       $table->string('bien', 50);
       $table->string('id_unidad')->references('id')->on('unidades')->onUpdate('cascade'|'restrict'|'set null'|'no action');
       $table->integer('id_clasificador')->references('id')->on('clasificadores')->onUpdate('cascade'|'restrict'|'set null'|'no action');
       $table->integer('id_almacen')->references('id')->on('almacenes')->onUpdate('cascade'|'restrict'|'set null'|'no action');
       $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
       $table->integer('id_gestion')->references('id')->on('gestiones')->onUpdate('cascade'|'restrict'|'set null'|'no action');
       $table->softDeletes();
       $table->timestamps();
     });
 }

 public function down()
 {
   Schema::drop('bienes');
 }
}
