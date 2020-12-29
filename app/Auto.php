<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    protected $table = 'autos';
    protected $filable = ['id', 'placa', 'tipo', 'modelo', 'color', 'id_usuario'];
}
