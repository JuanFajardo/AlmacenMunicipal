'use strict';
angular.module('Almacenes')
  .factory('BienesResource', function($resource){
    return $resource('index.php/Bienes/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
