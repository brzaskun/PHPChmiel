<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $sql = "SELECT * FROM uczestnicy"; 
  $wynik = R::getAll($sql);
//  $output = array();
//  foreach ($maile as $val) {
//      array_push($output, array_shift($val));
//  }
  echo json_encode($wynik);
?>
 