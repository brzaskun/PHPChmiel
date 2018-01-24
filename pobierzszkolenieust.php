<?php error_reporting(0); 
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $_szkolenieust = R::getAll('SELECT * FROM szkolenieust');
  $wiersze = array();
   foreach ($_szkolenieust as $val) {
      $tab = array();
      array_push($tab,"<input type='checkbox' class=\"czekbox\"/>");
      array_push($tab, "<span class='doedycji'>".$val['id']."</span>");
      array_push($tab, "<span class='doedycji'>".$val['firma']."</span>");
      array_push($tab, "<span class='doedycji'>".$val['nazwaszkolenia']."</span>");
      array_push($tab, "<span class='doedycji'>".$val['iloscpytan']."</span>");
      array_push($tab, "<span class='doedycji'>".$val['email']."</span>");
      array_push($tab, "<span class='doedycji'>".$val['progzdawalnosci']."</span>");
      array_push($tab,"<input title=\"edytuj\" name=\"edytuj\" type='checkbox' class='czekedycja' onclick=\"editszkolenieust(this);\" class=\"buttonedytujuser\" style=\"display: none;\"/>");
      array_push($tab,"<input title=\"usuń\" name=\"usun\" type='checkbox' class='czekedycja' onclick=\"usunwiersz(this);\"  style=\"display: none;\"/>");
      array_push($wiersze, $tab);
  } 
  $output = json_encode($wiersze);
  echo $output;
 
?>
