<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = $_POST['idzaklad'];
  $nazwazakladu = $_POST['nazwazakladu'];
  $ulica = $_POST['ulica'];
  $miejscowosc = $_POST['miejscowosc'];
  $progzdawalnosci = $_POST['progzdawalnosci'];
  $firmaaktywna = '0';
  $kontakt = $_POST['kontakt'];
  $email = $_POST['email'];
  $maxpracownikow = $_POST['maxpracownikow'];
  $managerlimit = $_POST['managerlimit'];
  if ($_POST['firmaaktywna'] == 'aktywna') {
    $firmaaktywna = '1';
  }
  $sql = "UPDATE  `zakladpracy` SET  `ulica` = '$ulica', `miejscowosc` = '$miejscowosc', `progzdawalnosci`='$progzdawalnosci' ,"
          . " `firmaaktywna` = '$firmaaktywna', `kontakt` = '$kontakt', `email` = '$email', `maxpracownikow` = $maxpracownikow, `managerlimit` = $managerlimit"
          . " WHERE  `zakladpracy`.`nazwazakladu` = '$nazwazakladu'"; 
  R::exec($sql);
?>
