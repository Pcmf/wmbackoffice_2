/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('WMbackoffice').controller('typesController',function($scope,$rootScope,$http,$location,$timeout){
    
    $scope.selectedType = 0;
    if(sessionStorage.type != undefined){
        $scope.selectedType = sessionStorage.type;
    }
    
    $scope.selectType = function(type){
        $scope.selectedType = type;
        sessionStorage.type = type;
    };

    
});
