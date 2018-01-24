<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = filter_input(INPUT_POST, 'Nid',FILTER_SANITIZE_NUMBER_INT);
  $sql = "DELETE FROM `testwykaz` WHERE `id`='$id'";
  R::exec($sql);
  echo "lolo"; 
?>
