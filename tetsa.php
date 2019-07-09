<?php
    session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
    if (session_status() != 2) {
        session_start();
    };
  //  error_reporting(E_ALL & ~E_DEPRECATED);
    require_once('resources/php/Rb.php');
    //$_SESSION['host'] = 'mysql:host=172.16.0.6;';
    $_SESSION['host'] = 'mysql:host=localhost;';
    $_SESSION['danewrazliwe'] = "dane szczególnej kategorii";
    R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
    $parametr = "id = 1";
    $dane = R::findOne('x', $parametr);
    $properties = $dane->getProperties()['id'];
?>
