<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = $_POST['Nid'];
  $id_int = (int)preg_replace('/(\<span\>|\<\/span\>)/', '', $id);
  $sql = "DELETE FROM `szkoleniewykaz` WHERE `id`=$id_int";
  R::exec($sql);
  echo "lolo"; 
?>
