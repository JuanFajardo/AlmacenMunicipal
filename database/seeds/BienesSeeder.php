<?php

use Illuminate\Database\Seeder;

class BienesSeeder extends Seeder
{
    public function run()
    {

      $datos = [
      [  'codigo'=>'1', 'id_clasificador'=>'8', 'bien'=>'ARCHIVADOR A PALANCA T/OFICIO', 'id_unidad'=>'58', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'2', 'id_clasificador'=>'8', 'bien'=>'ARCHIVADORES RAPIDOS T/OFICIO', 'id_unidad'=>'41', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'3', 'id_clasificador'=>'8', 'bien'=>'COMPROBANTE DE CAJA CHICA', 'id_unidad'=>'41', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'4', 'id_clasificador'=>'8', 'bien'=>'CUADERBILLO CUADRICULADO', 'id_unidad'=>'58', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'5', 'id_clasificador'=>'8', 'bien'=>'CUADERNO CON ESPIRAL T/OFICIO', 'id_unidad'=>'58', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'6', 'id_clasificador'=>'8', 'bien'=>'CUADERNOS CON ESPIRAL TAMAÑO MEDIO OFICIO', 'id_unidad'=>'58', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'7', 'id_clasificador'=>'8', 'bien'=>'CUADRO COMPARATIVO DE COTIZACIONES', 'id_unidad'=>'4', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'8', 'id_clasificador'=>'8', 'bien'=>'ENTRADAS PARA FESTIVAL FLOLKLORICO FERIA DEL MAIZ', 'id_unidad'=>'53', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'9', 'id_clasificador'=>'8', 'bien'=>'FOLDERS DE CARTULINA T/OFICIO', 'id_unidad'=>'58', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'10', 'id_clasificador'=>'8', 'bien'=>'FORMULARIO Nº 5 NOTA DE RECEPCION', 'id_unidad'=>'4', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'11', 'id_clasificador'=>'8', 'bien'=>'INDICES ALFABETICOS', 'id_unidad'=>'23', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'12', 'id_clasificador'=>'8', 'bien'=>'NOTIFICACION DPTO.TECNICO', 'id_unidad'=>'4', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'13', 'id_clasificador'=>'8', 'bien'=>'ORDEN DE PAGO 100 X 1 NUMERADO', 'id_unidad'=>'4', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'14', 'id_clasificador'=>'8', 'bien'=>'PROVEIDO', 'id_unidad'=>'4', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'15', 'id_clasificador'=>'8', 'bien'=>'SOBRE MANILA DOBLE CARTA', 'id_unidad'=>'58', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'16', 'id_clasificador'=>'8', 'bien'=>'SOBRES MANILA TAMAÑO OFICIO', 'id_unidad'=>'41', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'17', 'id_clasificador'=>'8', 'bien'=>'SOBRES MENBRETADOS TAMAÑO OFICIO', 'id_unidad'=>'58', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
      [  'codigo'=>'18', 'id_clasificador'=>'8', 'bien'=>'SOLICITUD DE COTIZACIONES', 'id_unidad'=>'22', 'id_almacen'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1' ],


        ];

      foreach($datos as $est){
          \App\Bienes::create($est);
      }


    }
}
