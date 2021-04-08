<?php error_reporting(0);
  session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');   if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $firmaszkolenia = filter_input(INPUT_POST, 'Nfirmaszkoleniaust', FILTER_SANITIZE_STRING);
  $nazwaszkolenia = filter_input(INPUT_POST, 'Nnazwaszkoleniaust', FILTER_SANITIZE_STRING);
  $upowaznienie = filter_input(INPUT_POST, 'Nnazwaupowaznienia', FILTER_SANITIZE_STRING);
  $iloscpytan = filter_input(INPUT_POST, 'Niloscpytanust', FILTER_SANITIZE_NUMBER_INT);
  $email = filter_input(INPUT_POST, 'Nemailust', FILTER_SANITIZE_EMAIL);
  require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/FirmaNazwaToId.php');
  $firma_id = FirmaNazwaToId::wyszukaj($firmaszkolenia);
  $sql = "INSERT INTO `szkolenieust` (`firma` ,`nazwaszkolenia` ,`iloscpytan`, `upowaznienie`, `firma_id`, `email`) VALUES ('$firmaszkolenia','$nazwaszkolenia','$iloscpytan', '$upowaznienie', '$firma_id', '$email');";
  R::exec($sql);
  echo R::getInsertID();
?>
