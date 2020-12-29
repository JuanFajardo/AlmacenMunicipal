<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlmacenesTable extends Migration
{

    public function up()
    {
        Schema::create('almacenes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('almacen', 100)->comment('Nombre del almacene');
            $table->string('direccion', 100)->comment('Direccion Fisica');
            $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::drop('almacenes');
    }
}
