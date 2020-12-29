'use strict';
angular.module('Almacenes')
  .factory('EstructurasResource', function($resource){
    return $resource('index.php/Estructuras/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
