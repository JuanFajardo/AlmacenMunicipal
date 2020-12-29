<?php

use Illuminate\Database\Seeder;

class UnidadesSeeder extends Seeder
{

    public function run()
    {
      $datos = [
      ['unidad'=>'Balde', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Barras', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Bidon', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Blocks', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Bolsas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Botellas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Botes', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Cajas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Cajitas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Capsulas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Carrete', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'CC', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Comprimido', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Conos', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Docenas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Dosis', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Estuches', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Frascos', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Galones', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Global', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Gramos', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Hojas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Juegos', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Kilos', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Kit', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Kits', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Laminas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Latas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Libras', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Libros', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Litros', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'M2', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Metros', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Metros2', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Metros3', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'ML', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Metros Lineales', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Paquetes', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Pares', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Pie 2', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Piezas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'plantines', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Pliegos', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Pomos', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Quintales', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Raciones', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Revistas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Rollos', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Sachet', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Sobres', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Tabletas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Tacho', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Talonarios', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Tambor', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Tomos', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Tubos', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Turril', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Unidades', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      ['unidad'=>'Volquetas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
        ];

      foreach($datos as $est){
          \App\Unidades::create($est);
      }

    }
}
