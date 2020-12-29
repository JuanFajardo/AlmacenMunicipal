<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AperturasMovimientos extends Model
{
  use SoftDeletes;
  protected $table    = 'aperturas_movimientos';
  protected $fillable = ['id', 'id_movimiento', 'id_apertura', 'id_usuario', 'id_almacen', 'movimiento', 'eliminacion', 'fecha_eliminacion'];
  protected $dates    = ['deleted_at'];
}
