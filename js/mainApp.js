/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var app =angular.module('WMbackoffice',['ngRoute', 'checklist-model', 'ui.bootstrap','ngResource','angularFileUpload']);

/**
 * Routing
 */
app.config(function($routeProvider){
    $routeProvider
            .when('/langs',{templateUrl:'views/langs.html',controller:'langsController'})
            .when('/types',{templateUrl:'views/types.html',controller:'typesController'})
            .when('/cats',{templateUrl:'views/cats.html',controller:'catsController'})
            .when('/products',{templateUrl:'views/products.html',controller:'productsController'})
            .otherwise({templateUrl:'views/wellcome.html',controller:'wellcomeController'});
});

app.directive("filesInput", function() {
  return {
    require: "ngModel",
    link: function postLink(scope,elem,attrs,ngModel) {
      elem.on("change", function(e) {
        var files = elem[0].files;
        ngModel.$setViewValue(files);
      });
    }
  };
});