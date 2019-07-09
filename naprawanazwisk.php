<?php
ini_set('memory_limit', '1024M');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
if (session_status() != 2) {
        session_start(); 
};
echo "start";
error_reporting(2);
if ($_SERVER["HTTP_HOST"] != "localhost:8000") {
    $_SESSION['host'] = 'mysql:host=172.16.0.6;';
} else {
    $_SESSION['host'] = 'mysql:host=localhost;';
}
echo "dalej";
try {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Rb.php');
    R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
    //$sql = 'SELECT id,imienazwisko FROM uczestnicy LIMIT 10';
    //$imienazwiskozbazy = R::find('uczestnicy');
    $rozm = 21200;
    for ($il=0;$il<=$rozm;) {
        $mil = $il+1000;
        $warunek = "ID >$il AND ID <$mil";
        echo $warunek;
        $imienazwiskozbazypart = R::find('uczestnicy', $warunek);
        echo sizeof($imienazwiskozbazypart);
        echo "<br/>";
        $il = $il+1000;
        foreach ($imienazwiskozbazypart as $val1) {
        $imnaz = $val1["imienazwisko"];
        $lastChar = strlen($imnaz) -1;
        $koncowka = $imnaz[$lastChar];
        if( trim($koncowka) == "" ) {
            echo $imnaz;
            echo " ";
            echo $val1["id"];
            echo "<br/>";
            $val1->imienazwisko = trim($imnaz);
            R::store($val1);
        }
    }
    }

    echo "Koniec "+ sizeof($imienazwiskozbazy);
} catch (Exception $ex) {
    echo "Blad";
    echo $ex;
    die();
}