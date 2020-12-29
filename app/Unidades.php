<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unidades extends Model
{
  use SoftDeletes;
  protected $table    = 'unidades';
  protected $fillable = ['id', 'unidad', 'id_usuario', 'id_gestion'];
  protected $dates    = ['deleted_at'];

}
