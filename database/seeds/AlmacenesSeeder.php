<?php

use Illuminate\Database\Seeder;


class AlmacenesSeeder extends Seeder
{
    public function run()
    {
      $datos = [
    	   [ 'almacen'=>'Almacen Central','direccion'=>'Edificio Central', 'id_usuario'=>'1' ],
        ];

      foreach($datos as $est){
          \App\Almacenes::create($est);
      }
 	}
}
