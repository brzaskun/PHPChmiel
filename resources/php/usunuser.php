<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once('/home/tb152026/public_html/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = $_GET['userid'];
  $email = $_GET['email'];
  if ($email != 'mchmielewska@interia.pl') {
    $sql = "DELETE FROM `uczestnicy` WHERE id=$id AND email=`$email`";
    R::exec($sql);
  } else {
    header("Location: admin.php?info=Nie można usunąc admina z listy");   
  }
?>
