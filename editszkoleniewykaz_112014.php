<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  require_once $_SERVER['DOCUMENT_ROOT'].'/resources/php/ConvertZaswiadczenie.php';
  $id = $_POST['Nid'];
  $Nszkolenia = $_POST['Nszkolenia'];
  $Nskrot = $_POST['Nskrot'];
  $Nopis = $_POST['Nopis'];
  $Nzaswiadczenie = $_POST['Nzaswiadczenie'];
  $Ninstrukcja = $_POST['Ninstrukcja'];
  $id_zas = ConvertZaswiadczenie::toId($Nzaswiadczenie);
  $sql = "UPDATE  `szkoleniewykaz` SET `skrot` = '$Nskrot', `opis` = '$Nopis', `id_zaswiadczenie` = '$id_zas', `instrukcja` = '$Ninstrukcja' WHERE `id`=$id"; 
  R::exec($sql);
?>

