<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aperturas extends Model
{
  use SoftDeletes;
  protected $table    = 'aperturas';
  protected $fillable = ['id', 'codigo', 'apertura', 'id_usuario', 'id_gestion', 'id_almacen', 'fuente', 'fuente_codigo', 'organismo', 'organismo_codigo'  ];
  protected $dates    = ['deleted_at'];
}
