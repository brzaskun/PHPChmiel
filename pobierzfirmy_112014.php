<?php error_reporting(0);
  session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $sql = "SELECT zakladpracy.nazwazakladu FROM zakladpracy";
  $nazwyzakladu = R::getAll($sql);
  $output = "";
  foreach ($nazwyzakladu as $val) {
      $output = $output.",".array_shift($val);
  }
  echo $output;
?>
