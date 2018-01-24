<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = $_POST['id'];
  $uczestnik = R::getAll("SELECT * FROM uczestnicyarchiwum WHERE id_uzytkownik='$id'");
  echo json_encode($uczestnik);
?>