<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedores extends Model
{
  use SoftDeletes;
  protected $table    = 'proveedores';
  protected $fillable = ['id', 'proveedor', 'rubro', 'entidad', 'responsable', 'ciudad', 'direccion', 'telefono', 'correo_electronico', 'nit', 'id_usuario', 'id_gestion'];
  protected $dates    = ['deleted_at'];
}
