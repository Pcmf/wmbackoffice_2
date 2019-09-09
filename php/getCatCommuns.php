<?php

/* 
 * This code was developed by PCF
 * 
 * Obter as categorias comuns que ainda não estejam registadas no menutype para 
 * a companhia atual
 */
require_once 'openCon.php';

//$data = file_get_contents("php://input");
//$dt = json_decode($data);
//$parm = json_decode($dt->parm);
//$menu = $parm->menu;

//
$resp = array();
$arrTemp = array();
$result = mysql_query("SELECT * FROM categories WHERE company = 0");
if($result){
    while ($row = mysql_fetch_array($result)) {
        $row['catj'] = json_decode($row['category']);
        array_push($arrTemp, $row);
    }
    $resp['catg'] = $arrTemp;
}
echo json_encode($resp);
