<?php 
if (session_status()!=2) {
    session_start();
}; 
error_reporting(0);
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Mail.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/SprawdzWprowadzanyWiersz.php'); 
//tablica zachowana w admin_uzytkownik_grupa_plik.php
$tablicapobranychpracownikow = $_SESSION['tablicapobranychpracownikow']; 
$firmabaza = urldecode($_COOKIE['firmadoimportu']);
$rodzajdanych = $_SESSION['rodzajdanych'];
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$updatowano = array(); 
$nieupdatowano = array(); 
foreach ($tablicapobranychpracownikow  as $wierszbaza) {
    if (SprawdzWprowadzanyWiersz::sprawdz($wierszbaza)) {
        try {
          if ($rodzajdanych == "wd") {
            $sql = "UPDATE  `uczestnicy` SET  `nrupowaznienia` =  '$wierszbaza[3]', `indetyfikator` = '$wierszbaza[4]', `datanadania` = '$wierszbaza[5]', `dataustania` = '$wierszbaza[6]' WHERE  `uczestnicy`.`id` =  '$wierszbaza[0]'";
             $wyn = R::exec($sql);
             if ($wyn==0) {
                array_push($updatowano, $wierszbaza[1]);
             }
          } else if ($rodzajdanych == "du") {
             $sql = "UPDATE  `uczestnicy` SET  `dataustania` = '$wierszbaza[6]' WHERE  `uczestnicy`.`id` =  '$wierszbaza[0]'";
             R::exec($sql);
             $wyn = R::exec($sql);
             if ($wyn==0) {
                array_push($updatowano, $wierszbaza[1]);
             }
          } else if ($rodzajdanych == "ndu") {
             $wynik = R::findOne("uczestnicy","id=15665  AND (`dataustania` IS NULL OR CHAR_LENGTH(`dataustania`) <1)");
             if ($wynik != NULL) {
                $sql = "UPDATE  `uczestnicy` SET  `dataustania` = '$wierszbaza[6]' WHERE  `uczestnicy`.`id` =  '$wierszbaza[0]'";
                R::exec($sql);
                $wyn = R::exec($sql);
                if ($wyn==0) {
                   array_push($updatowano, $wierszbaza[1]);
                }
             }
          }
        } catch (Exception $e){
            array_push($nieupdatowano, $wierszbaza[1]);
        }
    }
}
 $sumaarr = array();
 array_push($sumaarr, $updatowano);
 array_push($sumaarr, $nieupdatowano);
 $updatowanoj = json_encode($sumaarr);
  $_SESSION['rodzajdanych']="";
 echo $updatowanoj;
?>
