<?php error_reporting(2);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $Ntestu = filter_input(INPUT_POST, 'Ntestu', FILTER_SANITIZE_STRING);
  $Nskrot = filter_input(INPUT_POST, 'Nskrot', FILTER_SANITIZE_STRING);
  $Nopis = filter_input(INPUT_POST, 'Nopis', FILTER_SANITIZE_STRING);
  $sql = "INSERT INTO  `testwykaz` (`nazwa` , `skrot`, `opis`) VALUES ('$Ntestu', '$Nskrot',  '$Nopis');";
  R::exec($sql);
  echo R::getInsertID();
?>
