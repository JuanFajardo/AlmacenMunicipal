<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{


    use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    protected $redirectTo = '/';


    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'nombreCompleto' => 'required|max:255',
            'ci' => 'required',
            'grupo' => 'required',
            'password' => 'required|min:6|confirmed',
            'id_usuario' => 'required',
        ]);
    }


    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'nombreCompleto' => $data['nombreCompleto'],
            'ci' => $data['ci'],
            'grupo' => $data['grupo'],
            'password' => bcrypt($data['password']),
            'id_usuario' => \Auth::user()->id,
        ]);
    }
}
