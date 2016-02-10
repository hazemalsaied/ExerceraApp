'use strict';

//In this file we declare the main module of the whole application, myApp. We link this module with other modules, 
//In technical words, we create its dependencies which are declared in the other files, such as controllers and directives, 
//or predefined ones, such as routing mod- ule.

//In this file we also configure the routing of views for directing the links to the appropriate pages 
//and add the parameters of UserApp for controlling the visibility of pages according to the given permis- sions.



// Declare app level module 
angular.module('myApp', [
  'ngRoute',
  'exDirectives',
  'exControllers',
    'UserApp'
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/', {templateUrl: '/public/partials/exercises.html', controller: 'exsCtrl', public: true});
  $routeProvider.when('/exercises', {templateUrl : '/public/partials/exercises.html',controller : 'exsCtrl', public: true});
  $routeProvider.when('/exercises/:exerciseid', {templateUrl : '/public/partials/exercise.html',controller : 'exCtrl', public: true});
  $routeProvider.when('/cat/:catid', {templateUrl : '/public/partials/exercises.html',controller : 'catCtrl', public: true});
  $routeProvider.when('/tag/:tagname', {templateUrl : '/public/partials/exercises.html',controller : 'tagCtrl', public: true});
  $routeProvider.when('/addExercise', {templateUrl : '/public/partials/addExercise.html',controller : 'addExCtrl', public: false});
  $routeProvider.when('/account', {templateUrl: '/public/partials/account.html',controller:'accountCtrl', public: false});
  $routeProvider.when('/login', {templateUrl: '/public/partials/login.html', login: true});
  $routeProvider.when('/signup', {templateUrl: '/public/partials/signup.html', public: true});
  $routeProvider.when('/verify-email', {templateUrl: '/public/partials/verify-email.html', verify_email: true});
  $routeProvider.when('/reset-password', {templateUrl: '/public/partials/reset-password.html', public: true});
  $routeProvider.when('/set-password', {templateUrl: '/public/partials/set-password.html', set_password: true});
  $routeProvider.otherwise({redirectTo: '/', public: true});
}]).
run(function(user) {
  user.init({ appId: '567dc4945ce66' });
});

// The last section of this file is for linking the UserApp id with our application.
