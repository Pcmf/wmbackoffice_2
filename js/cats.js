/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('WMbackoffice').controller('catsController',function($scope,$rootScope,$http,$modal,$location,$timeout){
    
    //get company info
    $scope.type = sessionStorage.type;
    $scope.langs = JSON.parse(sessionStorage.langs);
    $scope.company = JSON.parse(sessionStorage.company);
    //Select lang 0 as default
    $scope.LG = $scope.langs[0].sgl;
    //Load model menu 
    loadMockup();
    
    //Edit selected cat from model when click
    $scope.editCat = function(cat){
    //open modal to edit - uses same modal for this and for communs
        var modalInstance1 = $modal.open({
            templateUrl: 'modalEditCat.html',
            controller: 'modalInstanceEditCat',
            size: 'md',
            resolve: {items1: function () {
                    return cat;
                }
            }
        });
        //data return from modalInstance - save to DB
        modalInstance1.result.then(function (result) {
            var parm = {};
            parm.company = $scope.company;
            parm.cat = result;
            parm.pic = result.pic;
            $http({
                url:'php/saveCategoryToMenu.php',
                method:'POST',
                data:{params:JSON.stringify(parm)}
            }).then(function(answer){
                loadMockup();
            });

       },function(){
           loadMockup();
       });
    };
    
    
   //Load communs categories
    $http({
        url:'php/getCatCommuns.php',
        method: 'POST'
    }).then(function(resp){
//        alert(resp.data.catj)
        $scope.catgs = resp.data.catg;
    });
 
    //Change lang on the flags
    $scope.changeLang = function(lg){
        $scope.LG = lg;
    };
    //Load categories to mockup - refresh
    function loadMockup(){
        //Load model menu 
        $http({
            url:'php/getMainMenu.php',
            method:'POST',
            data:{param:JSON.stringify($scope.company)}
        }).then(function(resp){
    //        alert(resp.data);
            $scope.cats = resp.data.cats;
        });
    }
    
});


/**
 * MODAL instance for editing categoria
 */
angular.module('WMbackoffice').controller('modalInstanceEditCat',
            function ($scope,$http,$modal,$modalInstance,items1) {
    $scope.cts = items1;
    $scope.imgModal = items1.img;
    $scope.langs = JSON.parse(sessionStorage.langs);

    $scope.closeModal = function () {
        $modalInstance.dismiss('cancel');
    };

    //open modal to change image
    $scope.changeImg = function () {
        var modalInstance = $modal.open({
            templateUrl: 'modalShowImg.html',
            controller: 'modalInstanceShowImg',
            size: 'lg'

        });
        //data return from modalInstance
        modalInstance.result.then(function (selectedItem) {
//                alert(selectedItem);
            $scope.imgModal = selectedItem;
        });
    };
    //Save Changes
    $scope.saveChanges = function (pic, cats) {
        items1.cat = cats;
        items1.pic = pic;
        $modalInstance.close(items1);
    };
        //Remove category from mockup / menutype
    $scope.removeCat = function(cat){
        $http({
            url:'php/removeCat.php',
            method:'POST',
            data:{params:JSON.stringify(cat)}
        }).then(function(){
           $modalInstance.dismiss(); 
        });
        
    };

});

/**
 * MODAL Instance for Loading images to gallery
 */
angular.module('WMbackoffice').controller('modalInstanceShowImg', function ($scope, $http, $modalInstance, $upload) {
    $http.get("php/loadImgFromGalery.php").success(function (answer) {
        $scope.pics = answer;
        //click on picture to select it
        $scope.selectPic = function (pic) {
            $modalInstance.close(pic);
        };
    });

    //Change image button
    $scope.changeImg = function ($files) {
        //$files: an array of files selected, each file has name, size, and type.
        for (var i = 0; i < $files.length; i++) {
            var $file = $files[i];
            $upload.upload({
                url: 'php/upload-image.php',
                headers: {'Content-Type': $file.type},
                method: 'POST',
                data: $file,
                file: $file
            }).success(function (resposta) {
//                alert(resposta);
                $scope.edline.img = resposta;
            });
        }
    };

    //Close modal
    $scope.closeModal = function () {
        $modalInstance.dismiss('cancel');
    };

});