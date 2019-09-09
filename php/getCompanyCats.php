<?php

/* 
 * This code was developed by PCF
 * Each line should be prefixed with  * 
 */
require_once 'openCon.php';
$data = file_get_contents("php://input");

$dt = json_decode($data);
$parm = json_decode($dt->parm);
$resp = array();
$result0 = mysql_query(sprintf("SELECT configs,company FROM menutype WHERE company = %s",$parm->cid));
if($result0){
    $row0 = mysql_fetch_array($result0);
    
    $catArr = explode(',', $row0['configs']);
    foreach ($catArr as $value) {
       $result00 = mysql_query("SELECT * FROM categories WHERE id =".$value);
       if($result00){
           $row00 = mysql_fetch_array($result00);
           $row00['catid'] = $row00['id'];
           $row00['company'] = $row0['company']; 
           $row00['catj'] = json_decode($row00['category']);
           array_push($resp, $row00);
       }
    }
    echo json_encode($resp);
} else {
    echo 'erro';
}
