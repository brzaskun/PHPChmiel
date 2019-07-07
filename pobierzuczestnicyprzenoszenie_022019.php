<?php error_reporting(0); 
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $firma = $_POST['firmanazwa'];
  $uczestnicyrodzaj = $_POST['uczestnicyrodzaj'];
  $uczestnicystaconline = $_POST['uczestnicystaconline'];
  require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/FirmaNazwaToId.php');
  $firma_id = FirmaNazwaToId::wyszukaj($firma);
  if ($firma != "" && $firma != 'null' && $firma != "wybierz bieżącą firmę" && $firma != "wszystkiefirmy") {
      if ($uczestnicyrodzaj == "wszyscy") {
          $sql = "SELECT * FROM uczestnicy WHERE `uczestnicy`.`firma_id` = '$firma_id' GROUP BY `imienazwisko` ORDER BY `imienazwisko`";
      } else if ($uczestnicyrodzaj == "aktywni") {
          $sql = "SELECT * FROM uczestnicy WHERE `uczestnicy`.`firma_id` = '$firma_id'  AND (`uczestnicy`.`dataustania` IS NULL OR CHAR_LENGTH(`uczestnicy`.`dataustania`) < 1)  GROUP BY `imienazwisko` ORDER BY `imienazwisko`";
      } else {
          $sql = "SELECT * FROM uczestnicy WHERE `uczestnicy`.`firma_id` = '$firma_id'  AND (`uczestnicy`.`dataustania` IS NOT NULL AND CHAR_LENGTH(`uczestnicy`.`dataustania`) = 10) GROUP BY `imienazwisko`  ORDER BY `imienazwisko`";
      }
  } 
  if ($uczestnicystaconline=="stacjonarni") {
      $sql = $sql." AND `uczestnicy`.`stacjonarny`=1";
  } else if ($uczestnicystaconline=="online"){
      $sql = $sql." AND `uczestnicy`.`stacjonarny`=0";
  }
  $uczestnicy = R::getAll($sql);
  $output = array();
  if (empty($uczestnicy)) {
    array_push($output, array("brak uczestników  wwybranej firmie","-1"));
  }
  foreach ($uczestnicy as $val) {
      //array_push($output, array_shift($val));
      $pola = array($val[imienazwisko],$val[email]);
      array_push($output, $pola);
  }
  echo json_encode($output);
?>