<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTable extends Migration
{
  public function up()
  {
    Schema::create('proveedores', function(Blueprint $table){
      $table->increments('id');
      $table->string('proveedor', 100)->comment('Nombre O Razon Social del proveedor Ej. Hermanos S.A.');
      $table->string('rubro', 100)->comment('A que rubro pertenece Ej. Manufactura');
      $table->string('entidad', 40)->comment('Empresas / Comerciantes Minoristas');
      $table->string('responsable', 300)->comment('Nombre completo del responsable Ej. Juan Perez Peres');
      $table->string('ciudad', 50);
      $table->string('direccion', 50)->nullable();
      $table->string('telefono', 50)->nullable();
      $table->string('correo_electronico',100)->nullable();
      $table->string('nit', 50)->nullable();

      $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
      $table->integer('id_gestion')->references('id')->on('gestiones')->onUpdate('cascade'|'restrict'|'set null'|'no action');
      $table->softDeletes();
      $table->timestamps();

    });
}

public function down()
{
  Schema::drop('proveedores');
}
}
