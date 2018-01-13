<?php error_reporting(0);
  if(session_status()!=2){session_start();};
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  $tab = json_decode($_POST['tab']);
  R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $trescM =  addslashes($tab[8]); 
  $trescK =  addslashes($tab[9]); 
  $sql = "UPDATE `zaswiadczenia` SET `skrot` = '$tab[2]', `poziom` = '$tab[3]', `linia1` = '$tab[4]', `linia2` = '$tab[5]',  `linia3` = '$tab[6]', `pdf` = '$tab[7]', `trescM` = '$trescM', `trescK` = '$trescK' WHERE `id` = '$tab[0]'";
  R::exec($sql);
?>

