var sumatraApp = angular.module('sumatraApp', [
	'ui.bootstrap',
  'ngRoute',
  'sumatraDirectives',
  'sumatraControllers',
  'sumatraServices'])

  .config(['$routeProvider', '$locationProvider', 
    function($routeProvider, $locationProvider) {
      $routeProvider
        .when('/taxa/:family?/:sp?', {
          templateUrl: 'partials/taxa.html',
          controller: 'TaxaCtrl'
        })
        .when('/images/:sp/:img?', {
          templateUrl: 'partials/img-viewer.html',
          controller: 'ImgViewerCtrl',
          css: 'css/img-viewer.css'
        })
        .when('/search/:sstr?', {
          templateUrl: 'partials/search.html',
          controller: 'SearchCtrl',
          reloadOnSearch : false
        })
        .otherwise({
          redirectTo: '/home',
          templateUrl: 'partials/home.html',
          controller: 'HomeCtrl',
        });

      // use the HTML5 History API
      $locationProvider.html5Mode(true);
    }])

  .filter('excludeKeys', function() {
    return function(properies) {
      var out = [];
      angular.forEach(properies, function (val, key, obj) {
      	var keys = ['species', 'family', 'author'];
      	// if not in array of keys
        if (keys.indexOf(key) === -1) {
          this.push(JSON.parse('{"'+key+'" : "'+val+'"}'));
        }
      }, out);
      return out;
    }
  });
