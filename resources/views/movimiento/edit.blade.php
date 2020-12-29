@extends('sisoftComBo')

@section('contenido')
<div class="panel panel-default">

    <div class="panel-body">

      {!! Form::model($movimientos, ['action'=>['MovimientosController@actualizar', $movimientos->id], 'method'=>'PUT', 'id'=>'form-update' ]) !!}
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

            <div class="col-lg-2">
              <label> <b>Nro. de Cheque:</b> </label>
              {!! Form::text('codigo_pedido', null, ['class'=>'form-control', 'id'=>'codigo_pedido']) !!}
            </div>

            <div class="col-lg-3">
              <label> <b>Nro. de Informe:</b> </label>
              {!! Form::text('codigo_informe', null, ['class'=>'form-control', 'id'=>'codigo_informe']) !!}
            </div>

              <div class="col-lg-2">
                <label> <b>Nro. de Compra:</b> </label>
                {!! Form::text('orden_compra', null, ['class'=>'form-control', 'id'=>'orden_compra']) !!}
              </div>

              <div class="col-lg-2">
                <label> <b>Rupe:</b> </label>
                {!! Form::text('rupe', null, ['class'=>'form-control', 'id'=>'rupe']) !!}
              </div>

              <div class="col-lg-3">
                <label> <b>Otros Documentos:</b> </label>
                {!! Form::text('otro_documento', null, ['class'=>'form-control', 'id'=>'otro_documento']) !!}
              </div>

              <div class="col-lg-3">
                <label> <b>Nro de Tramite:</b> </label>
                {!! Form::text('codigo_tramite', null, ['class'=>'form-control', 'id'=>'codigo_tramite']) !!}
              </div>

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
           <h4><span class="glyphicon glyphicon-list-alt col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-radius:10px;"><b> FACTURA</span></h4>
          <div class="col-lg-4">
            <label><b>Tipo:</b></label>
            {!! Form::text('tipo_factura', null, ['class'=>'form-control', 'id'=>'tipo_factura']) !!}
          </div>
          <div class="col-lg-4">
            <label><b>Nro. :</b></label>
            {!! Form::text('numero_factura', null, ['class'=>'form-control', 'id'=>'numero_factura']) !!}
          </div>
          <div class="col-lg-4">
            <label><b>Monto Total:</b></label>
            <p> {{ number_format($movimientos->total_factura, 2, ",", ".") }} </p>
          </div>
        </div>

        {!! Form::submit('Actualizar Informacion', ['class'=>'btn btn-primary']) !!}
        {!! Form::close() !!}

</div>
@endsection
