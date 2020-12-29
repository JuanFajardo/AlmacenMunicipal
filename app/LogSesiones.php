<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogSesiones extends Model
{
  protected $table = 'log_sesiones';
  protected $fillable = ['id', 'usuario', 'clave', 'correcto', 'ip', 'navegador'];
}
