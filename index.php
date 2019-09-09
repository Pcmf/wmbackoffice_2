<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->       
 <?php
        // put your code here
 ?>
<html ng-app="WMbackoffice">
    <head>
        <meta charset="UTF-8">
        <title>WM Back Office</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        
        <link href="lib/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="lib/bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="lib/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="lib/bootstrap-3.3.7-dist/js/bootstrap.js" type="text/javascript"></script>
        <link href="css/main.css" rel="stylesheet" type="text/css"/>
        
        <script src="lib/angular.1.2.26.js" type="text/javascript"></script>
        <script src="lib/angular.1.2.26-route.js" type="text/javascript"></script>
        <script src="lib/angular-file-upload.js" type="text/javascript"></script>
        <script src="lib/angular-resource.js" type="text/javascript"></script>
        
        <!--a linha a baixo é utilizada para mostrar o modal-->
        <link href="lib/bootstrap-3.3.7-dist/css/uibootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.12.1.js"></script> 
        
        
        <script src="js/mainApp.js" type="text/javascript"></script>
        <script src="js/wellcome.js" type="text/javascript"></script>
        <script src="js/langs.js" type="text/javascript"></script>
        <script src="js/types.js" type="text/javascript"></script>
        <script src="js/cats.js" type="text/javascript"></script>
        <script src="js/products.js" type="text/javascript"></script>
        <script src="lib/checklist-model.js" type="text/javascript"></script>
        <script src="lib/ImageTools.js" type="text/javascript"></script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#colapseBar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        <img id="logo" src="img/site/logo.png" alt="Logotipo"/>
                    </a>
                </div>
                <ul class="nav navbar-nav navbar-left">
                    <li class="dropdown">
                        <a href="!#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manutenção do Menu<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#/langs">Idiomas</a></li>
                            <li><a href="#/types">Tipo de Menu</a></li>
                            <li><a href="#/cats">Categorias</a></li>
                            <li><a href="#/products">Produtos</a></li>
                            <li><a href="#">Ajuda</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="colapseBar">
                    <ul class="nav navbar-nav">
                        <li><a href="#">QR Codes <span class="sr-only">(current)</span></a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Definições <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Conta</a></li>
                                <li><a href="#">Imagem de entrada</a></li>
                            </ul>
                        </li>
                            <li><a href="#">Eventos</a></li>
                            <li><a href="#">FAQ</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><i class="fa fa-home"></i>{{company.name}}</a></li>
                        <li><a href="#"><i class="fa fa-sign-out"></i> Sair</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        
        <!-- VISTAS -->      
        <div id="mainDiv"> 
            <div ng-view=""></div>
        </div>      
        
    </body>
</html>
