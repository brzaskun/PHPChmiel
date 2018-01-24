<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = $_POST['idgrupa'];
  $firmanazwa = $_POST['firmanazwa'];
  $nazwagrupy = $_POST['nazwagrupy']; 
  $sql = "SELECT grupyupowaznien.nazwagrupy FROM grupyupowaznien WHERE `id`='$id'";
  $staranazwa = R::getRow($sql);
  $sql = "UPDATE  `grupyupowaznien` SET  `firma`='$firmanazwa', `nazwagrupy`='$nazwagrupy' WHERE `id`='$id';";
  R::exec($sql);
  $uczestnicy = array();
  $sql = "SELECT uczestnicy.email FROM uczestnicy WHERE `firma`='$firmanazwa'";
  $uczestnicy = R::getCol($sql);
  foreach ($uczestnicy as $value) {
      $sql = "SELECT uczestnikgrupy.id FROM uczestnikgrupy WHERE `grupa`='$staranazwa[nazwagrupy]' AND email = '$value'";
      $iduczestnikgrupa = R::getRow($sql);
      $sql = "UPDATE  `uczestnikgrupy` SET  `grupa`='$nazwagrupy' WHERE `id`='$iduczestnikgrupa[id]';";
      R::exec($sql);
  }
?>

