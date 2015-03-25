angular.module('sumatraDirectives', [])

	/**
	 * directive to inject page title
	 */
	.directive('pageTitle',
		function($parse) {
	    return function(scope, element, attrs) {
	    	if(typeof(scope.title) !== 'undefined')
	      	element.text(scope.title);
	    };
		})


	/**
	 * view spewcific CSS path from routhe config
	 * - from: tennisgent/angular-route-styles
	 */
	.directive('head', ['$rootScope','$compile',
    function($rootScope, $compile){
      return {
        restrict: 'E',
        link: function(scope, elem){
          var html = '<link rel="stylesheet" ng-repeat="(routeCtrl, cssUrl) in routeStyles" ng-href="{{cssUrl}}" />';
          elem.append($compile(html)(scope));
          scope.routeStyles = {};
          $rootScope.$on('$routeChangeStart', function (e, next, current) {
            if(current && current.$$route && current.$$route.css){
              if(!angular.isArray(current.$$route.css)){
                current.$$route.css = [current.$$route.css];
              }
              angular.forEach(current.$$route.css, function(sheet){
                delete scope.routeStyles[sheet];
              });
            }
            if(next && next.$$route && next.$$route.css){
              if(!angular.isArray(next.$$route.css)){
                next.$$route.css = [next.$$route.css];
              }
              angular.forEach(next.$$route.css, function(sheet){
                scope.routeStyles[sheet] = sheet;
              });
            }
          });
        }
      };
    }])

  /**
   * breadcrumb directive
   */
  .directive('breadcrumb',
  	function() {
			return {
				restruct: 'E',
				templateUrl: 'partials/includes/breadcrumb.html'
	  	};
		})

	/**
	 * img-viewer directive (binds in leaflet.js)
	 */
  .directive('ngImgViewer',
  	function($parse) {
  		return {
  			restrict: 'A',
        replace: false,
  			compile: function (element, attrs) {
	  			return function (scope, element, attrs, controller) {
	  				// watch for change in isDoneLoading
	  				scope.$watch('isDoneLoading', function(newValue, oldValue){
              if (newValue){
              	// add map to DOM element
			  				var map = L.map(element[0], {
							  	center: [0,0],
							    zoom: 2,
							    minZoom: 1,
							    maxZoom: 5
							  });

							  var tiles = L.tileLayer(scope.baseUrl + 'img/taxa/' + scope.spDir + '/.tiles/' + scope.imgMain.replace('.','_') + '/{z}/{x}/{y}.jpg', {
								  minZoom: 1,
								  maxZoom: 5,
								  tms: true,
								  continuousWorld: true,
								  bounds: new L.LatLngBounds(L.latLng(-75.5, -179.999), L.latLng(75.5, 179.999))
							  });

							  tiles.addTo(map);
							}
						});
          }
  			}
  		};
  	})

  /**
	 * dragdealer directive (binds in dragdealer.js)
	 */
  .directive('ngDragdealer',
  	function($parse, $window) {
  		return {
  			restrict: 'A',
        replace: false,
  			compile: function (element, attrs) {
  				element.addClass('dragdealer');

	  			return function (scope, element, attrs, controller) {
	  				// watch for change in isDoneLoading
	  				scope.$watch('isDoneLoading', function(newValue, oldValue){
              if (newValue){
              	scope.handleWidth = (scope.imgList.count * 182) + 42;

              	// instantiate dragdealer on DOM element
                scope.dragdealer = new Dragdealer(element[0]);
                if($window.innerWidth > scope.handleWidth) {
				        	scope.dragdealer.disable();
	        			}

	        			var w = angular.element($window);

					      scope.getWindowDimensions = function () {
					        return {
					          'w': $window.innerWidth
					        };
					      };
					      scope.$watch(scope.getWindowDimensions, function (newValue, oldValue) {
					        if(newValue.w < scope.handleWidth) {
					        	scope.dragdealer.enable();
					        } else {
					        	scope.dragdealer.disable();
					        	scope.dragdealer.setValue(0,0);
					        }
					      }, true);
					      w.bind('resize', function () {
					        scope.$apply();
					      });
              }
            });
          }
  			}
  		};
  	})

	/**
	 * event on last ng-repeat item
	 */
	.directive('ngSearchResults', ['$rootScope',
		function($rootScope) {
		  return function(scope, element, attrs) {
		  	$rootScope.loadingResults = true;
		    if (scope.$last){
		      $rootScope.loadingResults = false;
		    }
		  };
		}])

  /**
   * scroll to anchor point
   */
  .directive('scrollTo',
  	function ($location, $anchorScroll) {
		  return function(scope, element, attrs) {
		    element.bind('click', function(event) {
		      event.stopPropagation();

		      var location = attrs.scrollTo;
		      $location.hash(location);

		      $anchorScroll.yOffset = 100;
		      $anchorScroll();
		    });
		  };
		})

  /**
	 * rightclick directive
	 * - prevents default context menu
	 * - possibility to bind custom event
	 */
  .directive('ngRightClick',
  	function($parse) {
	    return function(scope, element, attrs) {
	      var fn = $parse(attrs.ngRightClick);
	      element.bind('contextmenu', function(event) {
	        scope.$apply(function() {
	          event.preventDefault();
	          fn(scope, {$event:event});
	        });
	      });
	    };
		});
