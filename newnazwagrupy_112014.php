<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = $_POST['Nid'];
  $firmanazwa = $_POST['Nfirmauser'];
  $grupanazwa = $_POST['Nnazwagrupy'];
  require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/FirmaNazwaToId.php');
  $firma_id = FirmaNazwaToId::wyszukaj($firmanazwa);
  $sql = "INSERT INTO `grupyupowaznien` (`firma` ,`nazwagrupy`, `firma_id`) VALUES ('$firmanazwa',  '$grupanazwa', '$firma_id');";
  R::exec($sql);
  echo R::getCell("SELECT `id` FROM  `grupyupowaznien` WHERE  (`grupyupowaznien`.`firma_id` = '$firma_id' AND  `grupyupowaznien`.`nazwagrupy` =  '$grupanazwa')");
?>
