'use strict';
angular.module('Almacenes')
  .factory('ProveedoresResource', function($resource){
    return $resource('index.php/Proveedores/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
