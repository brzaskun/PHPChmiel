<?php error_reporting(2);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = $_POST['Nid'];
  $firmanazwa = $_POST['Nfirmauser'];
  $grupanazwa = $_POST['Nnazwagrupy'];
  $sql = "INSERT INTO `grupyupowaznien` (`id` ,`firma` ,`nazwagrupy`) VALUES ('$id', '$firmanazwa',  '$grupanazwa');";
  R::exec($sql); 
  echo R::getCell("SELECT `id` FROM  `grupyupowaznien` WHERE  (`grupyupowaznien`.`firma` = '$firmanazwa' AND  `grupyupowaznien`.`nazwagrupy` =  '$grupanazwa')");
?>
