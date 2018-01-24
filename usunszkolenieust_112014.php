<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $idust = $_POST['idszkolenieust'];
  $firmaszkoleniaust = filter_input(INPUT_POST,'firmaszkoleniaust', FILTER_SANITIZE_STRING);
  $nazwaszkoleniaust = filter_input(INPUT_POST,'nazwaszkoleniaust', FILTER_SANITIZE_STRING);
  //unescape danych ktore wczesniej escape javascript
  $zwrot = 0;
  try {
    $sql = "DELETE FROM `szkolenieust` WHERE `firma`='$firmaszkoleniaust' AND `nazwaszkolenia`='$nazwaszkoleniaust'";
    R::exec($sql);
  } catch (Exception $e) {
      $zwrot = 1;
  }
  echo $zwrot;
 ?>