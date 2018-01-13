<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  require_once $_SERVER['DOCUMENT_ROOT'].'/resources/php/ConvertZaswiadczenie.php';
  $sql = "SELECT * FROM szkoleniewykaz"; 
  $szkoleniawykaz = R::getAll($sql);
  $output = "";
  foreach ($szkoleniawykaz as $val) {
      $id_zaswiadczenie = $val['id_zaswiadczenie'];
      $val['id_zaswiadczenie'] = ConvertZaswiadczenie::toName($id_zaswiadczenie);
      $output = $output.",".array_shift($val);
  }
  echo $output;
?>
