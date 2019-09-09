/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('WMbackoffice').controller('productsController',function($scope,$modal,$http){
    
  $http({
            url:'php/getCompanyCats.php',
            method:'POST',
            data:{parm:sessionStorage.company},
            headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
        }).success(function (resp){
            $scope.cats = resp;
            
            // function that show or hide products from one category   
            $scope.openCategory = function(id,cat) {
                var x = document.getElementById(id);
                var k = document.getElementsByClassName('pn');
                for(i=0; i < k.length ; i++){
                    if(x!==k[i]){    
                    k[i].className = k[i].className.replace(" show", "");
                    } else {
                        //Para a categoria selecionada
                        if (x.className.indexOf("show") == -1) {
                            x.className += " show";
                            //obter os produtos para a categoria
                            var params = {};
                            params.cid = JSON.parse(sessionStorage.company).cid;
                            params.cat = cat;
                            refreshProduts(params);
                        } else { 
                            x.className = x.className.replace(" show", "");
                            $scope.produtos = "";
                            $scope.produtosComuns = "";
                        }
                    }
                }
            //Abrir o modal para criar novo produto
            $scope.addCommunProd = function(ln){
                var modalInstance1 = $modal.open({
                    templateUrl: 'modalAddComunProduct.html',
                    controller: 'modalInstanceAddComunProd',
                    size: 'md',
                    resolve: {items: function () {
                            return ln;
                        }
                    }
                });
                //data return from modalInstance
                modalInstance1.result.then(function (cat) {
                    var params = {};
                    params.cid = JSON.parse(sessionStorage.company).cid;
                    params.cat = cat;                
                    refreshProduts(params);
                });                    
            };
            
            // function to EDIT the products ON MENU
            $scope.editProduct = function(prd){
                var modalInstance1 = $modal.open({
                    templateUrl: 'modalEditProduct.html',
                    controller: 'modalInstanceEditProd',
                    size: 'lg',
                    resolve: {items: function () {
                            return prd;
                        }
                    }
                });
                //data return from modalInstance
                modalInstance1.result.then(function (cat) {
                     var params = {};
                    params.cid = JSON.parse(sessionStorage.company).cid;
                    params.cat = cat;                
                    refreshProduts(params);
                });
            };            
            
     //Function to ADD a NEW Product       
            $scope.addNewProduct = function(){
             var prd ={};
             prd.id =0;
             prd.catid = cat;
             prd.cid = JSON.parse(sessionStorage.company).cid;
                // function to EDIT the products ON MENU
                    var modalInstance1 = $modal.open({
                        templateUrl: 'modalEditProduct.html',
                        controller: 'modalInstanceEditProd',
                        size: 'lg',
                        resolve: {items: function () {
                                return prd;
                            }
                        }
                    });
                //data return from modalInstance
                modalInstance1.result.then(function (cat) {
                     var params = {};
                    params.cid = JSON.parse(sessionStorage.company).cid;
                    params.cat = cat;                
                    refreshProduts(params);
                });
            };          
         
        };            
    });
    
    //Function that refresh the products view in menu
    function refreshProduts(params){
       $http({
            url: 'php/getProdutosByCat.php',
            method: 'POST',
            data: {parms : JSON.stringify(params)},
            headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
        }).success(function (dados){
            $scope.produtos = dados.prod1;
            $scope.produtosComuns = dados.prod0;
        });  
    }
});


/**
 * MODAL instance for ADD communs Produtos
 */
