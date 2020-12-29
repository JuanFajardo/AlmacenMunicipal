@extends('sisoftComBo')

@section('reportes')
active
@endsection

@section('reportes1')
active
@endsection


@section('contenido')
<div class="warper container-fluid">
            <div class="row">
              <div class="col-lg-12">
              <h3><i class="fa  fa-list-alt"></i> Reporte Personalizado de Movimientos</h3>
                {!! Form::open(['accept-charset'=>'UTF-8', 'autocomplete'=>'off', 'method'=>'POST', 'id'=>'form-insert'] ) !!}
                <table class="table table-bordered table-striped" width="100%">
                  <tr>
                    <td width="20%">
                      <label>Almacen</label>
                      {!! Form::select('almacenes', \App\Almacenes::lists('almacen', 'id'), null, ['class'=>'form-control', 'required','placeholder'=>'']) !!}
                    </td>
                    <td>
                      <label>Apertura Programatica</label>
                      {!! Form::select('aperturas', \App\Aperturas::lists('apertura', 'id'), null, ['class'=>'form-control', 'placeholder'=>'']) !!}
                    </td>
                    <td>
                      <label>Partida Clasificatoria  </label>
                      {!! Form::select('clasificadores', \App\Clasificadores::lists('clasificador', 'id'), null, ['class'=>'form-control', 'placeholder'=>'']) !!}
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label>Movimiento </label>
                      {!! Form::select('movimientos', ['1'=>'INGRESO', '2'=>'SALIDA', '4'=>'INGRESO STOCK', '5'=>'SALIDA STOCK'], null, ['class'=>'form-control', 'placeholder'=>'']) !!}
                    </td>
                    <td>
                      <label>Funcionarios      </label>
                      {!! Form::select('funcionarios',  \App\Funcionarios::select(\DB::raw("concat(nombres, ' ',  paterno, ' ', materno) AS nombres, id"))->lists('nombres', 'id'), null, ['class'=>'form-control', 'placeholder'=>'']) !!}
                    </td>
                    <td>
                      <label>Proveedores       </label>
                      {!! Form::select('proveedores',   \App\Proveedores::lists('proveedor',  'id'), null, ['class'=>'form-control', 'placeholder'=>'']) !!}
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <label> Gestion         </label>
                      {!! Form::select('gestion',      \App\Gestiones::lists('gestion', 'id'), null, ['class'=>'form-control']) !!}
                    </td>
                    <td>
                      <div>
                        <label>Fecha Inicio</label>
                        <div class='input-group date' >
                          <input type='text' class="form-control col-md-3" name="fecha_inicio" id="fecha_inicio" required/>
                          <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                      </div>
                    </td>
                    <td >
                      <div>
                        <label>Fecha Fin</label>
                        <div class='input-group date' >
                          <input type='text' class="form-control col-md-3" name="fecha_fin" id="fecha_fin" required/>
                          <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr style="background-color:#00BCD4; color:#fff;">
                    <td colspan="3">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td> </td>
                          <b>SELECCIONE LAS COLUMNAS A MOSTRAR EN EL REPORTE</b>
                        </tr>
                        <tr>
                          <td>
                            <center>
                              <label for=""> Movimiento</label>
                              <input type="checkbox" name="movimiento" value="1" class="form-control" >
                            </center>
                          </td>
                          <td>
                            <center>
                              <label for=""> Numero de Movimiento</label>
                              <input type="checkbox" name="nro_moviento" value="1" class="form-control" >
                            </center>
                          </td>
                          <td>
                            <center>
                              <label for=""> Fecha</label>
                              <input type="checkbox" name="fecha" value="1" class="form-control" >
                            </center>
                          </td>
                          <td>
                            <center>
                            <label for="">Apertura Programatica</label>
                            <input type="checkbox" name="apertura" value="1" class="form-control" >
                            </center>
                          </td>
                          <td>
                            <center>
                            <label for="">Partida Clasificatoria</label>
                            <input type="checkbox" name="clasificador" value="1" class="form-control" >
                            </center>
                          </td>
                          <td>
                            <center>
                              <label for=""> Rupe</label>
                              <input type="checkbox" name="rupe" value="1" class="form-control" >
                            </center>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <center>
                              <label for=""> Codigo Pedido</label>
                              <input type="checkbox" name="codigo_pedido" value="1" class="form-control" >
                            </center>
                          </td>
                          <td>
                            <center>
                              <label for=""> Codigo Informe</label>
                              <input type="checkbox" name="codigo_informe" value="1" class="form-control" >
                            </center>
                          </td>
                          <td>
                            <center>
                              <label for=""> Orden Compra</label>
                              <input type="checkbox" name="orden_compra" value="1" class="form-control">
                            </center>
                          </td>
                          <td>
                            <center>
                            <label for=""> Otro Documento</label>
                            <input type="checkbox" name="otro_documento" value="1" class="form-control">
                            </center>
                          </td>
                          <td>
                            <center>
                            <label for=""> Nro. Tramite</label>
                            <input type="checkbox" name="codigo_tramite" value="1" class="form-control">
                            </center>
                          </td>
                          <td>
                            <center>
                              <label for=""> Tipo Factura</label>
                              <input type="checkbox" name="tipo_factura" value="1" class="form-control">
                            </center>
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <center>
                              <label for=""> Numero Factura</label>
                              <input type="checkbox" name="numero_factura" value="1" class="form-control">
                            </center>
                          </td>
                          <td>
                            <center>
                              <label for=""> Total Factura</label>
                              <input type="checkbox" name="total_factura" value="1" class="form-control">
                            </center>
                          </td>
                          <td>
                            <center>
                            <label for=""> Articulos</label>
                            <input type="checkbox" name="articulo" value="1" class="form-control">
                            </center>
                          </td>
                          <td>
                            <center>
                            <label for=""> Unidad</label>
                            <input type="checkbox" name="unidad" value="1" class="form-control">
                            </center>
                          </td>
                          <td>
                            <center>
                            <label for=""> UFV</label>
                            <input type="checkbox" name="ufv" value="1" class="form-control">
                            </center>
                          </td>
                          <td>
                            <center>
                            <label for=""> Dolar</label>
                            <input type="checkbox" name="dolar" value="1" class="form-control">
                            </center>
                          </td>

                        </tr>
                        <tr>

                          <td>
                            <center>
                            <label for=""> Motivo</label>
                            <input type="checkbox" name="id_concepto" value="1" class="form-control">
                            </center>
                          </td>

                          <td>
                            <center>
                            <label for=""> Proveedor</label>
                            <input type="checkbox" name="id_proveedor" value="1" class="form-control">
                            </center>
                          </td>
                          <td>
                            <center>
                            <label for=""> Funcionario</label>
                            <input type="checkbox" name="id_funcionario" value="1" class="form-control">
                            </center>
                          </td>
                          <td>
                            <center>
                            <label for=""> Usuario</label>
                            <input type="checkbox" name="id_usuario" value="1" class="form-control">
                            </center>
                          </td>
                          <td>
                            <center>
                              <label for=""> Glosa</label>
                              <input type="checkbox" name="glosa" value="1" class="form-control">
                            </center>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">
                      <button type="submit" name="button" class="btn btn-primary"> <i class="fa fa-file-pdf-o"></i> Sacar informe</button>
                      {!! Form::close() !!}
                    </td>
                  </tr>
                </table>


              </div>
            </div>
        </div>
@endsection
@section('js')
  <script type="text/javascript">
  $(document).ready(function(){
    $.fn.datetimepicker.defaults.language = 'es';
  });
  $(function () {
    $('#fecha_inicio').datetimepicker({ format: 'YYYY/MM/DD'});
  });
  $(function () {
    $('#fecha_fin').datetimepicker({ format: 'YYYY/MM/DD'});
  });
</script>
@endsection
