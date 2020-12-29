'use strict';

angular.module('Almacenes')
  .controller('IndexArticulosMovimientosCtrl', function($scope, GestionesResource, AlmacenesResource, ArticulosMovimientoResource, $location, $timeout, DTOptionsBuilder, DTColumnBuilder){
    $scope.title = "Catalogo de Productos en Desuso";
    $scope.icono = "file-eye";
    $scope.ArticulosMovimientos = ArticulosMovimientoResource.query();
    $scope.Almacenes = AlmacenesResource.query();
    $scope.Gestiones = GestionesResource.query();
    $scope.vm = {};
    $scope.vm.dtOptions = DTOptionsBuilder.newOptions()
    .withOption(
    "language",{
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
      }
    ).withOption('order', [0, 'asc']);

  })

  .controller('EditArticulosMovimientosCtrl', function($scope, ArticulosMovimientoResource, $location, $timeout, $routeParams){
    $scope.title = "Observación ah artículo en catalogo como desuso, malogrado, etc.";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.icono = "file-text-o";

    $scope.ArticulosMovimiento = ArticulosMovimientoResource.get({
      id: $routeParams.id
    });
    $scope.saveCatalogo = function(){
      ArticulosMovimientoResource.update($scope.ArticulosMovimiento);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/catalogo');
      }, 1000);
    }
  });
