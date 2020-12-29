<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configuraciones extends Model
{
  use SoftDeletes;
  protected $table    = '';
  protected $fillable = [];
  protected $dates    = [];
}
