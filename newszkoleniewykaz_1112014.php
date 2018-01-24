<?php error_reporting(2);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  require_once $_SERVER['DOCUMENT_ROOT'].'/resources/php/ConvertZaswiadczenie.php';
  $Nszkolenia = $_POST['Nszkolenia'];
  $Nskrot = $_POST['Nskrot'];
  $Nopis = $_POST['Nopis'];
  $Nzaswiadczenie = $_POST['Nzaswiadczenie'];
  $Ninstrukcja = $_POST['Ninstrukcja'];
  $id_zas = ConvertZaswiadczenie::toId($Nzaswiadczenie);
  $sql = "INSERT INTO  `szkoleniewykaz` (`nazwa` , `skrot`, `opis`, `id_zaswiadczenie`, `instrukcja`) VALUES ('$Nszkolenia', '$Nskrot',  '$Nopis', '$id_zas', '$Ninstrukcja');";
  R::exec($sql);
  echo R::getInsertID();
?>
