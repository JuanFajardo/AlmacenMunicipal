<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bienes extends Model
{
  use SoftDeletes;
  protected $table    = 'bienes';
  protected $fillable = ['id', 'codigo', 'bien', 'id_unidad', 'id_clasificador', 'id_almacen', 'id_usuario', 'id_gestion'];
  protected $dates    = ['deleted_at'];
}
