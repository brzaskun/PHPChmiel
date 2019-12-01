<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["HTTP_HOST"] != "localhost:8000") {
    $_SESSION['host'] = 'mysql:host=172.16.0.6;';
} else {
    $_SESSION['host'] = 'mysql:host=localhost;'; 
}
$czasbiezacy = date("d.m.Y");
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$sql1 = "SELECT * FROM zakladpracy ORDER BY `zakladpracy`.`nazwazakladu` ASC";
$wynik = R::getAll($sql1);
foreach ($wynik as $value) {
    echo $value['nazwazakladu'];
    echo "<br/>";
    $sql2 = "SELECT * FROM uczestnicy WHERE firma_id=".$value['id'];
    $uczestnicy = R::getAll($sql2);
//    echo "uczestnicy w firmie: ".sizeof($uczestnicy);
//    echo "<br/>";
    $sql2 = "SELECT nazwagrupy FROM grupyupowaznien WHERE firma_id=".$value['id'];
    $grupyupowaznien = R::getCol($sql2);
    $sql2 = "SELECT id,nazwagrupy FROM grupyupowaznien WHERE firma_id=".$value['id'];
    $grupyupowaznienid = R::getAll($sql2);
//    echo "grupy upowaznien w firmie: ".sizeof($grupyupowaznien);
//    echo "<br/>";
    $grupyzbiorcze = array();
    foreach ($uczestnicy as $ucz) {
        $sql2 = "SELECT grupa FROM uczestnikgrupy WHERE id_uczestnik=".$ucz['id'];
        $uczgrupy = R::getCol($sql2);
//        echo "grupy pojedynczego uczestnika: ".sizeof($uczgrupy);
//        echo "<br/>";
        foreach ($uczgrupy as $uczgr) {
            array_push($grupyzbiorcze, $uczgr);
            //echo $uczgr;
            //echo ",";
        }
        //echo "<br/>";
    }
    $grupyunique = array_unique($grupyzbiorcze);
    $dif = array_diff($grupyupowaznien,$grupyunique);
    if (sizeof($grupyunique)> sizeof($grupyupowaznien)) {
        $dif = array_diff($grupyunique,$grupyupowaznien);
        echo "**************";
        echo "<br/>";
        foreach ($dif as $dodruk) {
            echo $dodruk;
            echo ",";
        }
        echo "<br/>";
        echo "**************";
    } else {
        echo "**************";
        echo "<br/>";
        foreach ($dif as $dodruk) {
            foreach ($grupyupowaznienid as $dodruk1) {
                if ($dodruk1['nazwagrupy']==$dodruk) {
                    echo $dodruk1['nazwagrupy'];
                    echo ",";
                    echo $dodruk1['id'];
                    echo ",";
                }
            }
        }
        echo "<br/>";
        echo "**************";
    }
    echo "<br/>";
    echo "<br/>";
}
echo $czasbiezacy;
?>
