<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;


class InstaladorController extends Controller
{
    public function uno(){
      return view('instalador.uno');
    }

    public function dos(Request $request){

      $dsn = $request->DB_CONNECTION.':dbname='.$request->DB_DATABASE.';host='.$request->DB_HOST;
      $user = $request->DB_USERNAME;
      $password = $request->DB_PASSWORD;

      try {
          $dbh = new \PDO($dsn, $user, $password);

          $conexion = "<?php ";
          $conexion = $conexion . "return ['fetch' => PDO::FETCH_CLASS, 'default' => env('DB_CONNECTION', '".$request->DB_CONNECTION."'), ";
          $conexion = $conexion . "'connections' => [ ";
          $conexion = $conexion . "'mysql' => [ ";
          $conexion = $conexion . "'driver' => 'mysql', ";
          $conexion = $conexion . "'host' => '".$request->DB_HOST."', ";
          $conexion = $conexion . "'port' => '".$request->DB_PORT."', ";
          $conexion = $conexion . "'database' => '".$request->DB_DATABASE."', ";
          $conexion = $conexion . "'username' => '".$request->DB_USERNAME."', ";
          $conexion = $conexion . "'password' => '".$request->DB_PASSWORD."', ";
          $conexion = $conexion . "'charset' => 'utf8', ";
          $conexion = $conexion . "'collation' => 'utf8_unicode_ci', ";
          $conexion = $conexion . "'prefix' => '', ";
          $conexion = $conexion . "'strict' => false, ";
          $conexion = $conexion . "'engine' => null, ";
          $conexion = $conexion . "], ";
          $conexion = $conexion . "'pgsql' => [ ";
          $conexion = $conexion . "'driver' => 'pgsql', ";
          $conexion = $conexion . "'host' => '".$request->DB_HOST."', ";
          $conexion = $conexion . "'port' => '".$request->DB_PORT."', ";
          $conexion = $conexion . "'database' => '".$request->DB_DATABASE."', ";
          $conexion = $conexion . "'username' => '".$request->DB_USERNAME."', ";
          $conexion = $conexion . "'password' => '".$request->DB_PASSWORD."', ";
          $conexion = $conexion . "'charset' => 'utf8', ";
          $conexion = $conexion . "'prefix' => '', ";
          $conexion = $conexion . "'schema' => 'public', ";
          $conexion = $conexion . "], ";
          $conexion = $conexion . "], ";
          $conexion = $conexion . "'migrations' => 'migrations', ";
          $conexion = $conexion . "'redis' => [ ";
          $conexion = $conexion . "'cluster' => false, ";
          $conexion = $conexion . "'default' => [ ";
          $conexion = $conexion . "'host' => env('REDIS_HOST', 'localhost'), ";
          $conexion = $conexion . "'password' => env('REDIS_PASSWORD', null), ";
          $conexion = $conexion . "'port' => env('REDIS_PORT', 6379), ";
          $conexion = $conexion . "'database' => 0, ";
          $conexion = $conexion . "], ";
          $conexion = $conexion . "], ";
          $conexion = $conexion . "]; ";

          $archivo = fopen('../config/database.php', 'w');
          fwrite($archivo, $conexion);
          fclose($archivo);
          \Artisan::call('migrate');
          return view('instalador.dos');
      } catch (\PDOException $e) {
          return back()->withErrors(['Uno de los datos de conexion es INCORRECTO Intente nuevamente.']);
      }

    }

    public function tres(Request $request){

      \Artisan::call('db:seed');
      \DB::table('configuraciones')->insert([ 'id'=>'', 'entidad'=>$request->entidad, 'direccion'=>$request->direccion, 'telefono'=>$request->telefono, 'ruc'=>$request->ruc, 'factura'=>$request->factura, 'id_usuario'=>'1' ]);
      \DB::table('users')->insert([ 'id'=>'', 'name'=>$request->name, 'nombreCompleto'=>$request->nombreCompleto, 'ci'=>$request->ci, 'grupo'=>'1',        'id_almacen'=>'1', 'password'=>bcrypt($request->password) ]);
      $config = \DB::table('configuraciones')->first();
      $user = \DB::table('users')->first();
      return view('instalador.tres', compact('config', 'user') );
    }
}
