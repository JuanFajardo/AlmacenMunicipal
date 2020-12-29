'use strict';
angular.module('Almacenes')
  .factory('MovimientosResource', function($resource){
    return $resource('index.php/Movimientos/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
