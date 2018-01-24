<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $idust = $_POST['idszkolenieust'];
  $firmaszkoleniaust = $_POST['firmaszkoleniaust'];
  $nazwaszkoleniaust = $_POST['nazwaszkoleniaust'];
  $iloscpytanust= $_POST['iloscpytanust'];
  $emailust= $_POST['emailust'];
  $progzdawalnosciust= $_POST['progzdawalnosciust'];
  //unescape danych ktore wczesniej escape javascript
  $sql = "UPDATE  `szkolenieust` SET `iloscpytan` = '$iloscpytanust' WHERE `firma`='$firmaszkoleniaust' AND `nazwaszkolenia`='$nazwaszkoleniaust';";
  R::exec($sql);
  if (isset($emailust)) {
      if ($emailust != "") {
        $sql = "UPDATE  `szkolenieust` SET `email` = '$emailust' WHERE `firma`='$firmaszkoleniaust' AND `nazwaszkolenia`='$nazwaszkoleniaust';";    
        R::exec($sql);
      } else {
          $sql = "UPDATE  `szkolenieust` SET `email` = NULL WHERE `firma`='$firmaszkoleniaust' AND `nazwaszkolenia`='$nazwaszkoleniaust';";    
        R::exec($sql);
      }
  }
  if (isset($progzdawalnosciust)) {
      if ($progzdawalnosciust != "") {
        $sql = "UPDATE  `szkolenieust` SET `progzdawalnosci` = '$progzdawalnosciust' WHERE `firma`='$firmaszkoleniaust' AND `nazwaszkolenia`='$nazwaszkoleniaust';";    
        R::exec($sql);
      } else {
          $sql = "UPDATE  `szkolenieust` SET `progzdawalnosci` = NULL WHERE `firma`='$firmaszkoleniaust' AND `nazwaszkolenia`='$nazwaszkoleniaust';";    
        R::exec($sql);
      }
  }
?>

