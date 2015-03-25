angular.module('sumatraServices', ['ngResource'])

	.factory('FamilyList', ['$resource',
	  function($resource){
	    return $resource('/sumatra-api/taxa/:abc', {}, {
	      query: {method:'GET', params:{abc:''}}
	    });
	  }])

	.factory('SpList', ['$resource',
	  function($resource){
	    return $resource('/sumatra-api/taxa/:family/:abc', {}, {
	      query: {method:'GET', params:{family: 'unknown', abc:''}}
	    });
	  }])

	.factory('SpSingle', ['$resource',
	  function($resource){
	    return $resource('/sumatra-api/taxa/:family/:sp', {}, {
	      query: {method:'GET', params:{family: 'unknown', sp:''}}
	    });
	  }])

	.factory('ImgList', ['$resource',
	  function($resource){
	    return $resource('/sumatra-api/images/:sp', {}, {
	      query: {method:'GET', params:{sp:''}}
	    });
	  }]);