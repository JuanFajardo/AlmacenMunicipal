<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcionarios extends Model
{
  use SoftDeletes;
  protected $table = 'funcionarios';
  protected $fillable = ['id', 'fech_nacimiento', 'nombres', 'paterno', 'materno', 'ci', 'telefono', 'zona', 'direccion', 'id_estructura', 'id_usuario', 'id_gestion'];
  protected $dates = ['deleted_at'];

  public function estructura()
  {
    return $this->belongsTo('App\Estructuras', 'id_estructura');
  }
}
