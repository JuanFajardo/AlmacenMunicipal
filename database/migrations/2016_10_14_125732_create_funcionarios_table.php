<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionariosTable extends Migration
{
  public function up()
  {

      Schema::create('funcionarios', function(Blueprint $table){
        $table->increments('id');
        $table->date('fech_nacimiento');
        $table->string('nombres', 100);
        $table->string('paterno', 100);
        $table->string('materno', 100);
        $table->string('ci', 10);
        $table->string('telefono', 50)->nullable();
        $table->string('email', 50)->nullable();
        $table->string('zona', 50);
        $table->string('direccion', 50);

        $table->integer('id_estructura')->references('id')->on('estructuras')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_gestion')->references('id')->on('gestiones')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->softDeletes();
        $table->timestamps();

      });
  }

  public function down()
  {
    Schema::drop('funcionarios');
  }
}
