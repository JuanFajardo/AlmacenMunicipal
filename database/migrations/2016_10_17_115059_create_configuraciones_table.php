<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionesTable extends Migration
{
  public function up()
  {
      /*
      Tabla para configurar datos de la instutcion para hacerlo de manera global
      */
      Schema::create('configuraciones', function(Blueprint $table){
        $table->increments('id');
        $table->string('entidad',300);
        $table->string('direccion',300);
        $table->string('telefono',50);
        $table->string('ruc',50);
        $table->string('factura',50);

        $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->softDeletes();
        $table->timestamps();
      });
  }

  public function down()
  {
      Schema::drop('configuraciones');
  }
}
