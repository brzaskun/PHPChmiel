<?php error_reporting(0); 
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $wiersze = json_decode($_POST["dane"]);
  date_default_timezone_set('Europe/Warsaw');
  $czasbiezacy = date("Y-m-d H:i:s");
  $jakiegrupy = $_POST['jakiegrupy'];
  foreach ($wiersze as $wiersz) {
      $aktywne = array();
      $nieaktywne = array();
      $datnad = str_replace('/', '.', $wiersz->datanadania);
      $datnad = str_replace('-', '.', $datnad);
      $datust = str_replace('/', '.', $wiersz->dataustania);
      $datust = str_replace('-', '.', $datust);
      if ($jakiegrupy=="tak") {
        $sql = "UPDATE  `uczestnicy` SET wyslaneup = '$wiersz->wyslaneup', nrupowaznienia = '$wiersz->nrupowaznienia', indetyfikator = '$wiersz->indetyfikator', datanadania = '$datnad', dataustania = '$datust', zmodyfikowany = '$czasbiezacy'  WHERE  `uczestnicy`.`id` = '$wiersz->id'";
        R::exec($sql);
      } else {
          $sql = "UPDATE  `uczestnicy` SET wyslaneupdanewrazliwe = '$wiersz->wyslaneup', zmodyfikowany = '$czasbiezacy'  WHERE  `uczestnicy`.`id` = '$wiersz->id'";
        R::exec($sql);
      }
      foreach ($wiersz as $key=>$value) {
        if ($key != "id" && $key != "email" && $key != "imienazwisko" && $key != "nrupowaznienia" && $key != "indetyfikator" && $key != "datanadania" && $key != "dataustania") {
            if ($value == 1) {
                array_push($aktywne, $key);
            } else {
                array_push($nieaktywne, $key);
            }
        }
      }
      foreach ($aktywne as $val) {
          try {
            $sql = "INSERT INTO uczestnikgrupy (email,nazwiskoiimie,grupa,id_uczestnik) VALUES ('$wiersz->email','$wiersz->imienazwisko','$val','$wiersz->id');";
            R::exec($sql);
          } catch (Exception $e) {
              
          }
      }
      foreach ($nieaktywne as $val) {
          try {
            $sql = "DELETE FROM uczestnikgrupy WHERE id_uczestnik='$wiersz->id' AND grupa='$val'";
            R::exec($sql);
          } catch (Exception $e) {
              
          }
      }
  }
  $sql = "SELECT * FROM uczestnikgrupy"; 
  $uzytkownikgrupa = R::getAll($sql);
?>
