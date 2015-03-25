angular.module('sumatraControllers', [])

	.controller('MainCtrl', ['$scope', '$rootScope', '$location',
    function ($scope, $rootScope, $location) {
    	$scope.title = "Sumatra DB";
    	$scope.baseUrl = "http://localhost:8888/sumatra-database/public/";
    	$rootScope.mainTopNavVisible = true;

    	// check parh for nav
    	$scope.isActive = function (viewLocation) {
        return viewLocation === '/' + $location.path().split('/')[1];
    	};
    }])

	.controller('HomeCtrl', ['$scope', '$rootScope',
	  function($scope, $rootScope) {
	  	$rootScope.mainTopNavVisible = true;
	  	$scope.isDoneLoading = true;
	  	$scope.imgList = {count: 5};
	  }])

	.controller('TaxaCtrl', ['$scope', '$routeParams', '$rootScope',
	  function($scope, $routeParams, $rootScope) {
	  	// show main top nav bar
	  	$rootScope.mainTopNavVisible = true;

	  	$rootScope.family = $routeParams.family;
	  	$rootScope.sp = $routeParams.sp;

	  	$scope.spList = false;
			$scope.spSingle = false;

			$scope.templates = [
        {
          name: 'families',
          url: 'partials/includes/families.html'},
		    {
		      name: 'spList',
		      url: 'partials/includes/sp-list.html'},
		    {
		      name: 'spSingle',
		      url: 'partials/includes/sp-single.html'}
		  ];

		  $scope.taxaTemplate =  $scope.templates[0];

			if(typeof($rootScope.family) !== 'undefined') {
		    if(typeof($rootScope.sp) !== 'undefined') {
		    	$scope.spSingle = true;
		    	$scope.taxaTemplate = $scope.templates[2];
		    } else {
		    	$scope.spList = true;
		    	$scope.taxaTemplate =  $scope.templates[1];
		    }
		  }
	  }])

	.controller('FamilyListCtrl', ['$scope', 'FamilyList',
		function($scope, FamilyList){
			$scope.isDoneLoading = false;

			$scope.dataList = FamilyList.query({abc: 'abc'},
	  		function(familyList) {
	    		$scope.isDoneLoading = true;
	  		});
		}])

	.controller('SpListCtrl', ['$scope', 'SpList',
		function($scope, SpList){
			$scope.isDoneLoading = false;
			$scope.preview = 'placeholder.jpg'

			$scope.hoverIn = function(spItem) {
				$scope.preview = spItem.preview;
				return true;
			}

			$scope.hoverOut = function() {
				$scope.preview = 'placeholder.jpg';
				return true;
			}

			$scope.dataList = SpList.query({family: $scope.family, abc: 'abc'},
	  		function(spList) {
	    		$scope.isDoneLoading = true;
	  		});
		}])

	.controller('SpSingleCtrl', ['$scope', 'SpSingle', 'ImgList',
		function($scope, SpSingle, ImgList){
			$scope.isDoneLoading = false;
			$scope.spDir = $scope.sp.replace(/[\s\+]/g,'_');

			$scope.dataObj = SpSingle.query({family: $scope.family, sp: $scope.sp},
	  		function(spObj) {
	    		$scope.isDoneLoading = true;
	  		});

			$scope.imgList = ImgList.query({sp: $scope.sp},
	  		function(imgList) {
	    		$scope.isDoneLoading = true;
	  		});
		}])

	.controller('SearchCtrl', ['$scope', '$rootScope', '$route', '$routeParams', 'SpList', '$location', '$timeout',
	  function($scope, $rootScope, $route, $routeParams, SpList, $location, $timeout) {
	  	// show main top nav bar
	  	$rootScope.mainTopNavVisible = true;
	  	$rootScope.loadingResults = true;
	  	$scope.filtered = new Array();

	  	if(typeof($rootScope.searchTerm) !== 'undefined')
	  		$location.search('s', $rootScope.searchTerm);

	  	$scope.isDoneLoading = false;

	  	$scope.route = $route;
    	$scope.routeParams = $routeParams;

    	if(typeof($routeParams.s) !== 'undefined')
    		$scope.searchModel = $routeParams.s;

    	$scope.location = $location;

	  	$scope.go = function(path) {
			  $location.path(path);
			};
	  	
	  	$scope.dataList = SpList.query({family: 'all'},
	  		function(spList) {
	    		$scope.isDoneLoading = true;
	  		});

	  	$scope.$watch('routeParams',
	  		function(newVal, oldVal) {
		      angular.forEach(newVal, function(v, k) {
		      	$rootScope.loadingResults = true;
		      	$scope.searchModel = v;
		      	$rootScope.searchTerm = v;
		        $location.search(k, v);
		        $timeout(function() { $rootScope.loadingResults = false; }, 2500);
		      });
		    }, true);

	  	$timeout(function() { $rootScope.loadingResults = false; }, 4000);
	  }])

	.controller('ImgViewerCtrl', ['$scope', '$routeParams', 'ImgList', '$rootScope',
	  function($scope, $routeParams, ImgList, $rootScope) {
	  	// hide main top nav bar
	  	$rootScope.mainTopNavVisible = false;

	  	$scope.isDoneLoading = false;

	  	if(typeof($rootScope.sp) == 'undefined')
	  		$rootScope.sp = $routeParams.sp;

	    sp = $rootScope.sp;
	    $scope.spDir = sp.replace(/[\s\+]/g,'_');
	    $scope.imgMain = $routeParams.img;

	    $scope.imgList = ImgList.query({sp: sp},
	  		function(imgList) {
	  			if(imgList.count && typeof($routeParams.img) === 'undefined')
	    			$scope.imgMain = imgList.result[0];

	    		$scope.isDoneLoading = true;
	  		});
	  }])

	/**
	 * bootstrap collapse
	 */
	.controller('CollapseCtrl', ['$scope', '$window',
		function ($scope, $window) {
  		$scope.isCollapsed = true;

  		$scope.toggleCollapse = function() {
  			// 768 is the bootstrap breakpoint for sm devices
  			if($window.innerWidth < 768) { 
  				$scope.isCollapsed = !$scope.isCollapsed;
  			}
  		}
		}]);