<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = $_POST['Nid'];
  $nazwazakladu = $_POST['Nnazwazakladu'];
  $ulica = $_POST['Nulica'];
  $miejscowosc = $_POST['Nmiejscowosc'];
  $progzdawalnosci = $_POST['Nprogzdawalnosci'];
  $kontakt = $_POST['Nkontakt'];
  $email = $_POST['Nemail'];
  $maxpracownikow = $_POST['Nmaxpracownikow'];
  $managerlimit = $_POST['Nmanagerlimit'];
  $sql = "INSERT INTO  `zakladpracy` (`id` ,`nazwazakladu` ,`ulica` ,`miejscowosc`,`progzdawalnosci`, `kontakt`, `maxpracownikow`, `managerlimit`, `email`) VALUES ('$id', '$nazwazakladu',  '$ulica', '$miejscowosc', '$progzdawalnosci', '$kontakt', '$maxpracownikow', '$managerlimit', '$email');";
  try {
    R::exec($sql);
    echo R::getCell("SELECT `id` FROM  `zakladpracy` WHERE  (`nazwazakladu` = '$nazwazakladu')");
  } catch (Exception $ex) {
  }
?>
