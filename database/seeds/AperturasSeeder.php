<?php

use Illuminate\Database\Seeder;


class AperturasSeeder extends Seeder
{
    public function run()
    {

      $datos = [

          ['codigo'=>'100000010', 'apertura'=>'Desarrollo Productivo D-IV', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'100000017', 'apertura'=>'Desarrollo Productivo D-VI', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'110000003', 'apertura'=>'Mantenimiento Sistemas de Agua Potable D-VI', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'110000005', 'apertura'=>'Mantenimiento Sistemas de Agua Potable D-IV', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'120000001', 'apertura'=>'Mantenimiento Sistemas de Micro Riego D-I', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'120000005', 'apertura'=>'Mantenimiento Sistemas de Micro Riego D-VI', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'130000001', 'apertura'=>'Ornamentacion y Mantenimiento de Areas Verdes', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'130000003', 'apertura'=>'Monitoreo y Difusion de Activiades Mineras Ambientales', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'130000002', 'apertura'=>'Manejo de Vivero Municipal', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'160000001', 'apertura'=>'Mantenimiento y Equipamiento de Alumbrado Publico', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'170000008', 'apertura'=>'Mantenimiento Terminal de Buses Ciudad de Tupiza', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'170000023', 'apertura'=>'Mantenimientos de Mercados Ciudad de Tupiza', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'170000009', 'apertura'=>'Mantenimiento Cementerio General Ciudad de Tupiza', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'170000002', 'apertura'=>'Mantenimiento Infraestructura Municipal Ciudad de Tupiza', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'170000001', 'apertura'=>'Mantenimiento Vias Urbanas Ciudad de Tupiza', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'170000004', 'apertura'=>'Supervision y Seguimiento de Proyecto D-II', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'170000026', 'apertura'=>'Mantenimiento de Infraestructura Municipal D-II', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'170000007', 'apertura'=>'Mantenimiento de Infraestructura Municipal D-VI', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'180000005', 'apertura'=>'Mantenimiento de Caminos Vecinales D-I', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'180000002', 'apertura'=>'Mantenimiento de Caminos Vecinales D-III', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'180000006', 'apertura'=>'Mantenimiento de Caminos Vecinales D-IV', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'180000003', 'apertura'=>'Mantenimiento de Caminos Vecinales D-VI', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'190000006', 'apertura'=>'Funcionamiento y Equipamiento Catastro Urbano Rural', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'200000029', 'apertura'=>'Operación Red Municipal SAFCI Tupiza', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'200000009', 'apertura'=>'Equipamiento, Mantenimiento y Seguros del Parque Automotor', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'200000020', 'apertura'=>'Dotacion Mobiliario y Equipamiento Centros de Salud de Municipio', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'200000022', 'apertura'=>'Mantenimiento Infraestructura de Salud Municipo de Tupiza', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'200000031', 'apertura'=>'Fortalecimiento de Salud Integral "Mi Salud"', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'210000022', 'apertura'=>'Alimentacion Complementaria Escolar Area Rural', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'210000023', 'apertura'=>'Alimentacion Complementaria Escolar Area Urbana', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'210000006', 'apertura'=>'Dotacion Mobiliario y Equipamiento U.E. de Municipio', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'210000010', 'apertura'=>'Mantemiento Infraestructura Educativa Municipio de Tupiza', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'210000013', 'apertura'=>'Olimpiadas Cientificas Estudiantiles Plurinacionales', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'220000003', 'apertura'=>'Juegos Deportivos Estudiantiles Plurinacionales', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'230000001', 'apertura'=>'Apoyo a la Cultura', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'240000007', 'apertura'=>'Promocion y Fomento al Turismo', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'250000002', 'apertura'=>'Apoyo a personas con Discapacidad', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'250000060', 'apertura'=>'Servicios Legales Integrales Municipales', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'260000002', 'apertura'=>'Defensoria de la Niñez', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'260000003', 'apertura'=>'Programa de Atencion a la Primera Infancia (PAPI) - Urbano', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'260000004', 'apertura'=>'Programa de Atencion a la Primera Infancia (PAPI) Distrito I', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'260000005', 'apertura'=>'Programa de Atencion a la Primera Infancia (PAPI) Distrito III', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'260000006', 'apertura'=>'Programa de Atencion a la Primera Infancia (PAPI) Distrito V', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'260000008', 'apertura'=>'Programa de Atencion a la Primera Infancia (PAPI) Distrito II', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'260000007', 'apertura'=>'Programa de Atencion a la Primera Infancia (PAPI) Distrito VI', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'270000001', 'apertura'=>'Mantenimiento del Parque Automotor', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'270000003', 'apertura'=>'Funcionamiento y Mantenimiento de Tractores Agricolas', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'270000002', 'apertura'=>'Mantenimiento Maquinaria Pesada', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'290000001', 'apertura'=>'Funcionamiento y Equipamiento Matadero Municipal', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'310000001', 'apertura'=>'Desastres Naturales Urbano y Rural', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'330000001', 'apertura'=>'Seguridad Ciudadana Ciudad de Tupiza', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'330000002', 'apertura'=>'Trafico y Viavilidad Ciudad de Tupiza', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'340000002', 'apertura'=>'Fortalecimiento Municipal', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'340000003', 'apertura'=>'Planificacion Participativa', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'340000004', 'apertura'=>'Asesoria Legal', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'340000010', 'apertura'=>'Funcionamiento y Equipamiento Intendencia Municipal', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'340000031', 'apertura'=>'Funcionamiento y Equipamiento Taller de Carpinteria', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'340000032', 'apertura'=>'Funcionamiento y Equipamiento Unidad de Transparencia', 'id_usuario'=>'1', 'id_gestion'=>'1' ],
          ['codigo'=>'999999997', 'apertura'=>'Salida de la Gestion Anterior', 'id_usuario'=>'1', 'id_gestion'=>'1' ],

        ];

      foreach($datos as $est){
          \App\Aperturas::create($est);
      }

    }
}
