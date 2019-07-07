<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $sql = "SELECT distinct zakladpracy.nazwazakladu FROM zakladpracy RIGHT JOIN uczestnicy ON zakladpracy.id = uczestnicy.firma_id WHERE firmaaktywna = 1 ORDER BY nazwazakladu";
  $maile = R::getAll($sql);
  $output = array();
  array_push($output, "wybierz bieżącą firmę");
  foreach ($maile as $val) {
      array_push($output, array_shift($val));
  }
  echo json_encode($output);
?>
 