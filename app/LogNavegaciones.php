<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogNavegaciones extends Model
{
  protected $table = 'log_navegaciones';
  protected $fillable = ['id', 'direccion', 'accion', 'ip', 'navegador', 'usuario'];
}
