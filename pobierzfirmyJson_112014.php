<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $sql = "SELECT nazwazakladu FROM zakladpracy WHERE firmaaktywna = 1 ORDER BY nazwazakladu";
  $maile = R::getAll($sql);
  $output = array();
  array_push($output, "wybierz bieżącą firmę");
  foreach ($maile as $val) {
      array_push($output, array_shift($val));
  }
  echo json_encode($output);
?>
 