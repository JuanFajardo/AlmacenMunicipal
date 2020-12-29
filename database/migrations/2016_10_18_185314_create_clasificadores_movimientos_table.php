<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasificadoresMovimientosTable extends Migration
{
    public function up()
    {
        Schema::create('clasificadores_movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('movimiento', 50)->comment('Salida Entrada Stock_Entrada Stock_Salida');
            $table->integer('id_movimiento')->references('id')->on('movimientos')->onUpdate('cascade'|'restrict'|'set null'|'no action');
            $table->integer('id_apertura')->references('id')->on('aperturas')->onUpdate('cascade'|'restrict'|'set null'|'no action');
            $table->integer('id_clasificador')->references('id')->on('clasificadores')->onUpdate('cascade'|'restrict'|'set null'|'no action');
            $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
            $table->text('eliminacion')->comment('Verifica si esta eliminado');
            $table->dateTime('fecha_eliminacion')->comment('la fecha de elminacion');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('clasificadores_movimientos');
    }
}
