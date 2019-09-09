<?php

/* 
 * Saves category for company in categories 
 * and add it to menu types configs
 * 
 * params: 
 * cid - company id
 * result - json objet with information about the category
 * result.id  - category ID (if this id don't exist then it has to get max id and add one
 *              before insert into categories.
 * result.catj - json obj with category name in selected langs
 * result.img  - image for  this category
 * result.folder -  where is located thi image
 */
require_once 'openCon.php';

$data = file_get_contents("php://input");
$dt = json_decode($data);
$parm = json_decode($dt->params);
$company = $parm->company;
$cat = $parm->cat;
$pic = $parm->pic;

if(!isset($cat->id) || $cat->id == 0 ){
    $result0 = mysql_query(sprintf("SELECT max(id)+1 from categories"));
    if($result0){
        $cat->id = mysql_fetch_array($result0);
    }
}
//Check if exist in config / menutype
$result00 = mysql_query(sprintf("SELECT configs FROM menutype where company=%s",$company->cid));
if($result00){
    $row00 = mysql_fetch_array($result00);
    $comfigsArr = explode(',', $row00[0]);
    if(in_array($cat->id,$comfigsArr)){
        //Upadates 
        $query = sprintf("UPDATE categories SET category='%s',folder='%s',img='%s' "
                . " WHERE id=%s AND company=%s ",
                json_encode($cat->catj),$cat->folder,$pic,$cat->id,$company->cid);
        $result = mysql_query($query);
        if($result){
            echo 'OK1';
        } else {
            echo $query;
        }
    } else {
        //Inserts to categories
        $query = sprintf("INSERT INTO categories(id,company,category,business,folder,img) "
        . " VALUES(%s,%s,'%s',%s,'%s','%s') ",
        $cat->id,$company->cid, json_encode($cat->catj),$company->business,$cat->folder,$pic);
        $result = mysql_query($query);
        //insert catid to configs on menutype
        $query2 = sprintf("UPDATE menutype SET configs = CONCAT(configs,',%s') WHERE company=%s",
        $cat->id,$company->cid);        
        $result2 = mysql_query($query2);
        if($result2){
            echo 'OK2';
        } else {
            echo $query.'   '.$query2;
        }
    }
    
}



