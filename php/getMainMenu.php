<?php

/* 
 * This code was developed by PCF
 * Each line should be prefixed with  * 
 */
require_once 'openCon.php';
$data = file_get_contents("php://input");

$dt = json_decode($data);
$parm = json_decode($dt->param);


$resp = array();
$cats = array();
//Load menu of company
$result0 = mysql_query(sprintf("SELECT * FROM menutype WHERE company = %s",$parm->cid));
if($result0){
    $row0 = mysql_fetch_array($result0);
    $resp['type'] = $row0['type'];
    $resp['langs']= json_decode($row0['langs']);
    
    $resp['cats'] = getCats( $row0['configs'],$parm);
    
} else {
   //if the company don't have yet a menu then load the menu model for his business from business type
    $result = mysql_query(sprintf("SELECT * FROM business WHERE id= %s",$parm->business));
    if($result){
        $row = mysql_fetch_array($result);
        $resp['cats'] = getCats($row['menutype']);
        $resp['type'] = 0;
        $resp['langs']= '';        

    }
    
}
echo json_encode($resp);



function getCats($configs,$parm){
    $cats = array();
    $catArr = explode(',',$configs);
    foreach ($catArr as $value) {
       $result00 = mysql_query(sprintf("SELECT * FROM categories WHERE id =%s AND company=%s",$value,$parm->cid));
       if($result00){
           $row00 = mysql_fetch_array($result00);
           $row00['catj'] = json_decode($row00['category']);
           array_push($cats, $row00);
       }
    }
    return $cats;
}