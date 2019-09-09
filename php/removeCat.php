<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'openCon.php';

$data = file_get_contents("php://input");
$dt = json_decode($data);
$parm = json_decode($dt->params);

$result0 = mysql_query(sprintf("SELECT configs from menutype where company=%s",$parm->company));

if($result0){
    $row0 = mysql_fetch_array($result0);
    $configsArr = explode(',', $row0[0]);
    if (($key = array_search($parm->id, $configsArr)) !== false) {
        unset($configsArr[$key]);
        $configs = implode(',', $configsArr);
        $result = mysql_query(sprintf("UPDATE menutype SET configs='%s' WHERE company=%s",
                $configs,$parm->company));
    }
}