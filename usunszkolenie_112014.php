<?php error_reporting(0);
  session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');   if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = $_POST['idszkolenie'];
  $nazwaszkolenia = $_POST['nazwaszkolenia'];
  $naglowek = $_POST['naglowek'];
  $temat = $_POST['temat'];
  //unescape danych ktore wczesniej escape javascript
  $str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($tresc));
  $trescnowa = html_entity_decode($str,null,'UTF-8');
  $sql = "DELETE FROM `szkolenie` WHERE `id`=$id";
  R::exec($sql);
  
?>

