<?php
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = filter_input(INPUT_POST,'id', FILTER_SANITIZE_STRING);
  try {
        $sql = "DELETE FROM `uczestnicyarchiwum` WHERE id='$id'";
        R::exec($sql);
  } catch (Exception $e) {
  }
?>