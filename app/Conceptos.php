<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conceptos extends Model
{
  use SoftDeletes;
  protected $table = 'conceptos';
  protected $fillable = ['id', 'tipo', 'concepto', 'id_usuario', 'id_gestion'];
  protected $dates = ['deleted_at'];
}
