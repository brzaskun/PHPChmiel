<?php error_reporting(0);
  session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');   if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $idust = $_POST['idszkolenieust'];
  $firmaszkoleniaust = $_POST['firmaszkoleniaust'];
  require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/FirmaNazwaToId.php');
  $firma_id = FirmaNazwaToId::wyszukaj($firmaszkoleniaust);
  $nazwaszkoleniaust = $_POST['nazwaszkoleniaust'];
  $iloscpytanust= $_POST['iloscpytanust'];
  $emailust= $_POST['emailust'];
  $progzdawalnosciust= $_POST['progzdawalnosciust'];
  $nazwaupowaznienia= $_POST['nazwaupowaznienia'];
  //unescape danych ktore wczesniej escape javascript
  $sql = "UPDATE  `szkolenieust` SET `iloscpytan` = '$iloscpytanust' WHERE `firma_id`='$firma_id' AND `nazwaszkolenia`='$nazwaszkoleniaust';";
  R::exec($sql);
  $sql = "UPDATE  `szkolenieust` SET `upowaznienie` = '$nazwaupowaznienia' WHERE `firma_id`='$firma_id' AND `nazwaszkolenia`='$nazwaszkoleniaust';";
  R::exec($sql);
  if (isset($emailust)) {
      if ($emailust != "") {
        $sql = "UPDATE  `szkolenieust` SET `email` = '$emailust' WHERE `firma_id`='$firma_id' AND `nazwaszkolenia`='$nazwaszkoleniaust';";    
        R::exec($sql);
      } else {
          $sql = "UPDATE  `szkolenieust` SET `email` = NULL WHERE `firma_id`='$firma_id' AND `nazwaszkolenia`='$nazwaszkoleniaust';";    
        R::exec($sql);
      }
  }
  if (isset($progzdawalnosciust)) {
      if ($progzdawalnosciust != "") {
        $sql = "UPDATE  `szkolenieust` SET `progzdawalnosci` = '$progzdawalnosciust' WHERE `firma_id`='$firma_id' AND `nazwaszkolenia`='$nazwaszkoleniaust';";    
        R::exec($sql);
      } else {
          $sql = "UPDATE  `szkolenieust` SET `progzdawalnosci` = NULL WHERE `firma_id`='$firma_id' AND `nazwaszkolenia`='$nazwaszkoleniaust';";    
        R::exec($sql);
      }
  }
?>

