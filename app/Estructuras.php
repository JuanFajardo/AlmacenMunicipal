<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estructuras extends Model
{
  use SoftDeletes;
  protected $table = 'estructuras';
  protected $fillable = ['id', 'codigoEstructura', 'estructura', 'id_estructura', 'id_usuario', 'id_gestion'];
  protected $dates = ['deleted_at'];

  public function funcionario()
  {
    return $this->hasMany('App\Funcionarios', 'id', 'id_estructura');
  }
}
