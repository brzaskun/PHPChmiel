<?php 
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = filter_input(INPUT_POST,'id', FILTER_SANITIZE_STRING);
  $sql = "SELECT grupyupowaznien.nazwagrupy FROM grupyupowaznien WHERE `id`='$id'";
  $nazwagrupy = R::getRow($sql);
  $sql = "SELECT grupyupowaznien.firma FROM grupyupowaznien WHERE `id`='$id'";
  $firmanazwa = R::getRow($sql);
  $uczestnicy = array();
  $sql = "SELECT uczestnicy.email FROM uczestnicy WHERE `firma`='$firmanazwa[firma]'";
  $uczestnicy = R::getCol($sql);
  foreach ($uczestnicy as $value) {
      $sql = "SELECT uczestnikgrupy.id FROM uczestnikgrupy WHERE `grupa`='$nazwagrupy[nazwagrupy]' AND email = '$value'";
      $iduczestnikgrupa = R::getRow($sql);
      $sql = "DELETE FROM `uczestnikgrupy` WHERE `id`='$iduczestnikgrupa[id]';";
      R::exec($sql);
  }
  $sql = "DELETE FROM `grupyupowaznien` WHERE id=$id";
  R::exec($sql);
  
?>
