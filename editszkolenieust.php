<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $idust = $_POST['idszkolenieust'];
  $firmaszkoleniaust = $_POST['firmaszkoleniaust'];
  $nazwaszkoleniaust = $_POST['nazwaszkoleniaust'];
  $iloscpytanust= $_POST['iloscpytanust'];
  //unescape danych ktore wczesniej escape javascript
  if(isset($_POST['edytujszkolenieust'])){
    $sql = "UPDATE  `szkolenieust` SET  `firma` = '$firmaszkoleniaust', `nazwaszkolenia` = '$nazwaszkoleniaust ', `iloscpytan` = '$iloscpytanust' WHERE  `szkolenieust`.`id` = $idust;";
    R::exec($sql);
    //header("Location: admin.php?info=Dane jednostki szkolenia pomyślnie zmienione");
  } else {
    $sql = "DELETE FROM `szkolenieust` WHERE `id`=$idust";
    R::exec($sql);
    //header("Location: admin.php?info=Jednostka szkolenia usunięta");
  }
  
?>

