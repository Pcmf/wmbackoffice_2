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

if(!isset($parm->prd->promotion) || $parm->prd->promotion == 0 || $parm->prd->promotion === false || $parm->prd->promotion === ''){
    $promoprice = 0;
    $promotion = 0;
} else {
    $promoprice = $parm->prd->promoprice;
    $promotion = 1;    
}
if(!isset($parm->prd->inmenu) || $parm->prd->inmenu == 0 || $parm->prd->inmenu === false){
    $parm->prd->inmenu = 0;
} else {
    $parm->prd->inmenu = 1;
}
if(!isset($parm->prd->highlight) || $parm->prd->highlight == 0 || $parm->prd->highlight === false){
    $parm->prd->highlight = 0;
} else {
   $parm->prd->highlight = 1; 
}

//IF is new product then INSERT 
if($parm->prd->id == 0){
//Get the higher ID and increse 1
    $result0 = mysql_query(sprintf("SELECT max(id) as mid FROM product WHERE company = %s",$parm->cid));
    if($result0){
        $row0 = mysql_fetch_array($result0);
        $id= $row0['mid']+1;
    }
    
    $sql = sprintf("INSERT INTO product (company,id, name, description, catid,folder, photo, price,inmenu,promotion,promoprice,highlight)"
        . " VALUES(%s,%s,'%s','%s',%s,'%s','%s',%s,%s,%s,%s,%s)"
        ,$parm->cid,$id,$pn,$desc ,$parm->prd->catid,$parm->prd->folder,$parm->prd->photo,$parm->prd->price,
        $parm->prd->inmenu,$promotion,$promoprice,$parm->prd->highlight);
//echo $sql;
$result = mysql_query($sql);
if($result){
    echo $parm->prd->catid;
    return;
} 
} else { //Se já existe
    $sqlup = sprintf("UPDATE product SET  name ='%s', description = '%s',catid=%s,folder ='%s',"
            . "photo= '%s', price=%s,inmenu=%s,promotion=%s,promoprice=%s,highlight=%s "
            . " WHERE company = %s and id= %s"
        ,$pn,$desc,$parm->prd->catid,$parm->prd->folder,$parm->prd->photo,$parm->prd->price,$parm->prd->inmenu,
            $promotion,$promoprice,$parm->prd->highlight,$parm->cid,$parm->prd->id);
    //echo $sqlup;
    $result = mysql_query($sqlup);
    if($result){
        echo $parm->prd->catid;
    }
            
}
