<?php error_reporting(0);
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $szk = filter_input(INPUT_POST, "szk", FILTER_SANITIZE_STRING);
  $nag = filter_input(INPUT_POST, "nag", FILTER_SANITIZE_STRING);
  $sql = "SELECT * FROM szkolenie WHERE nazwaszkolenia = '$szk' AND naglowek = '$nag'";
  $slajdy = R::getAll($sql);
  $output = "";
  foreach ($slajdy as $val) {
      $output = $output.",".array_shift($val);
  }
  if ($output === "") {
      echo "nie";
  } else {
      echo "tak";
  }
?>
