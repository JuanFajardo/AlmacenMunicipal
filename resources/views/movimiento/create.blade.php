@extends('sisoftComBo')

@section('contenido')
<!-- DateTime Picker  -->
<link rel="stylesheet" href="{{asset('assets/css/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css')}}" />

<div class="panel panel-default">
    <div class="panel-heading clean">
      <h3><i class="fa fa-shopping-cart"></i>  <b>{{ $movimiento }} N° {{ $nro_moviento}}</b></h3>
    </div>
    <div class="panel-body">
      {!! Form::open(['url'=>'Movimiento', 'autocomplete'=>'off', 'method'=>'POST', 'id'=>'formEnvio']) !!}
        <input type="hidden" class="form-control"  value="{{$nro}}" name="nro">
        <input type="hidden" class="form-control"  value="{{$movimiento}}" name="movimiento">
        <input type="hidden" class="form-control"  value="{{$nro_moviento}}" name="nro_moviento">


          <div class="form-group col-md-12">

            <div class="alert alert-danger" role="alert" id="msjAlerta">
            </div>

            <div class="col-md-4">
              <label for="" class="control-label">Fecha de Movimiento</label><br>
              <div class='input-group date'>
                <input type='text' class="form-control" id='fecha' placeholder="Inserte la fecha" name="fecha"  required/>
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>
            <div class="col-md-4">
              <label class="control-label">Motivo de Ingreso</label><br>
              <input type="text"  class="form-control" placeholder="Escriba el ingreso" name="id_concepto" id="id_concepto" list="id_conceptos"  required >
              <datalist id="id_conceptos">
                @foreach($conceptos as $concepto)
                  <option  value="{{$concepto->concepto}}">
                @endforeach
              </datalist>
            </div>

          </div>

          <div class="form-group col-md-12">
            <h4><span class="glyphicon glyphicon-book col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-radius:10px;"><b> DOCUMENTOS </span></h4>

            <div class="col-md-4">
              <label for="" class="control-label">Nro. Informe</label><br>
              <input type="text" class="form-control"  name="codigo_informe" >
            </div>
            <div class="col-md-4">
              <label for="" class="control-label">Orden de Compra</label><br>
              <input type="text" class="form-control"  name="orden_compra" id="orden_compra"  >
            </div>
            <div class="col-md-4">
              <label for="" class="control-label">RUPE</label><br>
              <input type="text" class="form-control"  name="rupe" id="rupe"  >
            </div>
          </div>
          <div class="form-group col-md-12">
            <div class="col-md-6">
              <label for="" class="control-label">Nro. de Pedido</label><br>
              <input type="text" class="form-control"  name="codigo_pedido" >
            </div>
            <div class="col-md-6">
              <label for="" class="control-label">Otro Documento</label><br>
              <input type="text" class="form-control"  placeholder="Carta,.. etc."   name="otro_documento">
            </div>
          </div>

          <div class="form-group col-md-12">
            <h4><span class="glyphicon glyphicon-barcode col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-radius:10px;"><b> PROVEEDOR </span></h4>
            <div class="col-md-12">
              <label for="" class="control-label">Provedor | Responsable | NIT</label><br>
              <input type="text" name="id_proveedor" class="form-control" placeholder="Escriba el proveedor" id="id_proveedor" list="id_proveedores" required >
              <datalist id="id_proveedores">
              </datalist>
            </div>
          </div>

          <div class="form-group col-md-12">
            <h4><span class="glyphicon glyphicon-list-alt col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-radius:10px;"><b> FACTURAS/NOTAS/RECIBOS </span></h4>

            <div class="col-md-3">
              <label for="" class="control-label">Tipo </label><br>
              <input type="text" class="form-control" name="tipo_factura" id="tipo_factura"  list="tipos" required>
              <datalist id="tipos">
                <option value="Factura">Factura</option>
                <<option value="Factura Eventual">Factura Eventual</option>
                <option value="Recibo">Recibo</option>
                <option value="Nota">Nota</option>
              </datalist>
            </div>
            <div class="col-md-3">
              <label for="" class="control-label">Numero</label><br>
              <input type="text" class="form-control"  placeholder="001, 002" name="numero_factura" id="numero_factura" required>
            </div>
            <div class="col-md-3">
              <label for="" class="control-label">Monto Total</label><br>
              <input type="text" class="form-control"  placeholder="Monto en Bs." id="moneda"  required>
              <input type="hidden"  id="total_factura" name="total_factura" required>
            </div>
          </div>


          <!-- //////////////////////////////////////////////////
          COMIENZO DE LA TABLA -->
          <table class="table table-striped table-bordered" border="0" width="100%">
            <thead style="background-color:#D32F2F; color:white;">
              <tr>
                <th width="100%" colspan="2"><h4 align="center"> Articulos </h4></th>
              </tr>
            </thead>

            <tbody>
              <?php for($i=0; $i < $nro; $i++){ ?>
              <tr>
                <td width="50%">
                  <label class="control-label">Apertura Programatica</label>
                  <input type="text" id="aperturas{{$i}}" class="form-control" name="id_apertura{{$i}}" required  />
                </td>
                <td width="50%">
                  <label class="control-label">Clasificadores Presupuestarios</label>
                  <input type="text" id="clasificadores{{$i}}" class="form-control" multiple name="id_clasificador{{$i}}" required />
                </td>
              </tr>
              <tr style="background-color:#607D8B;" >
                <td width="10%" colspan="2">
                    <div class="row" style="margin-bottom: 5px;">
                      <div class="col-md-6" style="font-size:12px;">
                        <h5 style="color: white;">Buscar Bienes</h5>
                        <input type="text" id="_bien{{$i}}"  name="_bien{{$i}}" class="form-control" placeholder="Buscar bienes"  list="bienes{{$i}}" disabled="disabled">
                        <datalist id="bienes{{$i}}">
                        </datalist>
                        <input type="hidden" id="bien{{$i}}" name="bien{{$i}}" value="">
                      </div>
                      <div class="col-md-2">
                        <h5 style="color: white;">Cantidad</h5>
                        <input type="text" id="_cantidad{{$i}}" name="_cantidad{{$i}}" class="form-control" placeholder="Cantidad" disabled="disabled">
                      </div>
                      <div class="col-md-2">
                        <h5 style="color: white;">Precio</h5>
                        <input type="text" id="_precio{{$i}}" name="_precio{{$i}}" class="form-control" placeholder="Precio" disabled="disabled">
                      </div>
                      <div class="col-md-1">
                        <h5 style="color: white;">&nbsp;&nbsp;&nbsp;&nbsp;</h5>
                        <button type="button" id="agregarArticulo{{$i}}" class="btn btn-info"><i class="fa fa-plus-circle"> Insertar</i></button>
                      </div>
                    </div>
                    <table class="table" border="0" style="font-size:12px;">
                      <thead style="color: white;">
                       <tr>
                         <th bgcolor="#0288D1" >
                           <div class="row">
                              <div class="col-md-2"> <b>Codigo </div>
                              <div class="col-md-6"> <b>Articulo </div>
                              <div class="col-md-2"> <b>Prec. Uni. </div>
                            </div>
                         </th>
                         <th bgcolor="#0288D1" width="10%"><b>Cantidad</th>
                         <th bgcolor="#0288D1" width="10%"> <b>Total</th>
                         <th bgcolor="#0288D1" width="20%"> <b>Accion </th>
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


        <div class="form-group col-md-12">
            <div class="col-md-12">
              <h4><span class="glyphicon glyphicon-list col-md-12" style="color: #0288D1; padding: 7px; background-color: #B3E5FC; border-top-left-radius: 10px; border-top-right-radius: 10px;"><b> GLOSA / MOTIVO</span></h4>
              <textarea class="form-control" rows="2" cols="100" name="glosa_entrada" id="glosa_entrada" required> </textarea>
            </div>
          </div>
          <div class="form-group col-md-12">
        <div class="rows">
          <div class="col-md-3">
            <!--
            <button type="button" name="button" id="button" class="btn btn-primary" >
              <i class="fa fa-plus-circle" aria-hidden="true"></i> Movimiento {{$movimiento}}
            </button>
          -->
          <input type="hidden" id="codigo4060" name="cidog4060" value="">
            <!-- <a href="#contenido" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="button"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Continuar </a>
            <a href="" class="btn btn-primary" data-dismiss="modal" id="button"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Continuar </a>-->
            <button type="button" name="button" id="button" class="btn btn-primary" >
              <i class="fa fa-plus-circle" aria-hidden="true"></i> Continuar
            </button>
          </div>
          <div class="col-md-3">
            <a href="{{asset('index.php/Movimientos')}}" class="btn btn-info"> <i class="fa fa-times-circle" aria-hidden="true"></i> Cancelar</a>
          </div>
          <div class="col-md-6">
            <div class=" panel " role="alert"> <strong> </strong> </div>
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
        <a href="#" class="btn btn-danger" data-dismiss="modal"> Cerrar </a>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
   $(document).ready (function(){
    $('#msjAlerta').hide();
   });

   $('#fecha').focusout(function(){
     $('#msjAlerta').hide();
     var fecha =  $(this).val() ;
     $.get("{{asset('index.php/Movimientos/')}}/"+fecha+"/fecha", function(data){
        if(data != 'Codigo4060'){
          $("button").prop('disabled', true);
          $('#msjAlerta').html(data);
          $('#msjAlerta').show();
        }else{
          $("button").prop('disabled', false);
        }
     });
   });

   <?php for($i=0; $i < $nro; $i++){ ?>
   $('#_bien{{$i}}').focus(function(){
    var aperturas;
    var clasificadores;
    aperturas = $('#aperturas{{$i}}').val();
    clasificadores = $('#clasificadores{{$i}}').val();
    var link = "{{asset('index.php/Bienes/ver/JSON/list/')}}/"+clasificadores;

    $.getJSON(link, null, function(data, textStatus) {
               if(data.length>0){
                 var dato;
                 var bien = "#bienes{{$i}}";
                 $(bien).empty();
                 $.each( data, function( key, el ) {
                   bien = "#bienes{{$i}}";
                   dato = el.code+' | '+ el.clasificadorCode+'.'+el.almacenCode+'.'+el.bienCode +' | '+ el.name  +' | '+el.medida;
                    $(bien).append($('<option>', {
                       value: dato
                       //text: dato
                     }));
                 });
               }
     });
   });
   <?php } ?>

   <?php for($i=0; $i < $nro; $i++){ ?>
     var array_{{$i}} = [];
   <?php } ?>

   function gastoTotal(){
     var suma = 0;
     var id;
     <?php for($i=0; $i < $nro; $i++){ ?>
       var n = array_{{$i}}.length;
       for(i=0; i<n; i++){
         try { suma = suma + parseFloat( array_{{$i}}[i][3] ); }
         catch(err) { console.log( "Error de sumatoria"); }
       }
       var id = $('#articulos{{$i}}');
       $(id).children('tr').remove();

       for (i=0; i<array_{{$i}}.length; i++){
         try {
           html = "<tr><td><div class='row'>"+
                                   "<div class='col-md-2'> <b> " + array_{{$i}}[i][5] + " </b> </div>"+
                                   "<div class='col-md-6'><b> " + array_{{$i}}[i][6] + " </b></div>"+
                                   "<div class='col-md-2'> " + array_{{$i}}[i][2] + " </div>"+
                                 "</div></td>"+
                              "<td> "+array_{{$i}}[i][1]+" </td>"+
                              "<td> "+array_{{$i}}[i][3]+" </td>"+
                              "<td> <a style='color:#ff404b;' onclick='eliminar({{$i}}, "+ i +")' > <i class='fa fa-trash-o'></i> Eliminar</a> </td>"+
                            "</tr>";
        $(id).append(html);
        }catch(err) { console.log( "Error DE HTML"); }
       }

       html = "<tr><td colspan='2'></td> <td><div class='montoTotal' ></div></td> <td><div class='gastoTotal' ></div></td></tr>";
       $(id).append(html);


     <?php } ?>
     var facturaTotal = $('#total_factura').val();
     var dato = parseFloat(facturaTotal) - parseFloat(suma) ;
     //$('.gastoTotal').html('Gasto: '+suma+'Bs.; Le quedan: '+dato.toFixed(2)+'Bs.');
     $('.montoTotal').html('Total: '+suma.toFixed(2)+' Bs.');
     $('.gastoTotal').html('Falta: '+dato.toFixed(2)+' Bs.');
     var numero ="{{$nro}}";
     if( suma == facturaTotal || suma > facturaTotal ){
       var id;
       for(i=0; i < numero; i++){
         id = "#_bien"+i;
         $(id).prop('disabled', true);
         id = "#_cantidad"+i;
         $(id).prop('disabled', true);
         id = "#_precio"+i;
         $(id).prop('disabled', true);
         id = "#agregarArticulo"+i;
         $(id).prop('disabled', true);
       }
     }else {
       for(i=0; i < numero; i++){
         id = "#_bien"+i;
         $(id).prop('disabled', false);
         id = "#_cantidad"+i;
         $(id).prop('disabled', false);
         id = "#_precio"+i;
         $(id).prop('disabled', false);
         id = "#agregarArticulo"+i;
         $(id).prop('disabled', false);
       }
     }

   }


   function eliminar(array, posicion){
     <?php for($i=0; $i < $nro; $i++){ ?>
       if(array == {{$i}} ){
          array_{{$i}}.splice(posicion, 1);
       }
     <?php } ?>
     gastoTotal();
   }

   var restaTotal = 0;
   <?php for($i=0; $i < $nro; $i++){ ?>
   var articulos_{{$i}}='';
   var cont_{{$i}}= 0;
   $('#agregarArticulo{{$i}}').click(function(){
     var a1 = $('#_bien{{$i}}').val();
     var a2 = $('#_cantidad{{$i}}').val();
     var a3 = $('#_precio{{$i}}').val();

     var total = $('#total_factura').val();
     var sumaTotal = 0;

     var n = array_{{$i}}.length;
     for(i=0; i<n; i++){
       try { sumaTotal = sumaTotal + parseFloat( array_{{$i}}[i][3] ); }
       catch(err) { console.log( "Error: Suma total de precio"); }
     }

     sumaTotal = sumaTotal + parseFloat( a3 );
     sumaTotal = Math.round(sumaTotal * 100) / 100;
     total = Math.round(total * 100) / 100;

     if( total >= sumaTotal )
     {
         if( a1 !='' &&  a2 !='' &&  a3 !='' )
         {
          var array =  ($('#_bien{{$i}}').val()).split("|");
          var id_articulo = array[0];
          var codigo      = array[1];
          var articulo    = array[2];
          var medida      = array[3];
          var cantidad    = $('#_cantidad{{$i}}').val();
          var total       = $('#_precio{{$i}}').val();
          var unidad     = parseFloat(total) / parseFloat(cantidad);
          unidad      = Math.round(unidad * 100000000000) / 100000000000;
          articulo = articulo+' &nbsp;&nbsp;&nbsp;&nbsp; : <b><i>'+ medida+'</i></b>';
          $('#_bien{{$i}}').val('');
          $('#_cantidad{{$i}}').val('');
          $('#_precio{{$i}}').val('');
          array_{{$i}}[cont_{{$i}}] = new Array(cont_{{$i}}, cantidad, unidad, total, id_articulo, codigo, articulo );
          cont_{{$i}} = cont_{{$i}}+1;
          gastoTotal();
        }else{
          alert('Faltan datos');
        }
     }else{
        alert('El costo exedio al costo introducido del "Monto Total"');
     }
     $('#_bien{{$i}}').focus();
   });
   <?php } ?>

  $(document).ready(function() {
    var numero = "{{$nro}}";
    var id = "";
    for(i=0; i<numero; i++){
      id="#aperturas"+i;
      //$(id).tokenInput(["{{asset('index.php/Aperturas/ver/JSON/list')}}"], {tokenLimit:1});
      $(id).tokenInput([
                @foreach($aperturas as $apertura)
                  {id: {{$apertura->id}}, name: "{{$apertura->codigo}} - {{$apertura->apertura}}"},
                @endforeach
            ], {tokenLimit:1});

      id="#clasificadores"+i;
      //$(id).tokenInput("{{asset('index.php/Clasificadores/ver/JSON/list')}}", {preventDuplicates: true} );
      $(id).tokenInput([
                @foreach($clasificadores as $clasificador)
                  {id: {{$clasificador->id}}, name: "{{$clasificador->codigo}} - {{$clasificador->clasificador}}"  },
                @endforeach
            ]);
    }
 });

 $('#moneda').change(function(){
    $('#total_factura').val( $('#moneda').val() );
    var moneda = parseFloat($('#moneda').val()).toLocaleString();
    $('#moneda').val(moneda);

    var numero ="{{$nro}}";
    var id;
    for(i=0; i < numero; i++){
      id = "#_bien"+i;
      $(id).prop('disabled', false);
      id = "#_cantidad"+i;
      $(id).prop('disabled', false);
      id = "#_precio"+i;
      $(id).prop('disabled', false);
    }
    gastoTotal();
 });

 $('#button').click(function(){
   <?php for($i=0; $i < $nro; $i++){ ?>
     var datos{{$i}}='';
     for(i=0; i< array_{{$i}}.length; i++){
       try { datos{{$i}} = datos{{$i}}+ array_{{$i}}[i][1]+'|'+array_{{$i}}[i][2]+'|'+array_{{$i}}[i][3]+'|'+array_{{$i}}[i][4]+', ';
       } catch(err) { console.log( "Error: Suma total de precio"); }

     }
     $('#bien{{$i}}').val(datos{{$i}});
   <?php } ?>

   //$( "#formEnvio" ).submit();
   if( $('#fecha').val() !='' ){
      if( $('#id_concepto').val() !=''){
        if( $('#id_proveedor').val() !='' ){
          if( $('#orden_compra').val() !='' ){
            if( $('#tipo_factura').val() !='' ){
              if( $('#numero_factura').val() !='' ){
                if($('#glosa_entrada').val() !=''){
                  if( $('#total_factura').val() !=''){
                    if( $('#glosa_entrada').val() !=''){
                      /*
                      $("html, body").animate({scrollTop: 0 }, 500);
                      $("#myModal").modal();

                      $('#guardar').click(function(event){
                        $('#codigo4060').val('guardar');
                        $('#formEnvio').submit();
                      });*/
                      if(confirm('REALIZARA EL INSERTADO DEL MOVIMIENTO'))
                      {
                        $('#codigo4060').val('guardar');
                        $('#formEnvio').submit();
                      }

                    }else{
                      alert('Falta la MONTO TOTAL de movimiento');
                    }
                  }else{
                    alert('Falta la MONTO TOTAL de movimiento');
                  }
                }else{
                  alert('Falta la GLOSA DE ENTRADA de movimiento');
                }
              }else{
                alert('Falta la NUMERO DE FACTURA del movimiento');
              }
            }else{
              alert('Falta la TIPO DE FACTURA del movimiento');
            }
          }else {
            alert('Falta la ORDEN COMPRA del movimiento');
          }
        }else{
          alert('Falta el PROVEEDOR del movimiento');
        }
      }else {
        alert('Falta la CONCEPTO del movimiento');
      }
   }else{
     alert('Falta la FECHA del movimiento');
   }
 });

</script>

<script type="text/javascript">
  $('#id_proveedor').focus(function(){
     var link = "{{asset('index.php/Proveedores')}}";
     $.getJSON(link, null, function(data, textStatus) {
               if(data.length>0){
                 var dato;
                 var bien = "#id_proveedores";
                 $(bien).empty();
                 $.each( data, function( key, el ) {
                   dato = el.id+' | '+ el.proveedor+' | '+el.responsable+' |  NIT.:  '+el.nit;
                    $(bien).append($('<option>', {
                       value: dato
                       //text: dato
                     }));
                 });
               }
     });
  });

  $(document).ready(function(){
    $.fn.datetimepicker.defaults.language = 'es';
  });
  $(function () {
    $('#fecha').datetimepicker({ format: 'YYYY-MM-DD'});
  });
</script>

@endsection
