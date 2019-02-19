<?php error_reporting(E_ALL); 
//  set_time_limit(0);
//
//  ini_set('memory_limit','256M');
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $nazwisko = $_POST['nazwisko'];
  $nazwisko = addslashes($nazwisko);
  $mail = $_POST['mail'];
  $firma = $_POST['firma'];
  $warunek = $_POST['warunek'];
  $uczestnicystaconline = $_POST['warunek2'];
  if (strlen ($nazwisko)>3) {
        $sql = "SELECT *  FROM uczestnicy WHERE `imienazwisko` LIKE '%$nazwisko%'";
  } else if (strlen ($mail)>3) {
        $sql = "SELECT *  FROM uczestnicy WHERE `email` LIKE '%$mail%'";
  } else if (strlen ($firma)>3) {
        $sql = "SELECT *  FROM uczestnicy WHERE `firma` LIKE '%$firma%'";
  } 
  if ($warunek == 1) {
      $sql = $sql." AND (`dataustania` IS NULL OR `dataustania`='')";
  } else if ($warunek == 2) {
      $sql = $sql." AND `dataustania` IS NOT NULL AND `dataustania`!=''";
  }
  if ($uczestnicystaconline=="stacjonarni") {
      $sql = $sql." AND `uczestnicy`.`stacjonarny`=1";
  } else if ($uczestnicystaconline=="online"){
      $sql = $sql." AND `uczestnicy`.`stacjonarny`=0";
  }
  if (strlen ($nazwisko)>3 || strlen ($mail)>3 || strlen ($firma)>3) {
        $uczestnicy = R::getAll($sql);
        $czlonkowie = array();
        //echo "start "+sizeof($uczestnicy);
         foreach ($uczestnicy as $val) {
      //       try {
              $od = $val['sessionstart'] != "" ? substr($val['sessionstart'], 0, 10) : "";
              $do = $val['sessionend'] != "" ? substr($val['sessionend'], 0, 10) : "";
              $datanadania = $val['datanadania'] != "" ? substr($val['datanadania'], 0, 10) : "";
              $dataustania = $val['dataustania'] != "" ? substr($val['dataustania'], 0, 10) : "";
              $tab = array();
              array_push($tab, "<span>" . $val['id'] . "</span>");
              array_push($tab, "<span>" . $val['email'] . "</span>");
              array_push($tab, "<span>" . $val['imienazwisko'] . "</span>");
              array_push($tab, "<span>" . $val['firma'] . "</span>");
              array_push($tab, "<span>" . $val['nazwaszkolenia'] . "</span>");
              array_push($tab, "<span>" . $val['wyslanymailupr'] . "</span>");
              array_push($tab, "<span>" . $od . "</span>");
              array_push($tab, "<span>" . $do . "</span>");
              array_push($tab, "<span>" . $datanadania . "</span>");
              array_push($tab, "<span>" . $dataustania . "</span>");
              if ($val['wyniktestu']=="101") {
                array_push($tab, "<span style=\"color: blue;\">stacj.</span>");
              } else {
                array_push($tab, "<span>".$val['wyniktestu']."</span>");
              }
              array_push($tab, "<span>" . $val['wyslanycert'] . "</span>");
              array_push($czlonkowie, $tab);
      } 
          $output = json_encode($czlonkowie); 
          echo $output;
  }

?> 