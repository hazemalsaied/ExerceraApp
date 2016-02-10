'use strict';


//In this file we declare multiple directives for linking the ’index.html’ with 
//the files of constants folder or for linking the ’exercixe.html’ with the files of Constant folder.
//For the first directive nothing important exists in the controllers of the directives. 
//but in the second linking, for directives, such as exre- views or exsolutions, the controller read user request, 
//handle it and return the suitable response. It either add a solution, a review or report an exercise or other similar requests.
//The technical concepts used in this directive is pretty simple, 
//where all what we do is to parse data, invoke a service and show the result by writing the right expression.

/* Directives */
var exDirectives = angular.module('exDirectives', []);


//Directive for the header section.
exDirectives.directive('exheader', function() {
	return {
		restrict : 'E', // This menas that it will be used as an attribute and
						// NOT as an element.
		replace : true,
		templateUrl : "partials/constant/header.html",
		controller : [ '$scope', '$filter', function($scope, $filter) {
			// the behaviour goes here :)
		} ]
	}
});
//Directive for the solution tab in single Exercise.html.
exDirectives.directive('exsolutions', function() {
	return {
		restrict : 'E', // This menas that it will be used as an attribute and
		// NOT as an element.
		replace : true,
		templateUrl : "partials/tabs/solutions.html",
		controller : function($scope, $routeParams, $http, $timeout, $window) {			
			$scope.addSolution = function() {
				$http.post(
					"/public/ajax/solution_create.php",
					{
						"content": $scope.solution.newContent,
						"user_create": $scope.user.email,
						"ex_id": $routeParams.exerciseid
					}
				).then (function successCallback(response){
						$scope.solution.message = "New solution have been added";
						$scope.solution.showMessage = true;
						$timeout(function() {
						    $scope.exercise.solutions.push(response.data);
						    $scope.solution.newContent = '';
						    $scope.solution.showMessage = false;	
						}, 1500);
					}, function errorCallback(response) {
						$scope.message = response.data;
					}
				);
			};
		} 
	}
});

//Directive for the review tab in single Exercise.html.
exDirectives.directive('exreviews', function() {
	return {
		restrict : 'E', // This menas that it will be used as an attribute and
		// NOT as an element.
		replace : true,
		templateUrl : "partials/tabs/reviews.html",
		controller : function($scope, $routeParams, $http, $timeout, $window) {			
			$scope.addReview = function() {
				$http.post(
					"/public/ajax/comment_create.php",
					{
						"content": $scope.review.newContent,
						"user_create": $scope.user.email,
						"ex_id": $routeParams.exerciseid
						// "difficulty": $scope.review.difficulty
					}
				).then (function successCallback(response){
						$scope.review.message = "New review have been added";
						$scope.review.showMessage = true;
						$timeout(function() {
						    $scope.exercise.comments.push(response.data);
						    $scope.review.newContent = '';
						    $scope.review.showMessage = false;	
						}, 1500);
					}, function errorCallback(response) {
						$scope.message = response.data;
					}
				);
			};
		}
	}
});

//Directive for the report tab in single Exercise.html.
exDirectives.directive('exreport', function() {
	return {
		restrict : 'E', // This menas that it will be used as an attribute and
		// NOT as an element.
		replace : true,
		templateUrl : "partials/tabs/report.html",
		controller : function($scope, $routeParams, $http, $timeout) {			
			$scope.addReport = function() {
				$http.post(
					"/public/ajax/report_create.php",
					{
						"content": $scope.report.newContent,
						"user_create": $scope.user.email,
						"ex_id": $routeParams.exerciseid
					}
				).then (function successCallback(response){
						if (response.data == 'success') {
							$scope.exercise.report_qty += 1;
							$scope.report.message = "New report have been added";
							$scope.report.showMessage = true;
							$timeout(function() {
							    $scope.report.showMessage = false;
							    $scope.report.newContent = '';	
							}, 1500);
						} else {
							$scope.report.showMessage = true;
							$scope.report.message = response.data;
						}
					}, function errorCallback(response) {
							$scope.report.showMessage = true;
							$scope.report.message = response.data;
					}
				);
			};
		}
	}
});


//Directive for the delete tab in single Exercise.html.
exDirectives.directive('exdelete', function() {
	return {
		restrict : 'E', 
		replace : true,
		templateUrl : "partials/tabs/delete.html",
		controller : function($scope, $routeParams, $http, $timeout, $window) {			
			$scope.deleteExercise = function() {
				$http.post(
					"/public/ajax/exercise_delete.php",
					{						
						"ex_id": $routeParams.exerciseid
					}
				).then (function successCallback(response){
						if (response.data == 'success') {
							$window.alert('Exercise deleted!');
							$window.location.href = '/public/#/exercises/';							
						} else {
							$scope.showMessage = true;
							$scope.message = response.data;
						}
					}, function errorCallback(response) {
						$scope.showMessage = true;
						$scope.message = response.data;
					}
				);
			};
		}
	}
});
//Directive for the left sidebar section.
exDirectives.directive('exsidebar', function() {
	return {
		restrict : 'E', // This menas that it will be used as an attribute and
		// NOT as an element.
		replace : true,
		templateUrl : "partials/constant/sidebar.html",
		controller : function($scope, $filter, $http) {
			$http.get(
				"/public/ajax/category_get_all.php"
			).then(function successCallback(response) {
				console.log(response.data);
				$scope.categories = response.data;
			});
		} 
	}
});

//Directive for the footer section.
exDirectives.directive('exfooter', function() {
	return {
		restrict : 'E', // This menas that it will be used as an attribute and
		// NOT as an element.
		replace : true,
		templateUrl : "partials/constant/footer.html",
		controller : [ '$scope', '$filter', function($scope, $filter) {
			// the behaviour goes here :)
		} ]
	}
});


exDirectives.
  directive('appVersion', ['version', function(version) {
    return function(scope, elm, attrs) {
      elm.text(version);
    };
  }]).

  // This directive highlightes the current route in the menu
  directive('menuItem', ['$rootScope', '$location', function($rootScope, $location) {
    return function(scope, elm, attrs) {
    	var render = function() {
	      if ($location.path().indexOf(elm.attr('href').replace('#', '')) == 0) {
	      	elm.css('font-weight', 'bold');
	      } else {
	      	elm.css('font-weight', 'normal');
	      }
	    };

			$rootScope.$on('$locationChangeSuccess', function() {
				render();
			});

			render();
    };
  }]);

