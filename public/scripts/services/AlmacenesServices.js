'use strict';
angular.module('Almacenes')
  .factory('AlmacenesResource', function($resource){
    return $resource('index.php/Almacenes/:id', { id:"@id"}, { update: { method: "PUT" } } ); });
