<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Almacenes extends Model
{
  use SoftDeletes;
  protected $table    = 'almacenes';
  protected $fillable = ['id', 'almacen', 'direccion', 'id_usuario'];
  protected $dates    = ['deleted_at'];
}
