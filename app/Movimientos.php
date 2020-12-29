<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimientos extends Model
{
  use SoftDeletes;
  protected $table    = 'movimientos';
  protected $fillable = ['id', 'movimiento', 'nro_moviento', 'fecha', 'anio', 'mes', 'dia', 'cerrado_gestion', 'codigo_informe', 'codigo_pedido', 'codigo_tramite', 'auxiliar', 'rupe', 'orden_compra', 'glosa_entrada', 'glosa_salida', 'motivo', 'tipo_factura', 'numero_factura', 'total_factura', 'otro_documento', 'eliminacion', 'fecha_eliminacion', 'id_almacen', 'id_cambio', 'id_concepto', 'id_proveedor', 'id_funcionario', 'movimiento_ingreso', 'id_usuario', 'id_gestion'];
  protected $dates    = ['deleted_at'];
}
