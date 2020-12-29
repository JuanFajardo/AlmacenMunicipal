<?php

use Illuminate\Database\Seeder;

class ConceptosSeeder extends Seeder
{
    public function run()
    {
      $datos = [
      ['tipo'=>'Entrada', 'concepto'=>'Entrada por Cierre de Gestión', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['tipo'=>'Entrada', 'concepto'=>'Compra', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['tipo'=>'Entrada', 'concepto'=>'compra C.Chica', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['tipo'=>'Entrada', 'concepto'=>'Devolución', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['tipo'=>'Entrada', 'concepto'=>'Donación', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['tipo'=>'Entrada', 'concepto'=>'Producción', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['tipo'=>'Entrada', 'concepto'=>'Transferencia', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['tipo'=>'Entrada', 'concepto'=>'Inventario Inicial', 'id_usuario'=>'1', 'id_gestion'=>'1' ],

      ['tipo'=>'Salida', 'concepto'=>'Consumo', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['tipo'=>'Salida', 'concepto'=>'Devolución', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['tipo'=>'Salida', 'concepto'=>'Merma', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['tipo'=>'Salida', 'concepto'=>'Transferencias', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['tipo'=>'Salida', 'concepto'=>'Usos', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['tipo'=>'Salida', 'concepto'=>'Venta', 'id_usuario'=>'1', 'id_gestion'=>'1' ],



      ];

      foreach($datos as $est){
          \App\Conceptos::create($est);
      }

    }
}
