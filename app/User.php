<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $fillable = [
        'name', 'nombreCompleto', 'ci', 'grupo', 'id_almacen', 'password', 'id_usuario',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
