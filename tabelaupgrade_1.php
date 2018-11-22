<?php
    error_reporting(0);
    echo "Zaczynam<br/>";
    require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
    R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
    $sql = "SELECT * FROM grupyupowaznien";
    $grupyupowaznien = R::getAll($sql);
    foreach ($grupyupowaznien as $uczgrp) {
        $em = $uczgrp['nazwagrupy'];
        $id = $uczgrp['id'];
        if ($em == "") {
            $sql = "DELETE FROM `grupyupowaznien` WHERE  `grupyupowaznien`.`id` = '$id'";
            R::exec($sql);
        }
    } 
//    $sql = "SELECT * FROM grupyupowaznien";
//    $grupyupowaznien = R::getAll($sql);
//    $sql = "SELECT * FROM uczestnikgrupy";
//    $uczestnik_grupy = R::getAll($sql);
//    foreach ($uczestnik_grupy as $uczgrp) {
//        $em = $uczgrp['email'];
//        $id = $uczgrp['id'];
//        $ng = $uczgrp['grupa'];
//        $sql = "SELECT firma FROM uczestnicy WHERE email='$em'";
//        $firma = R::getCol($sql);
//        $jesttakagrupa = false;
//        if ($em=="anna.ciok@asmotors.pl") {
//            echo '';
//        }
//        foreach ($grupyupowaznien as $grupafirma) {
//            if ($grupafirma['firma'] == $firma[0] && $grupafirma['nazwagrupy'] == $ng) {
//                $jesttakagrupa = true;
//                break;
//            }
//        }
//        if ($jesttakagrupa == false) {
//            $sql = "DELETE FROM uczestnikgrupy WHERE `id` = $id";
//            R::exec($sql);
//        }
//    }
    echo "Koniec";
?>

