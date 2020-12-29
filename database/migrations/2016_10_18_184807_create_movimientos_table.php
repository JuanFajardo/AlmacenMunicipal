<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
  public function up()
  {
      Schema::create('movimientos', function(Blueprint $table){
        $table->increments('id');
        $table->string('movimiento', 50)->comment('Salida Entrada Stock_Entrada Stock_Salida');
        $table->string('nro_moviento')->comment('es el numero de ingreso o salida reiniciado por año');
        $table->date('fecha');
        $table->smallInteger('anio');
        $table->tinyInteger('mes');
        $table->tinyInteger('dia');
        $table->string('cerrado_gestion')->comment('SI/NO');

        $table->string('codigo_informe', 50);
        $table->string('codigo_pedido', 50);
        $table->string('codigo_tramite', 50);

        $table->string('auxiliar', 50)->comment('Para indicar si aprueba');

        $table->string('rupe', 50)->comment('INGRESO');
        $table->string('orden_compra', 50)->comment('INGRESO/INGRESO STOCK');
        $table->text('glosa_entrada')->comment('INGRESO/INGRESO STOCK');
        $table->text('glosa_salida')->comment('SALIDA/SALIDA STOCK');
        $table->text('motivo')->comment('salio /Verifica la salida del movimeinto');

        $table->string('tipo_factura', 50);
        $table->string('numero_factura', 100);
        $table->float('total_factura');
        $table->string('otro_documento', 100);

        $table->text('eliminacion')->comment('Verifica si esta eliminado');
        $table->date('fecha_eliminacion')->comment('la fecha de elminacion');

        $table->integer('id_almacen')->references('id')->on('almacenes')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_cambio')->references('id')->on('cambios')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_concepto')->references('id')->on('conceptos')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_proveedor')->references('id')->on('proveedores')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_funcionario')->references('id')->on('funcionarios')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('movimiento_ingreso');
        $table->integer('id_usuario')->references('id')->on('users')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->integer('id_gestion')->references('id')->on('gestiones')->onUpdate('cascade'|'restrict'|'set null'|'no action');
        $table->softDeletes();
        $table->timestamps();
      });
  }

  public function down()
  {
    Schema::drop('movimientos');
  }
}
