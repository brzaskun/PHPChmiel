<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = $_POST['idszkolenie'];
  $nazwaszkolenia = $_POST['nazwaszkolenia'];
  $naglowek = $_POST['naglowek'];
  $temat = $_POST['temat'];
  $tresc = $_POST['trescszkolenia'];
  $sql = "TRUNCATE TABLE  `szkoleniepodglad`";
  R::exec($sql);
  $sql = "INSERT INTO `szkoleniepodglad` (`id` ,`nazwaszkolenia` ,`naglowek` ,`temat`,`tresc`) VALUES ('1', '$nazwaszkolenia',  '$naglowek', NULL, '$tresc');";
  R::exec($sql); 
  echo R::getCell("SELECT opis FROM szkoleniewykaz WHERE nazwa = '$nazwaszkolenia'");
?>

