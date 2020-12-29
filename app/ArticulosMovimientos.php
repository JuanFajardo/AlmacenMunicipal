<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticulosMovimientos extends Model
{
  use SoftDeletes;
  protected $table    = 'articulos_movimientos';
  protected $fillable = ['id', 'movimiento', 'cantidad', 'cantidad_actual', 'cerrado_gestion', 'costo', 'total', 'costo_actual', 'total_actual', 'observacion', 'id_movimiento', 'id_apertura', 'id_clasificador', 'id_bien', 'id_usuario', 'eliminacion', 'fecha_eliminacion', 'id_gestion'];
  protected $dates    = ['deleted_at'];
}
