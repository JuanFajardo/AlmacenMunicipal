<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cambios extends Model
{
  use SoftDeletes;
  protected $table = 'cambios';
  protected $fillable = ['id', 'fecha', 'compra', 'venta', 'ufv', 'automatico', 'id_usuario'];
  protected $dates = ['deleted_at'];
}
