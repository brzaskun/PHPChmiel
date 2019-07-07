<?php 
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = filter_input(INPUT_POST,'id', FILTER_SANITIZE_STRING);
  $sql = "SELECT grupyupowaznien.nazwagrupy FROM grupyupowaznien WHERE `id`='$id'";
  $nazwagrupy = R::getRow($sql);
  $sql = "SELECT grupyupowaznien.firma_id FROM grupyupowaznien WHERE `id`='$id'";
  $firma_id = R::getRow($sql);
  $uczestnicy = array();
  $sql = "SELECT uczestnicy.id FROM uczestnicy WHERE `firma_id`='$firma_id[firma_id]'";
  $uczestnicy_id = R::getCol($sql);
  foreach ($uczestnicy_id as $value) {
      $sql = "DELETE FROM `uczestnikgrupy` WHERE `id_uczestnik`='$value' AND `grupa`='$nazwagrupy[nazwagrupy]';";
      R::exec($sql);
  }
  $sql = "DELETE FROM `grupyupowaznien` WHERE id=$id";
  R::exec($sql);
  
?>
