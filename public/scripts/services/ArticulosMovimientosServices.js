'use strict';
angular.module('Almacenes')
  .factory('ArticulosMovimientoResource', function($resource){
    return $resource('index.php/ArticulosMovimientos/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
