<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gestiones extends Model
{
  protected $table = 'gestiones';
  protected $fillable = ['id', 'gestion'];

  public static function gestion(){
    return \App\Gestiones::max('id');
  }
}
