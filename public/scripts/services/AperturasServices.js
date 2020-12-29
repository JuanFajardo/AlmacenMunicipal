'use strict';
angular.module('Almacenes')
  .factory('AperturasResource', function($resource){
    return $resource('index.php/Aperturas/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
