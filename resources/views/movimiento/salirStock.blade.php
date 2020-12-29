@extends('sisoftComBo')

@section ('salida')
active
@endsection
@section ('salida1')
active
@endsection
@section('contenido')
<div class="panel panel-default">
    <div class="panel-heading clean">
      <h3><i class="fa fa-external-link-square"></i>  <b>{{$moviento}}   N° {{ $nro_moviento }}</b></h3>
    </div>
    <div class="panel-body">

        {!! Form::open(['url'=>'Movimiento/salidaStockS', 'mehtod'=>'post', 'id'=>'formEnvio', 'autocomplete'=>'off', 'id'=>'formEnvio']) !!}
        <input type="hidden" class="form-control"  name="n" value="{{$n}}">
        <input type="hidden" class="form-control"  name="nro_moviento" value="{{$nro_moviento}}">
        <input type="hidden" class="form-control"  name="movimiento" value="{{$moviento}}">
        <div class="row">
          <div class="form-group col-md-12">
            <h4><span class="glyphicon glyphicon-asterisk col-md-12" style="color: #0288D1; padding: 20px; background-color: #B3E5FC;"><b> FECHAS Y TIPOS DE SALIDAS </b></span> </h4>
            <div class="col-md-3">
              <label for="" class="control-label">Fecha de Movimiento</label><br>
              <div class='input-group date'>
                <input type='text' class="form-control" id='fecha' placeholder="Fecha de salida" name="fecha" required />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>
            <div class="col-md-3">
              <label for="" class="control-label">Motivo de Salida</label><br>
              <input type="text" id="id_conceptos" name="id_concepto" class="form-control" placeholder="Motivo de Salida" list="id_concepto"  required >
              <datalist id="id_concepto">
                @foreach($conceptos as $concepto)
                  <option  value=" {{$concepto->id}} | {{$concepto->concepto}}">
                @endforeach
              </datalist>
            </div>
          </div>

            <div class=" form-group col-md-12">
              <div class="row">
                <div class="col-md-12">
                  <h4><span class="glyphicon glyphicon-user col-md-12" style="color: #0288D1; padding: 20px; background-color: #B3E5FC;"><b> FUNCIONARIO SOLICITANTE</b></span> </h4>
                  <div class="col-md-6">
                    <label for="" class="control-label">Funcionario</label><br>
                    <input type="text" id="id_funcionarios" name="id_funcionario" class="form-control" placeholder="Escriba el funcionario" list="id_funcionario" required >
                    <datalist id="id_funcionario">
                    </datalist>
                  </div>
                </div>
              </div>
            </div>
            <div class=" form-group col-md-12">
              <div class="row">
              <div class="col-md-12">
              <h4><span class="glyphicon glyphicon-file col-md-12" style="color: #0288D1; padding: 20px; background-color: #B3E5FC;"><b> DOCUMENTOS</b></span> </h4>
                <div class="col-md-3">
                  <label for="" class="control-label">Tramite</label><br>
                  <input type="text" class="form-control"   name="codigo_tramite" required>
                </div>

                <div class="col-md-3">
                  <label for="" class="control-label">Pedido</label><br>
                  <input type="text" class="form-control"   name="codigo_pedido">
                </div>

                <div class="col-md-3">
                  <label for="" class="control-label">Informe</label><br>
                  <input type="text" class="form-control"   name="codigo_informe">
                </div>
                </div>
              </div>
            </div>
        </div>

        <div class="row">
          <div class="col-md-12">
          <table class="table table-striped" border="1">

            <thead  style="background-color:#D32F2F;">
              <tr style="color: white;">
                <th colspan="3"><center>Articulos de Salida Stock </center></th>
              </tr>
            </thead>
            <!-- Comenzando //////////////////////////////////////////////
            //////////////////////////////////////////////////////////////
            -->
            <tbody style="background-color:#607D8B;">
              <?php for($i=1; $i<=$n; $i++){ ?>
              <tr>
                  <td colspan="3">
                    <table width="100%">
                      <tr>
                        <td>
                          <label>Aperturas Programáticas</label>
                          <input type="text" id="id_apertura{{$i}}" class="form-control" placeholder="Aperturas Programaticas" multiple name="id_apertura{{$i}}" required  />
                        </td>
                        <td>
                          <label >Clasificadores Presupuestarios</label>
                          <input type="text" id="id_clasificador{{$i}}" class="form-control" placeholder="clasificadores Presupuestarios" multiple name="id_clasificador{{$i}}" required  />
                        </td>
                      </tr>
                    </table>
                  </td>
              </tr>

              <tr style="background-color:#607D8B;">
                <td style="background-color:#607D8B; color: white;">Buscar bienes</td>
                <td style="background-color:#607D8B; color: white;">Cantidad</td>
                <td style="background-color:#607D8B; color: white;">Acción</td>
              </tr>

              <tr>
                <td width="60%">
                  <input type="hidden" id="bien_{{$i}}" name="bien_{{$i}}" value="">
                  <input type="text" id="bien{{$i}}" class="form-control" placeholder="Buscar bienes" list="bienes{{$i}}">
                  <datalist id="bienes{{$i}}">
                  </datalist>
                </td>
                <td width="20%"> <input type="text" id="cantidad{{$i}}" class="form-control"  placeholder="Cantidad" > </td>
                <td width="20%"> <button type="button" id="agregar{{$i}}" class="btn btn-info"><i class="fa fa-plus-circle fa-2"> Insertar Artículo</i></button> </td>
              </tr>

              <tr style="background-color:#607D8B;">
                <td style="background-color:#607D8B;" colspan="3">
                  <table width="100%" class="table table-bordered">
                    <thead  style="background-color:#0288D1; color: white;">
                      <tr>
                        <th width="10%">Código</th>
                        <th width="35%">Artículo</th>
                        <th width="10%">Prec. Uni.</th>
                        <th width="15%">Cantidad</th>
                        <th width="15%">Total</th>
                        <th width="15%"> Acción </th>
                      </tr>
                    </thead>
                    <tbody id="articulos{{$i}}">
                    </tbody>
                  </table>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="col-md-12">
            <h4><span class="glyphicon glyphicon-list col-md-12" style="color: #0288D1; padding: 20px; background-color: #B3E5FC;"><b> GLOSA / MOTIVO</b></span></h4>
           <textarea class="form-control" ows="2" cols="100" class="form-control" name="glosa_salida" id="glosa_salida"  required ></textarea>
          </div>
        </div>
        <div class="rows">
          <div class="col-md-3">
            <!--<button type="button" data-toggle="modal" data-target="#myModal" name="button" id="button" class="btn btn-primary">
              <i class="fa fa-plus-circle" aria-hidden="true"></i>  Continuar
            </button>-->

            <a href="" class="btn btn-primary" data-dismiss="modal" id="button"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Continuar </a>

          </div>
          <div class="col-md-3">
            <a href="#/movimiento" class="btn btn-info"> <i class="fa fa-times-circle" aria-hidden="true"></i> Cancelar</a>
          </div>
        </div>
      {!! Form::close() !!}

      <div id="splineArea-chart" style="height:280px;"></div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content  panel panel-danger">
      <div class="modal-header  panel-heading">
      </div>
      <div class="modal-body  panel-body">
        <p>¿Reviso los datos introducidos? <br> ¿Esta seguro de introducir los datos? </p>
        <a href="#" class="btn btn-default" id="guardar"> Guardar</a>
        <a href="#" class="btn btn-default" data-dismiss="modal"> Cerrar </a>
      </div>
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
    $('#fecha').datetimepicker({ format: 'YYYY-MM-DD'});
  });

  $('#guardar').click(function(event){
    $('#formEnvio').submit();
  });

  <?php for($i=1; $i<=$n; $i++){ ?>
  var array{{$i}} = [];
  <?php } ?>

  $(document).ready(function(){
    <?php for($i=1; $i<=$n; $i++){ ?>
    $("#id_apertura{{$i}}").tokenInput([
      @foreach($aperturas as $apertura)
        {id: {{$apertura->id}}, name: "{{$apertura->codigo}} - {{$apertura->apertura}}"},
      @endforeach
      ], {tokenLimit:1});
    <?php } ?>
    $.fn.datetimepicker.defaults.language = 'es';
  });

  <?php for($i=1; $i<=$n; $i++){ ?>
  $("#id_clasificador{{$i}}").focus(function(){
    var apertura = $("#id_apertura{{$i}}").val();
    $("#id_clasificador{{$i}}").tokenInput("{{asset('index.php/Clasificadores/ver/JSON/list/')}}/"+apertura);
  });
  <?php } ?>

  <?php for($i=1; $i<=$n; $i++){ ?>
  $('#cantidad{{$i}}').blur(function(){
    var cant1 = $('#bien{{$i}}').val();
    cant1 = (cant1).split('|');
    cant1 = (cant1[4]).split(':');
    cant1 = cant1[1];
    var cant2 = $('#cantidad{{$i}}').val();
    if(cant2 <= cant1){
      alert('La cantidad ingresado es mayor, Ingresa otra cantidad menor');
      $('#cantidad{{$i}}').val(0);
    }
  });
  <?php } ?>

  function gastoTotal(){
    var suma = 0;
    var sumaCantidad = 0;
    var id;
    <?php for($i=1; $i<= $n; $i++){ ?>
      var n = array{{$i}}.length;
      for(i=0; i<n; i++){
        try { suma = suma + parseFloat( array{{$i}}[i][3] );
              sumaCantidad = sumaCantidad + parseFloat( array{{$i}}[i][1] );
        }
        catch(err) { console.log( "Error de sumatoria"); }
      }
      var id = $('#articulos{{$i}}');
      $(id).children('tr').remove();
      for (i=0; i<array{{$i}}.length; i++){
        try {
          html = "<tr style='color:#5e6271;'><td><b> " + array{{$i}}[i][5] + " </b> </td>"+
                                  "<td><b> " + array{{$i}}[i][6] + " </b></td>"+
                                  "<td> " + array{{$i}}[i][2] + " </td>"+
                                  "<td> "+array{{$i}}[i][1]+" </td>"+
                                  "<td> "+array{{$i}}[i][3]+" </td>"+
                                  "<td> <!--<div class='gastoTotal' ></div>--><a style='color:#ff404b;' onclick='eliminar({{$i}}, "+ i +")' > <i class='fa fa-trash-o'></i> Eliminar</a> </td>"+
                                  "</tr>";
         $(id).append(html);
       }catch(err) { console.log( "Error DE HTML"); }
      }
      html = "<tr style='color:#5e6271;'><td colspan='4'></td> <td  colspan='2'><div class='montoTotal' ></div></td> </tr>";
      $(id).append(html);
    <?php } ?>
    var facturaTotal = $('#total_factura').val();
    $('.montoTotal').html('Total: '+suma.toFixed(2)+' Bs.');
    $('.gastoTotal').html('Gasto: '+suma+'Bs. Cantidad: '+sumaCantidad);
  }

  function eliminar(array, posicion){
    <?php for($i=1; $i <= $n; $i++){ ?>
      if(array == {{$i}} ){
         array{{$i}}.splice(posicion, 1);
      }
    <?php } ?>
    gastoTotal();
  }

  <?php for($i=1; $i<=$n; $i++){ ?>
  $('#bien{{$i}}').focus(function(){
    var aperturas;
    var clasificadores;
    aperturas = $('#id_apertura{{$i}}').val();
    clasificadores = $('#id_clasificador{{$i}}').val();
    var link = "{{asset('index.php/Bienes/ver/JSON/listStock/')}}/"+clasificadores+"|"+aperturas;
    $('#bienes{{$i}}').children('option').remove();
    $.getJSON(link, null, function(data, textStatus) {
      if(data.length>0){
        var dato;
        $.each( data, function( key, el ) {
          dato = el.code+' | '+ el.clasificadorCode+'.'+el.almacenCode+'.'+el.bienCode +' | '+ el.name  +' | '+el.medida+' | Cantidad: '+el.cantidad +'| Precio Unitario: '+el.costo;
          $('#bienes{{$i}}').append($('<option>', {
            value: dato
          }));
        });
      }
    });
  });
  <?php } ?>

  <?php for($i=1; $i<=$n; $i++){ ?>
  var cont{{$i}}=0;
  $('#agregar{{$i}}').click(function(){
    if( ($('#bien{{$i}}').val()).length > 0 && ($('#cantidad{{$i}}').val()).length > 0){
      var cant1 = $('#bien{{$i}}').val();
      cant1 = (cant1).split('|');
      cant1 = (cant1[4]).split(':');
      cant1 = cant1[1];
      var cant2 = $('#cantidad{{$i}}').val();
      if( parseInt(cant2) > parseInt(cant1) ){
        alert('La cantidad ingresado es mayor, Ingresa otra cantidad menor');
        $('#cantidad{{$i}}').val(0);
      }else{
        var array_ =  ($('#bien{{$i}}').val()).split("|");
        var id_articulo = (array_[0]).trim();
        var codigo      = (array_[1]).trim();
        var articulo    = (array_[2]).trim();
        var medida      = (array_[3]).trim();
        var cantidad    = $('#cantidad{{$i}}').val();
        var unidad      = (array_[5]).split(":")[1];
        var total       = unidad*cantidad;
        articulo = articulo+' &nbsp;&nbsp;&nbsp;&nbsp; : <b><i>'+ medida+'</i></b>';
        $('#bien{{$i}}').val('');
        $('#cantidad{{$i}}').val('');
        array{{$i}}[cont{{$i}}] = new Array(cont{{$i}}, cantidad, unidad, total, id_articulo, codigo, articulo );
        cont{{$i}} = cont{{$i}}+1;
        gastoTotal();
      }
    }
    else{
      alert('Falta datos.');
    }
    $('#bien{{$i}}').focus();
  });
  <?php } ?>

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
          }));
        });
      }
    });
  });

  $('#button').click(function(event){
    event.preventDefault();
    <?php for($i=1; $i<=$n; $i++){ ?>
    var datos{{$i}} = '';
    var n = (array{{$i}}).length;
    for(i=0; i <n; i++){
      try {
        datos{{$i}} = datos{{$i}} + array{{$i}}[i][1] + '|' + array{{$i}}[i][2] + '|' + array{{$i}}[i][3] + '|' + array{{$i}}[i][4] +', ';
      }catch(err) { console.log( "Bienes"); }
    }
    $('#bien_{{$i}}').val(datos{{$i}});
    <?php } ?>
    if( $('#fecha').val() !='' ){
      if( $('#id_conceptos').val() !=''){
        if( $('#id_funcionarios').val() !='' ){
          if( $('#glosa_salida').val() !='' ){
            if(confirm('¿REVISO LOS DATOS, PARA LA SALIDA STOCK?')){
                 $('#formEnvio').submit();
            }
          }else {
            alert('Falta la GLOSA de la Salida Stock');
          }
        }else{
          alert('Falta el FUNCIONARIO de la Salida Stock');
        }
      }else {
        alert('Falta el CONCEPTO de la Salida Stock');
      }
    }else{
      alert('Falta la FECHA de la Salida Stock');
    }
  });
</script>
@endsection
