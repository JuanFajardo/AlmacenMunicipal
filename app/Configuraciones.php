<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configuraciones extends Model
{
  use SoftDeletes;
  protected $table    = 'configuraciones';
  protected $fillable = ['id', 'entidad', 'direccion', 'telefono', 'ruc', 'factura', 'id_usuario'];
  protected $dates    = ['deleted_at'];
}
