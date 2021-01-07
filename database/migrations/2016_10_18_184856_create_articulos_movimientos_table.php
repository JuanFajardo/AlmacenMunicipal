<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosMovimientosTable extends Migration
{
  public function up()
  {

      Schema::create('articulos_movimientos', function(Blueprint $table){
        $table->increments('id');
        $table->string('movimiento', 50)->comment('Salida Entrada Stock_Entrada Stock_Salida');
        $table->integer('cantidad');
        $table->integer('cantidad_actual');
        $table->string('cerrado_gestion')->comment('NO/SI');
        $table->double('costo', 16,8);
        $table->double('total', 16,8);
        $table->double('costo_actual', 16,8);
        $table->double('total_actual', 16,8);
        $table->text('observacion');
        $table->integer('id_movimiento')->references('id')->on('movimientos')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_apertura')->references('id')->on('aperturas')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_clasificador')->references('id')->on('clasificadores')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_bien')->references('id')->on('bienes')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_almacen')->references('id')->on('almacenes')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->text('eliminacion')->comment('Verifica si esta eliminado');
        $table->dateTime('fecha_eliminacion')->comment('la fecha de elminacion');
        $table->integer('id_gestion')->references('id')->on('gestiones')->onUpdate('cascade'|'restrict'|'set null'|'no action');

        $table->integer('id_funcionario')->nullable()->comment('Identificador del funcionario para gasolina');
        $table->integer('id_auto')->nullable()->comment('Identificador del auto para gasolina');
        $table->string('boleta')->nullable()->comment('Identificador de la boleta');


        $table->softDeletes();
        $table->timestamps();
      });
  }

  public function down()
  {
    Schema::drop('articulos_movimientos');
  }
}
