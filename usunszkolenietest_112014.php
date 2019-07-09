<?php error_reporting(0);
  session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');   if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = $_POST['Nid'];
  $Nszkolenie = $_POST['Nszkolenie'];
  $Ntest = $_POST['Ntest'];
  $Nuwagi = $_POST['Nuwagi'];
  //unescape danych ktore wczesniej escape javascript
  $sql = "DELETE FROM `szkolenietest` WHERE `id`='$id'";
  R::exec($sql);
?>

