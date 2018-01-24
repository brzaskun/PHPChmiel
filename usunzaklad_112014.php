<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $nazwazakladu = $_POST['nazwazakladu'];
  $sauzytkownicy = "";
  $sql = "SELECT * FROM uczestnicy WHERE firma = '$nazwazakladu'" ;
  $sauzytkownicy = R::getAll($sql);
  if ($sauzytkownicy[0] != "") {
      echo "tak";
  } else {
      $sql = "DELETE FROM `zakladpracy` WHERE `nazwazakladu`= '$nazwazakladu'";
      R::exec($sql);
      echo "nie";
  }
  
?>
