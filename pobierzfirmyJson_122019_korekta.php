<?php error_reporting(0);
  session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');   if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $sql = "SELECT nazwazakladu FROM zakladpracy WHERE firmaaktywna = 1 ORDER BY nazwazakladu";
  $maile = R::getAll($sql);
  $output = array();
  array_push($output, "wybierz bieżącą firmę do korekty");
  foreach ($maile as $val) {
      $stryng = htmlspecialchars($val[nazwazakladu]);
      array_push($output, $stryng);
  }
  echo json_encode($output);
?>
 