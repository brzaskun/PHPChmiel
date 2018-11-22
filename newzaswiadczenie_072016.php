<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $Nnazwazaswiadczenia = $_POST['Nnazwazaswiadczenia'];
  $Nskrot = $_POST['Nskrot'];
  $Npoziom = $_POST['Npoziom'];
  $Nlinia1 = $_POST['Nlinia1'];
  $Nlinia2 = $_POST['Nlinia2'];
  $Nlinia3 = $_POST['Nlinia3'];
  $NtrescM =  addslashes($_POST['NtrescM']);
  $NtrescK =  addslashes($_POST['NtrescK']);
  $Npdf = $_POST['Npdf']; 
  $sql = "INSERT INTO  `zaswiadczenia` (`nazwa` ,`skrot`,`poziom`,`linia1`,`linia2`,`linia3`,`trescM`, `trescK`,`pdf`) VALUES ('$Nnazwazaswiadczenia', '$Nskrot',  '$Npoziom', '$Nlinia1', '$Nlinia2', '$Nlinia3', '$NtrescM', '$NtrescK', '$Npdf');";
  try {
    R::exec($sql); 
    echo R::getCell("SELECT `id` FROM  `zaswiadczenia` WHERE  (`nazwa` = '$Nnazwazaswiadczenia' AND  `skrot` =  '$Nskrot')");
  } catch (Exception $e) {
      echo "błąd";
  } 
?>
