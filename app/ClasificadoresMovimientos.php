<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClasificadoresMovimientos extends Model
{
  use SoftDeletes;
  protected $table    = 'clasificadores_movimientos';
  protected $fillable = ['id', 'movimiento', 'id_movimiento', 'id_apertura', 'id_clasificador', 'id_usuario', 'eliminacion', 'fecha_eliminacion'];
  protected $dates    = ['deleted_at'];
}
