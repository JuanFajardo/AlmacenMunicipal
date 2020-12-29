<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clasificadores extends Model
{
  use SoftDeletes;
  protected $table    = 'clasificadores';
  protected $fillable = ['id', 'id_clasificador', 'codigo',  'clasificador', 'descripcion', 'id_usuario', 'id_gestion'];
  protected $dates    = ['deleted_at'];
}