angular.module('WMbackoffice').controller('modalInstanceAddComunProd', function ($scope,$http, $modalInstance,items) {
    $scope.pr = items;
//    console.log(items);
    $scope.pr.price = "";
    $scope.pr.promoprice = "";
    $scope.pr.cat = items.cj;
    if(items.name){
        $scope.pr.pn = items.nj;
        $scope.pr.description = items.dj;
        $scope.imgFolder = items.folder;
        $scope.imgModal = items.photo;
        $scope.langs = JSON.parse(sessionStorage.langs);
    }
    
    $scope.closeModal = function () {
        $modalInstance.dismiss('cancel');
    };
    /*
     * Preço -  Se tiver virgula substitui por ponto
     */
    $scope.testPreco = function(price){
        $scope.pr.price = (price).replace(',','.');
    };  
    $scope.testPromo = function(price){
        $scope.pr.promoprice = (price).replace(',','.');
    };
    //Save product to DB to company and category selected
    $scope.saveCommunProd = function(prd){
        var parm ={};
        parm.cid = JSON.parse(sessionStorage.company).cid;
        parm.prd = prd;
        parm.pn = JSON.stringify(prd.pn);
        parm.description = JSON.stringify(prd.description);
//        parm.category = JSON.stringify(prd.cat);
        $http({
            url:'php/saveComunPrd.php',
            method:'POST',
            data:{parms:JSON.stringify(parm)},
            headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
        }).success(function(resp){
            if(resp != 'Erro'){
                $modalInstance.close($scope.pr.catid);
            } else {
                alert(resp);
            }
        });
    };

});
/**
 * MODAL instance for EDIT and ADD NEW Produtos
 * 
 */
angular.module('WMbackoffice').controller('modalInstanceEditProd', function ($scope,$modal,$http,$modalInstance,items) {
    $scope.pr = items;
    if(items.inmenu == '1'){
        $scope.pr.inmenu = true;
    }
    
   // $scope.pr.id = items.id;
    if(items.name){
        $scope.pr.pn = items.nj;
        $scope.pr.description = items.dj;
        $scope.langs = JSON.parse(sessionStorage.langs);
    } else {
        $scope.pr.pn ={};
        $scope.pr.description = {};
        $scope.pr.folder = 'clients';
        $scope.pr.photo = 'noimage.png';
        $scope.langs = JSON.parse(sessionStorage.langs);        
    }
    
    /*
     * Replace coma by dot
     */
    $scope.testPrice = function(price){
        $scope.pr.price = (price).replace(',','.');
    };  
    $scope.testPromo = function(price){
        $scope.pr.promoprice = (price).replace(',','.');
    };
    
        
     /* Close Modal */
    $scope.closeModal = function () {
        $modalInstance.dismiss('cancel');
    };

    //open modal to change image
    $scope.changeImg = function () {
        var modalInstance = $modal.open({
            templateUrl: 'modalShowImg.html',
            controller: 'modalInstanceShowImgs',
            size: 'lg'
        });
        //data return from modalInstance
        modalInstance.result.then(function (selectedItem) {
            $scope.pr.folder = selectedItem.folder;
            $scope.pr.photo = selectedItem.photo;
        });
    };
    
    //Save product to DB to company and category selected
    $scope.saveProduct = function(prd){
        var parm ={};
        parm.cid = JSON.parse(sessionStorage.company).cid;
        parm.prd = prd;
        parm.pn = JSON.stringify(prd.pn);
        parm.description = JSON.stringify(prd.description);
//        parm.category = JSON.stringify(prd.cat);
        $http({
            url:'php/saveProduct.php',
            method:'POST',
            data:{parms:JSON.stringify(parm)},
            headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
        }).success(function(resp){
            $modalInstance.close(resp);
        });
    };
    

    
});


/**
 * MODAL Instance for selecting images from communs or add new images to communs
 */
angular.module('WMbackoffice').controller('modalInstanceShowImgs', function ($scope, $http,$modalInstance,$upload,$timeout) {
    
    $http.get("php/loadImgFromGalery.php").success(function (answer) {
        $scope.pics = answer;
        //click on picture to select it
        $scope.selectPic = function (pic) {
            var image ={};
            image.photo = pic;
            image.folder = 'communs';
            $modalInstance.close(image);
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

    //Resize
    var imgBlob = null;
    var filename ='';
    $scope.loadPreview = function() {
        filename = $scope.fileList[0]['name'];
        ImageTools.resize($scope.fileList[0], {
            width: 320, // maximum width
            height: 240 // maximum height
        }, function(blob, didItResize) {
            imgBlob = blob;
        });
    };

    $scope.upload = function(){
        var request = new XMLHttpRequest();
        request.open("POST", "php/upload-image_clients.php", true);
        var data = new FormData();
        data.append("image",imgBlob,filename);
        request.send(data); 
            var image ={};
            image.photo = filename;
            image.folder = 'clients';        
        $timeout(function(){$modalInstance.close(image);},500);
    };


    //Close modal
    $scope.closeModal = function () {
        $modalInstance.dismiss();
    };

});