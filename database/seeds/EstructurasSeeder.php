<?php

use Illuminate\Database\Seeder;

class EstructurasSeeder extends Seeder
{

    public function run()
    { //Unidades Administrativas



      $datos = [
       [ 'codigoEstructura'=>'000000', 'estructura'=>'Operador Externo', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'200000', 'estructura'=>'H. Concejo Municipal', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300000', 'estructura'=>'Ejecutivo Municipal', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],

       [ 'codigoEstructura'=>'300010', 'estructura'=>'Secretaria Despacho', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300011', 'estructura'=>'Secretaria 2 Despacho', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300012', 'estructura'=>'Responsable de Archivo y Apoyo', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300091', 'estructura'=>'Sub Alacaldia Distrito 1', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300092', 'estructura'=>'Sub Alcaldia Distrito 2', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300093', 'estructura'=>'Sub Alcaldia Distrito 3', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300094', 'estructura'=>'Sub Alcaldia Distrito 4', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300005', 'estructura'=>'Sub Alcaldia Distrito 5', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300096', 'estructura'=>'Sub Alcaldia Distrito 6', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300099', 'estructura'=>'Sub Alcaldia Distrito 10', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300002', 'estructura'=>'Auditoria Interna', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300020', 'estructura'=>'Asesoria Legal', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300021', 'estructura'=>'Asistente Legal', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'310000', 'estructura'=>'Oficial Mayor de Apoyo a la Producción', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'320000', 'estructura'=>'Oficial mayor Técnico', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'330000', 'estructura'=>'Oficial mayor Administrativo', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'311000', 'estructura'=>'Técno Agropecuario Municipal', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'312000', 'estructura'=>'Técnico MIPES y OECAS', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'313000', 'estructura'=>'Técnico Medio Ambienbte Forestal', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'314000', 'estructura'=>'Técnico Desastres Naturales', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'311100', 'estructura'=>'Responsable Hornato Público y Viveros M.', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'311110', 'estructura'=>'Obreros', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'320001', 'estructura'=>'Auxiliar Of. Mayor Técnico', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300002', 'estructura'=>'Técnicos Supervisión de Obras', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'322000', 'estructura'=>'Unidad de Catastro Urbano', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'321000', 'estructura'=>'Responsable de Tranpsortes', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'321100', 'estructura'=>'Choferes', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'321200', 'estructura'=>'Operadores Maquinaria Pesada', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'322001', 'estructura'=>'Responsable de Sistemas', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'322002', 'estructura'=>'Topografia y Servicio Técnico', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'322100', 'estructura'=>'Asistente de Catastro', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'323000', 'estructura'=>'Responsable de Srvicios Municipales', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'323100', 'estructura'=>'Encargado CEmenterio General', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'323200', 'estructura'=>'Obreros de Servicio Público', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'323300', 'estructura'=>'Responsable Metalmecánica', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'323400', 'estructura'=>'Responsable de Carpinteria', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'330010', 'estructura'=>'Personal y Recc. Humanos', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'330011', 'estructura'=>'Sereno Mensajero', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'330012', 'estructura'=>'Sereno Mensajero', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'330013', 'estructura'=>'Sereno Usina Antigua', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'331000', 'estructura'=>'Dirección de Cultura Turismo y Deportes', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'331100', 'estructura'=>'Responsable CIAT', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'331200', 'estructura'=>'Relaciones Públicas', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'331300', 'estructura'=>'Respoable Archivo Histórico y Museo', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'335000', 'estructura'=>'Alumbrado Público', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'335100', 'estructura'=>'Chofer Alumbrado Público', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'336000', 'estructura'=>'Inspectoria Sanitaria', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'337000', 'estructura'=>'Intendencia', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'337100', 'estructura'=>'Comisaria', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'337200', 'estructura'=>'Vigilantes Municipales', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'338000', 'estructura'=>'Administración Mercado Gil Durán Terminal', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'338100', 'estructura'=>'Sereno Terminal', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'338200', 'estructura'=>'Sereno Gil Duran', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'339000', 'estructura'=>'Auxiliar Administrativo', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'332000', 'estructura'=>'Dirección de Planificación', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'332100', 'estructura'=>'Responsable Programas y Seguimiento', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'333000', 'estructura'=>'Dirección de Finanzas', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'333100', 'estructura'=>'Auxiliar de Finanzas', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'333100', 'estructura'=>'Contabilidad', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'333200', 'estructura'=>'Presupuesto', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'333300', 'estructura'=>'Tesorería', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'333110', 'estructura'=>'Almacenes', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'333120', 'estructura'=>'Activos Fijos', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'333210', 'estructura'=>'Cotizaciones', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'333220', 'estructura'=>'Adquisiciones', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'333310', 'estructura'=>'Liquidador', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'333320', 'estructura'=>'Cajero', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'333330', 'estructura'=>'Recaudación y Fiscalización', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'330001', 'estructura'=>'Auxliar de Of.Mayor Administrativo', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'334000', 'estructura'=>'Dir.de Salud y Educacion ', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'334100', 'estructura'=>'Tecnico Salud y Educacion', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'334200', 'estructura'=>'Aux. Salud y Educacion', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'334001', 'estructura'=>'Resp. Programa PAN', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'334020', 'estructura'=>'Asesoria S.L.I. y D.N.A.', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'334021', 'estructura'=>'Sigologa ', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'334022', 'estructura'=>'Trabajadora Social', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'334300', 'estructura'=>'Resp. Biblioteca', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300191', 'estructura'=>'Sub Alcaldia Distrito - 11', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'300192', 'estructura'=>'Sub Alcaldia Distrito - 12', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'340000', 'estructura'=>'LOURDES GRANJEDA', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'340000', 'estructura'=>'COMUNICACION SOCIAL', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'323500', 'estructura'=>'Encargado De Archivo General', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],
       [ 'codigoEstructura'=>'250001', 'estructura'=>'Capacitacion De Mujeres Productivas', 'id_estructura'=>'1', 'id_usuario'=>'1', 'id_gestion'=>'1 ' ],




        ];

      foreach($datos as $est){
          \App\Estructuras::create($est);
      }

    }
}
