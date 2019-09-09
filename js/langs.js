/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('WMbackoffice').controller('langsController',function($scope,$rootScope,$http,$location,$timeout){
    $scope.l = {};

    $http({
        url:'php/getLangs.php',
        method:'POST'
    }).then(function(resp){
        $scope.langs = resp.data;
        
        if(sessionStorage.langs != undefined){
            $scope.l.langs = angular.copy(JSON.parse(sessionStorage.langs));
//            alert(sessionStorage.langs);
        }
        
    });
    
    
    //Button "Seguinte"  -  check if at least one language is selected
    $scope.saveLangs = function(lgs){
        
         if(lgs.langs.length>0){
            sessionStorage.langs = JSON.stringify(lgs.langs);
            window.location.replace('#/types');
        }else{
                alert("Tem de selecionar pelo menos um idioma!!");
            };
    };
    
});
