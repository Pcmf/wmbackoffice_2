/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('WMbackoffice').controller('wellcomeController',function($scope,$rootScope,$http){
    //FAKE LOGIN
    sessionStorage.company = JSON.stringify({"name":"BarM","cid":"11","business":"1"});
    
    $rootScope.company = JSON.parse(sessionStorage.company);
    
    //Tenta obter o menutype
    $http({
        url:'php/getMainMenu.php',
        method:'POST',
        data:{param:JSON.stringify($rootScope.company)}
    }).then(function(resp){
        sessionStorage.langs = JSON.stringify(resp.data.langs);
        sessionStorage.type = resp.data.type;
    });
    
});
