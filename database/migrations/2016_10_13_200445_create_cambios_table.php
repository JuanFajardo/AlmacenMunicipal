<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCambiosTable extends Migration
{
  public function up()
  {

    Schema::create('cambios', function(Blueprint $table){
      $table->increments('id');
      $table->date('fecha')->comment('Fecha de insersion de los datos Ej 2016-01-01');
      $table->float('compra')->comment('Compra de dolar');
      $table->float('venta')->comment('Venta de dolar');
      $table->decimal('ufv', 6, 5)->comment('Precio del UFV');
      $table->string('automatico',2)->comment('SI y NO');
      $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
      $table->softDeletes();
      $table->timestamps();
    });
  }

  public function down()
  {
      Schema::drop('cambios');
  }
}
