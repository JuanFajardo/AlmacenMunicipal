'use strict';
angular.module('Automovil')
  .factory('AutomovilResource', function($resource){
    return $resource('index.php/Automovil/:id', { id:"@id"}, { update: { method: "PUT" } } ); });
