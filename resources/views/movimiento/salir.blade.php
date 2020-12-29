@extends('sisoftComBo')

@section('contenido')
<div class="panel panel-default">
    <div class="panel-body">


      {!! Form::open(['method'=>'post', 'autocomplete'=>'off', 'url'=>'Movimientos/salir', 'id'=>'formEnvio' ]) !!}
        <div class="form-group">
          <div class="panel-heading clean" >
            <h3><i class="fa fa-external-link"></i> <b> SALIDA INMEDIATA N° {{$nro_moviento}} </b> </h3>
          </div>
        </div>
        <div class="form-group col-md-6">
          <div class="col-md-4">
              <label for="" class="control-label">Fecha de Salida</label><br>
              <div class='input-group date'>
                <input type='text' class="form-control" id='fecha'  value="{{$movimientos[0]->fecha}}" name="fecha" readonly="readonly" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label >Motivo de Salida :</label>
            <input type="text" name="id_concepto" class="form-control" list="id_concepto" placeholder="Motivo..."  required >
            <datalist id="id_concepto">
              @foreach($conceptos as $concepto)
                <option selected value="{{$concepto->concepto}}">
              @endforeach
            </datalist>
        </div>

        <div class="form-group col-md-12">
          <h4><span class="glyphicon glyphicon-book col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-radius:10px;"><b> DOCUMENTOS </span></h4>

          @if( empty($movimientos[0]->codigo_informe ))
          @else
            <div class="col-md-4">
              <label> <b>Nro. de Informe:</b> </label>
              <p>{{$movimientos[0]->codigo_informe}} </p>
            </div>
          @endif
          @if( empty ($movimientos[0]->orden_compra ))
          @else
              <div class="col-md-4">
                <label> <b>Nro. de Compra:</b> </label>
                <p>{{$movimientos[0]->orden_compra}} </p>
              </div>
          @endif
          @if( empty($movimientos[0]->rupe))
          @else
            <div class="col-md-4">
                <label> <b>PLACA:</b> </label>

                <?php $autos = \App\Auto::all(); ?>
                <select class="form-control" name="rupe" readonly>
                  <option value="0" selected> </option>
                  @foreach($autos as $auto)
                    @if( $movimientos[0]->rupe == $auto->id)
                    <option value="{{$auto->id}}" selected> Placa:{{$auto->placa}} Color: {{$auto->color}} Tipo: {{$auto->tipo}}</option>
                    @else
                    <option value="{{$auto->id}}" > Placa:{{$auto->placa}} Color: {{$auto->color}} Tipo: {{$auto->tipo}}</option>
                    @endif
                  @endforeach
                </select>

            </div>
        @endif
        @if( empty($movimientos[0]->otro_documento))
        @else
            <div class="col-md-6">
              <label> <b>Otros Documentos:</b> </label>
              <p>{{$movimientos[0]->otro_documento}} </p>
            </div>
        @endif
        @if( empty($movimientos[0]->codigo_pedido))
          @else
            <div class="col-md-6">
              <label> <b>Nro. de Pedido:</b> </label>
              <p>{{$movimientos[0]->codigo_pedido}} </p>
            </div>
          @endif
        @if( empty($movimientos[0]->codigo_tramite ))
        @else
            <div class="col-md-3">
              <label> <b>Nro de Tramite:</b> </label>
              <p>{{$movimientos[0]->codigo_tramite}} </p>
            </div>
        @endif
        </div>
        <div class="form-group col-md-12">
          <h4><span class="glyphicon glyphicon-barcode col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-radius:10px;"><b> PROVEEDOR</span></h4>
          <div class="col-lg-4">
            <label><b>Razon :</b></label>
            <p > {{$movimientos[0]->proveedor}} </p>
          </div>
           <div class="col-lg-4">
            <label><b>Representante:</b></label>
            <p > {{$movimientos[0]->responsable}} </p>
          </div>
           <div class="col-lg-4">
            <label><b>Nit:</b></label>
            <p > {{$movimientos[0]->nit}} </p>
          </div>
        </div>
        <div class="form-group col-md-12">
           <h4><span class="glyphicon glyphicon-list-alt col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-radius:10px;"><b> FACTURA</span></h4>
          <div class="col-lg-4">
            <label><b>Tipo:</b></label>
            <p > {{$movimientos[0]->tipo_factura}} </p>
          </div>
          <div class="col-lg-4">
            <label><b>Nro. :</b></label>
            <p >  {{$movimientos[0]->numero_factura}} </p>
          </div>
          <div class="col-lg-4">
            <label><b>Monto Total:</b></label>
            <p > {{number_format($movimientos[0]->total_factura, 2, ",", ".")}} </p>
          </div>
        </div>


        <div class="form-group col-md-12">
          <table class="table table-striped" border="1px" style="font-size:12px;">
            <thead>
              <tr> <th bgcolor="#D32F2F" width="2%" style="color: white;" colspan="9"><center> Articulos</center></th></tr>
              <tr bgcolor="#F44336">
                <th  bgcolor="#D32F2F" width="2%" style="color: white;">Nro. </th>
                <th  bgcolor="#D32F2F" width="10%" style="color: white;">Codigo </th>
                <th  bgcolor="#D32F2F" width="30%" style="color: white;">Bien </th>
                <th  bgcolor="#D32F2F" width="5%" style="color: white;">Medida</th>
                <th  bgcolor="#D32F2F" width="3%" style="color: white;">Cantidad</th>
                <th  bgcolor="#D32F2F" width="3%" style="color: white;">Precio Unit.</th>
                <th  bgcolor="#D32F2F" width="5%" style="color: white;">Total</th>
                <th  bgcolor="#D32F2F" width="20%" style="color: white;">Aperturas</th>
                <th  bgcolor="#D32F2F" width="20%" style="color: white;">Clasificadores</th>
              </tr>
            </thead>
            <tbody>
             <?php $i=0; ?>
              @foreach($articulosmovimientos as $articulosmovimiento)
                <?php $i++; ?>
                <tr>
                  <td> {{ $i}}</td>
                  <td> {{ $articulosmovimiento->codigoClasificador }}.{{ $articulosmovimiento->id_almacen }}.{{ $articulosmovimiento->codigoBien }}</td>
                  <td> {{ $articulosmovimiento->bien }}</td>
                  <td> {{ $articulosmovimiento->unidad }}</td>
                  <td> {{ $articulosmovimiento->cantidad }}</td>
                  <td> {{ number_format($articulosmovimiento->costo, 2, ",", ".") }}</td>
                  <td> {{ number_format($articulosmovimiento->total, 2, ",", ".") }}</td>
                  <td>
                     @foreach($aperturasMovimientos as $aperturasMovimiento)
                        {{$aperturasMovimiento->codigo}} {{$aperturasMovimiento->apertura}} <br>
                     @endforeach
                  </td>
                   <td>
                     @foreach($clasificadoresMovimientos as $clasificadoresMovimiento)
                          {{$clasificadoresMovimiento->codigo}} {{$clasificadoresMovimiento->clasificador}} <br>
                     @endforeach
                   </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <br>
        <div class="form-group col-md-12">
        <h4><span class="glyphicon glyphicon-user col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-top-left-radius: 10px; border-top-right-radius: 10px;"><b> FUNCIONARIO - ESTRUCTURA INSTITUCIONAL</span></h4>
            <input type="text" name="id_funcionario" id="id_funcionarios" class="form-control" placeholder="Escriba el funcionario" list="id_funcionario" required >
            <datalist id="id_funcionario">
            </datalist>
        </div>
        <div class="form-group col-md-12">
          <h4><span class="glyphicon glyphicon-list col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-top-left-radius: 10px; border-top-right-radius: 10px;"><b> GLOSA / MOTIVO</span></h4>
            <textarea rows="2" cols="100" class="form-control" name="glosa_salida" readonly="readonly"> *** INGRESO #{{$movimientos[0]->nro_moviento}}  *** {{$movimientos[0]->glosa_entrada}} </textarea>
        </div>

        <input type="hidden"  name="id_movimiento" value="{{$movimientos[0]->idMovimiento}}">
        <input type="hidden"  name="movimiento" value="SALIDA">

        <div class="row">
          <div class="col-md-12"><br><br></div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <button type="button" name="button" class="btn btn-primary" id="button">
              <i class="fa fa-plus-circle" aria-hidden="true"></i> Registrar Salida Inmediata
            </button>
          </div>
          <div class="col-md-3">
            <a href="{{asset('index.php/Movimientos')}}" class="btn btn-info"> <i class="fa fa-times-circle" aria-hidden="true"></i> Cancelar</a>
          </div>
        </div>
      {!! Form::close() !!}

      <div id="splineArea-chart" style="height:280px;"></div>
    </div>
</div>
@endsection


@section('js')
<script type="text/javascript">
  $(document).ready(function(){
    $.fn.datetimepicker.defaults.language = 'es';
  });
  $(function () {
    $('#fecha').datetimepicker({ format: 'YYYY-MM-DD'});
  });

  $('#id_funcionarios').focus(function(){
       var link = "{{asset('index.php/Funcionarios')}}";
       $.getJSON(link, null, function(data, textStatus) {
                 if(data.length>0){
                   var dato;
                   var bien = "#id_funcionario";
                   $(bien).empty();
                   $.each( data, function( key, el ) {
                     dato = el.id+' | '+ el.nombres+', '+el.paterno+', '+el.materno+' - '+el.estructura;
                      $(bien).append($('<option>', {
                         value: dato
                         //text: dato
                       }));
                   });
                 }
       });
    });

  $('#button').click(function(event) {
    event.preventDefault();
    if(confirm('REVISO LOS DATOS, PARA LA SALIDA INMEDIATA'))
    {
      $('#formEnvio').submit();
    }
  });
</script>
@endsection
