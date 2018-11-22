<?php
  error_reporting(0);
  if(session_status()!=2){     session_start(); };
  date_default_timezone_set('Europe/Warsaw');
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING);
  $data = date("Y-m-d H:i:s");
  $sqlnull = "UPDATE  `uczestnicy` SET `sessionstart` = NULL, `sessionend` = NULL, `wcisnietyklawisz` = NULL, `wyniktestu` = '0', `ilosclogowan` = '0', `iloscpoprawnych` = '0', `iloscblednych` = '0', `iloscodpowiedzi` = '0', `wyslanycert` = '0', `ostatnireset`='$data'  WHERE  `uczestnicy`.`id` = '$id';";
  //$sqlnull = "UPDATE  `uczestnicy` SET `sessionstart` = null, `sessionend` = null, `ilosclogowan` = 0,  `wyniktestu` = '0' WHERE  `uczestnicy`.`id` = $id;";
  R::exec($sqlnull);

?>
