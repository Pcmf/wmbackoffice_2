<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
*/
  $filename = $_FILES['image']['name'];
  
  $destination = "../img/communs/".$filename;
  move_uploaded_file( $_FILES['image']['tmp_name'] , $destination );
 
 echo $filename; 
