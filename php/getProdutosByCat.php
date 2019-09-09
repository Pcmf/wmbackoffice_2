<?php
/* 
 * This code was developed by PCF
 * Each line should be prefixed with  * 
 */
require_once 'openCon.php';
$data = file_get_contents("php://input");

$dt = json_decode($data);
$parms = json_decode($dt->parms);

$resp = array();
$prod0 = array();
$prod1 = array();

//echo $parms->cat;
//List communs product - to exclude the ones that are already on company
$result0 = mysql_query(sprintf("SELECT PR.*, C.category FROM product PR"
        . " JOIN categories C ON PR.catid = C.id AND C.company = PR.company "
        . " WHERE PR.company = 0 AND PR.catid = %s"
        ." AND PR.id NOT IN(SELECT P.id FROM `product`P WHERE P.company = %s AND P.catid = %s)"
        ,$parms->cat, $parms->cid, $parms->cat));
if($result0){
    while ($row0 = mysql_fetch_array($result0)) {
        $row0['cj'] = json_decode($row0['category']); 
        $row0['nj'] = json_decode($row0['name']);
        $row0['dj'] = json_decode($row0['description']);
        array_push($prod0, $row0);
    }
    $resp['prod0'] = $prod0;
}
//Select produts in menu
$result = mysql_query(sprintf("SELECT P.*,C.category FROM product P"
        . " JOIN categories C ON P.catid = C.id AND C.company = P.company "
        . " WHERE P.company = %s AND P.catid = %s",$parms->cid,$parms->cat));
if($result){
    while ($row = mysql_fetch_array($result)) {
        $row['cj'] = json_decode($row['category']); 
        $row['nj'] = json_decode($row['name']);
        $row['dj'] = json_decode($row['description']);
        array_push($prod1, $row);
    }
    $resp['prod1'] = $prod1;

    echo json_encode($resp);
}
//echo 'erro';

