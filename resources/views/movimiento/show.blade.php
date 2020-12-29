@extends('sisoftComBo')

@section('contenido')
<div class="panel panel-default">

    <div class="panel-body">

      {!! Form::open(['autocomplete'=>'on']) !!}
        <div class="panel-heading clean">
          <h3 align="center">
            <span style="color: #D32F2F; padding: 15px; background-color: #B3E5FC; border-radius:10px; border-width: 15px; border:solid; border-color: #A09E9E; ">

                @if($movimientos->movimiento == 'INGRESO' || $movimientos->movimiento == 'SALIDA' )
                  <i class="fa fa-arrows" style="color: #A09E9E;"></i>  <b>{{$movimientos->movimiento}} NRO. {{ str_pad($movimientos->nro_moviento, 6, "0", STR_PAD_LEFT) }}</b>
                @else
                  <i class="fa fa-arrows" style="color: #A09E9E;"></i>  <b>{{$movimientos->movimiento}} NRO. {{$movimientos->nro_moviento}}</b>
                @endif
            </span>
          </h3>
        </div>

        <div class="form-group col-lg-4">
          <div class="col-lg-4">
            <label>FECHA:</label>
            <p>{{ date("d/m/Y", strtotime($movimientos->fecha))}}</p>
          </div>
        </div>
        <div class="form-group col-lg-4">
          <div class="col-lg-4">
            <label style="text-align: left;">MOTIVO:</label>
            <p style="text-align: left;"> {{$movimientos->concepto}} </p>
          </div>
        </div>
        <div class="form-group col-lg-4">
          <div class="col-lg-4">
            <label style="text-align: left;">USUARIO:</label>
            <p style="text-align: left;"> {{$movimientos->nombreCompleto}} </p>
          </div>
        </div>
        <div class="form-group col-lg-12">
          <h4><span class="glyphicon glyphicon-book col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-radius:10px;"><b> DOCUMENTOS </span></h4>
          @if( empty ($movimientos->codigo_pedido))
          @else
            <div class="col-lg-2">
              <label> <b>Nro. de Cheque:</b> </label>
              <p>{{$movimientos->codigo_pedido}} </p>
            </div>
          @endif
          @if( empty($movimientos->codigo_informe ))
          @else
            <div class="col-lg-3">
              <label> <b>Nro. de Informe:</b> </label>
              <p>{{$movimientos->codigo_informe}} </p>
            </div>
          @endif
          @if( empty ($movimientos->orden_compra ))
          @else
              <div class="col-lg-2">
                <label> <b>Nro. de Compra:</b> </label>
                <p>{{$movimientos->orden_compra}} </p>
              </div>
          @endif
          @if( empty($movimientos->rupe))
          @else
              <div class="col-lg-2">
                <label> <b>Rupe:</b> </label>
                <p>{{$movimientos->rupe}} </p>
              </div>
          @endif
          @if( empty($movimientos->otro_documento))
          @else
              <div class="col-lg-3">
                <label> <b>Otros Documentos:</b> </label>
                <p>{{$movimientos->otro_documento}} </p>
              </div>
          @endif
          @if( empty ($movimientos->codigo_tramite ))
          @else
              <div class="col-lg-3">
                <label> <b>Nro de Tramite:</b> </label>
                <p>{{$movimientos->codigo_tramite}} </p>
              </div>
          @endif
        </div>


        <div class="form-group col-md-12">
          <div class="row">
            <div class="col-md-6">
              <label> <b>Apertura Programatica: </b> </label> <br>
              @foreach($aperturas as $apertura)
                  {{ $apertura->codigo }} - {{ $apertura->apertura }}<br>
              @endforeach
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label> <b>Partida Clasificatoria: </b></label> <br>
                @foreach($clasificadores as $clasificador)
                  {{ $clasificador->codigo }} - {{ $clasificador->clasificador }} <br>
                @endforeach
            </div>
          </div>
        </div>


        <div class="form-group col-md-12">
          @if($movimientos->movimiento == "SALIDA" || $movimientos->movimiento == "SALIDA STOCK")
            <h4><span class="glyphicon glyphicon-user col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-top-left-radius: 10px; border-top-right-radius: 10px;"><b> FUNCIONARIO - ESTRUCTURA INSTITUCIONAL </span></h4> <br></br>
            @foreach( $funcionarios as $funcionario )
              @if( $funcionario->idFuncionario == $movimientos->id_funcionario )
              <p>{{$funcionario->nombres}} {{$funcionario->paterno}} {{$funcionario->materno}}   -  {{$funcionario->estructura}}</p>
              @endif
            @endforeach
          @endif
        </div>
        <div class="form-group col-md-12">
          @if($movimientos->movimiento == "INGRESO" || $movimientos->movimiento == "SALIDA" || $movimientos->movimiento == "INGRESO STOCK")
          <h4><span class="glyphicon glyphicon-barcode col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-radius:10px;"><b> PROVEEDOR</span></h4>
          <div class="col-lg-4">
            <label><b>Razon :</b></label>
            <p > {{$movimientos->proveedor}} </p>
          </div>
           <div class="col-lg-4">
            <label><b>Representante:</b></label>
            <p > {{$movimientos->responsable}} </p>
          </div>
           <div class="col-lg-4">
            <label><b>Nit:</b></label>
            <p > {{$movimientos->nit}} </p>
          </div>
          @endif
        </div>
        <div class="form-group col-md-12">
        @if($movimientos->movimiento == "INGRESO" || $movimientos->movimiento == "SALIDA" || $movimientos->movimiento == "INGRESO STOCK")
           <h4><span class="glyphicon glyphicon-list-alt col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-radius:10px;"><b> FACTURA</span></h4>
          <div class="col-lg-4">
            <label><b>Tipo:</b></label>
            <p > {{$movimientos->tipo_factura}} </p>
          </div>
          <div class="col-lg-4">
            <label><b>Nro. :</b></label>
            <p >  {{$movimientos->numero_factura}} </p>
          </div>
          <div class="col-lg-4">
            <label><b>Monto Total:</b></label>
            <p> {{ number_format($movimientos->total_factura, 2, ",", ".") }} </p>
          </div>
        @endif
        </div>


       <div class="form-group col-md-12">
          <table class="table table-striped" border="1px" style="font-size:12px;">

            <thead>
            <tr><th colspan="9" bgcolor="#D32F2F" style="color: white"> <center> Articulos</center></th></tr>
              <tr bgcolor="#F44336">
                <th  bgcolor="#D32F2F" width="2%" style="color: white;">Nro. </th>
                <th  bgcolor="#D32F2F" width="5%" style="color: white;">Aperturas</th>
                <th  bgcolor="#D32F2F" width="5%" style="color: white;">Codigo </th>
                <th  bgcolor="#D32F2F" width="20%" style="color: white;">Bien </th>
                <th  bgcolor="#D32F2F" width="8%" style="color: white;">Unidad</th>
                <th  bgcolor="#D32F2F" width="8%" style="color: white;">Precio Uni.</th>
                <th  bgcolor="#D32F2F" width="8%" style="color: white;">Cantidad</th>
                <th  bgcolor="#D32F2F" width="8%" style="color: white;">Precio Total</th>
              </tr>
            </thead>
          <tbody>
            <?php $i=0; $suma=0; ?>
            @foreach($articulosmovimientos as $articulosmovimiento)
              <?php $i++; ?>
              <tr>
                 <td>{{$i}}</td>
                 <td> {{ $articulosmovimiento->codigoApertura }} </td>
                 <td> {{ $articulosmovimiento->codigoClasificador }}.{{ $articulosmovimiento->id_almacen }}.{{ $articulosmovimiento->codigoBien }}</td>
                 <td> {{ $articulosmovimiento->bien}}</td>
                 <td> {{ $articulosmovimiento->unidad}}</td>
                 <td> {{ number_format($articulosmovimiento->costo, 2, ",", ".")}}</td>
                 @if($movimientos->movimiento == "INGRESO" || $movimientos->movimiento == "INGRESO STOCK")
                 <td> {{ $articulosmovimiento->cantidad_actual}}</td>
                 @endif
                 @if($movimientos->movimiento == "SALIDA" || $movimientos->movimiento == "SALIDA STOCK")
                 <td> {{ $articulosmovimiento->cantidad }}</td>
                 @endif
                 <td> {{ number_format($articulosmovimiento->total, 2, ",", ".") }}</td>
              </tr>
              <?php $suma=$suma+$articulosmovimiento->total; ?>
            @endforeach
                 <tr>
                  <td align="right" colspan="9">
                    <span style="font-size: 14;"><b>Total : </b> {{number_format($suma, 2, ",", ".")}} Bs.</span>
                  </td>
                  </tr>
          </tbody>
        </table>
        <br>
        <div class="form-group col-md-12">
          <h4><span class="glyphicon glyphicon-list col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-top-left-radius: 10px; border-top-right-radius: 10px;"><b> GLOSA / MOTIVO</span></h4>
            <textarea rows="2" cols="100" class="form-control" name="glosa_salida" required> {{$movimientos->glosa_entrada}} {{$movimientos->glosa_salida}} </textarea>
        </div>
        <input type="hidden"  name="id_movimiento" value="{{$movimientos->id}}">
        <input type="hidden"  name="movimiento" value="SALIDA">

        <div class="row">
          <div class="col-md-12"><br><br></div>
        </div>

        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-1">
            <a href="{{asset('index.php/Movimientos')}}" class="btn btn-info"> <i class="fa fa-reply" aria-hidden="true"></i> Atras</a>
          </div>
          @if($movimientos->grupo==3 and $movimientos->auxiliar== "NO" )
          <div class="col-md-1">
            <a href="{{asset('index.php/Movimiento/confirmar/'.$movimientos->IdM)}}" class="btn btn-success">
              <i class="fa fa-check" aria-hidden="true"></i> Confirmar </a>
          </div>
          @endif
        </div>
      {!! Form::close() !!}

      <div id="splineArea-chart" style="height:280px;"></div>
    </div>
</div>
@endsection
