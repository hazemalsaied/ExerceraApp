'use strict';

// This file contains multiple controllers for creating the business logic of the partials pages. 
// Each controller offer one or more functionalities invoked in the scope of the controller.

/* Controllers */

var exControllers = angular.module('exControllers', ['ngTagsInput']);
// MyAccount.html controller
exControllers.controller('accountCtrl', ['$scope','UserApp', function($scope) {
    
    // for updating my account infos using UserApp API
	$scope.saveUser = function() {
		UserApp.User.save({"user_id":$scope.user.user_id ,
                           "first_name": $scope.user.first_name,
                          "last_name": $scope.user.last_name, 
                          "email": $scope.user.email,
                           "first_name": $scope.user.first_name,
                          "properties": {
                                "University": {
                                    "value": $scope.user.properties.University.value,
                                    "override": true
                                }
                              ,"Address": {
                                    "value": $scope.user.properties.Address.value,
                                    "override": true
                                }
                              ,"postal_code": {
                                    "value": $scope.user.properties.postal_code.value,
                                    "override": true
                                },"city": {
                                    "value": $scope.user.properties.city.value,
                                    "override": true
                                },"Interests": {
                                    "value": $scope.user.properties.Interests.value,
                                    "override": true
                                }
                            }
                          }
         , function(error, result) {
		    // No time to Handle error/result !
		});
		
		//$scope.user.save(user.first_name, user.last_name, user.email, user.properties.University.value);
	};
  }]);

// Excersies.html controller which is used also in MyAccount.html
exControllers.controller('exsCtrl',	function($scope, $http) {			
	$http.get(
		"/public/ajax/exercise_get_all.php"
	).then(function successCallback(response) {
		// console.log(response.data);
		$scope.exercises = response.data;
	});
    // filter for showing the proper exercises of a user in MyAccount.html
    $scope.userFilter = function(exercise) {
        //return true;
        return exercise.user_name == $scope.user.email;
    }
	
});

// addExcersie.html controller
exControllers.controller('addExCtrl', function($scope, $http, $timeout, $window) {	
	$scope.loadTags = function($query) {
	    return $http.post('/public/ajax/tag_get_like.php',
	    				{ "key": $query }
	    			).then(function(response) {
				console.log(response.data);
				var tags = response.data;
		        return tags.filter(function(tag) {
		      	    return tag.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
	      });
	    });
	};

	$scope.tagAdded = function($tag) {
		if (angular.isUndefined($tag.id)){
			$tag.id = 0;
		}
	};
    // Adding exercise 
	$scope.addExercise = function() {
		$http.post(
			"/public/ajax/exercise_create.php",
			{
				"title": $scope.exercise.title,
				"content": $scope.exercise.content,
				"user_create": $scope.user.email,
				"cat_id": $scope.exercise.currentCat.id,
				"tags": $scope.exercise.tags
			}
		).then (function successCallback(response){
				if (response.data == 'success') {
					$scope.message = "New exercise have been created";
					$scope.showMessage = true;
					$timeout(function() {
					    $scope.showMessage = false;
					    $window.location.href = '/public/#/exercises/';
					}, 1500);					
				}
				else {
					$scope.message = "Error when creating new exercise";
				}
			}, function errorCallback(response) {
				$scope.message = response.data;
			}
		);
	};
});

// Single Excersies.html controller
exControllers.controller('exCtrl', function($scope, $routeParams, $http) {
	$http.post(
		"/public/ajax/exercise_get_by_id.php",
		{
			"id": $routeParams.exerciseid
		}
	).then(function successCallback(response) {
		// console.log(response.data);
		$scope.exercise = response.data;
	});

	// for contolling the css and the visibality of tabs
	// (solutions, reviews , reports)
	$scope.tab = 1;

	$scope.isSet = function(checkTab) {
		return $scope.tab === checkTab;
	};

	$scope.setTab = function(setTab) {
		$scope.tab = setTab;
	};
});

// Sidebar controller which return a list of the categories
exControllers.controller('catCtrl', function($scope, $routeParams, $http) {	
	$http.post(
		"/public/ajax/exercise_get_by_catid.php",
		{
			"cat_id": $routeParams.catid
		}
		).then(function successCallback(response) {
			$scope.exercises = response.data;
		}, function errorCallback(response) {
			// $scope.message = response.statusText;
	});
});

// controllere to return the Excersies according to the tag controller
exControllers.controller('tagCtrl', function($scope, $routeParams, $http) {
	$http.post(
		"/public/ajax/exercise_get_by_tag.php",
		{
			"tag": $routeParams.tagname
		}
		).then(function successCallback(response) {
			$scope.exercises = response.data;
		}, function errorCallback(response) {
			// $scope.message = response.statusText;
	});
});