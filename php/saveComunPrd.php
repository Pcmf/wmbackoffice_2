<?php

/* 
 * This code was developed by PCF
 * Each line should be prefixed with  * 
 */
require_once 'openCon.php';

$data = file_get_contents("php://input");
$dt = json_decode($data);
$parm = json_decode($dt->parms);
$desc = $parm->description;
$pn = $parm->pn;
if($parm->prd->promotion == 0 || $parm->prd->promotion === false || $parm->prd->promotion === ''){
    $promoprice = 0;
    $promotion = 0;
} else {
    $promoprice = $parm->prd->promoprice;
    $promotion = 1;    
}
if($parm->prd->inmenu == 0 || $parm->prd->inmenu === false){
    $parm->prd->inmenu = 0;
} else {
    $parm->prd->inmenu = 1;
}
if($parm->prd->highlight == 0 || $parm->prd->highlight === false){
    $parm->prd->highlight = 0;
} else {
   $parm->prd->highlight = 1; 
}
//Tenta fazer INSERT 
$sql = sprintf("INSERT INTO product (company,id, name, description, catid,folder, photo, price,inmenu,promotion,promoprice,highlight)"
        . " VALUES(%s,%s,'%s','%s',%s,'%s','%s',%s,%s,%s,%s,%s)"
        ,$parm->cid,$parm->prd->id, $pn,$desc ,$parm->prd->catid,$parm->prd->folder,
        $parm->prd->photo,$parm->prd->price,$parm->prd->inmenu,$promotion,$promoprice,$parm->prd->highlight);
$result = mysql_query($sql);
if($result){
    echo 'Produto inserido';
} else {
    echo 'Erro';
}
