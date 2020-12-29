'use strict';

angular.module('Almacenes')
  .controller('IndexConceptoCtrl', function($scope, ConceptosResource, $location, $timeout, DTOptionsBuilder, DTColumnBuilder){
    $scope.title = "Conceptos de Entrada y Salida";
    $scope.icono = "file-text-o";
    $scope.Conceptos = ConceptosResource.query();
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
      )
    .withOption('order', [0, 'asc']);
})
  .controller('CreateConceptoCtrl', function($scope, ConceptosResource, $location, $timeout){
    $scope.botonIcono = "fa fa-plus-circle";
    $scope.icono = "file-text-o";
    $scope.title = "Conceptos de Entrada y Salida - Nuevo";
    $scope.button = "Guardar";
    $scope.accion = "btn btn-primary";
    $scope.Conceptos={};
    $scope.saveConceptos = function(){
      ConceptosResource.save($scope.Conceptos);
      $scope.panel = "alert alert-info";
      $scope.msj = "Se inserto el dato correctamente!";
      $timeout(function(){
        $location.path('/concepto');
      }, 1000);
    };
  })
  .controller('ViewConceptoCtrl', function($scope, ConceptosResource, $routeParams){
    $scope.title = "Conceptos de Entrada y Salida - Detalles";
    $scope.icono = "file-text-o";
    $scope.Conceptos = ConceptosResource.get({
      id: $routeParams.id
    });
  })
  .controller('DelConceptoCtrl', function($scope, ConceptosResource, $routeParams, $location, $timeout  ){
    $scope.title = "Conceptos de Entrada y Salida - Eliminar";
    $scope.icono = "file-text-o";
    $scope.Conceptos = ConceptosResource.get({
      id: $routeParams.id
    });
    $scope.removeConceptos = function(id){
      ConceptosResource.delete({
        id: id
      });
      $timeout(function(){
        $location.path('/concepto');
      }, 100);
    };

  })

  .controller('EditConceptoCtrl', function($scope, ConceptosResource, $location, $timeout, $routeParams){
    $scope.title = "Conceptos de Entrada y Salida - Editar";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.icono = "file-text-o";
    $scope.Conceptos = ConceptosResource.get({
      id: $routeParams.id
    });
    $scope.saveConceptos = function(){
      ConceptosResource.update($scope.Conceptos);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/concepto');
      }, 1000);
    }


  });
