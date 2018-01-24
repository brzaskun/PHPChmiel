<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = $_POST['Nid'];
  $Nszkolenia = $_POST['Nszkolenia'];
  $Nskrot = $_POST['Nskrot'];
  $Nopis = $_POST['Nopis'];
  $sql = "UPDATE  `testwykaz` SET `skrot` = '$Nskrot', `opis` = '$Nopis' WHERE `id`=$id";
  R::exec($sql);
?>

