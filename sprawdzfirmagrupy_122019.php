<?php
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
if (session_status() != 2) {
    session_start();
};
error_reporting(0);
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Rb.php');
try {
    R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
} catch (Exception $e){}
$firmabaza = urldecode($_COOKIE['firmadoimportu']);
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/FirmaNazwaToId.php');
$firma_id = FirmaNazwaToId::wyszukaj($firmabaza);
//ta czesc sluzy do wylapywania nowych grup, ktorych nie ma przypisanych do firmy
$szkoleniaprzypisane = R::getCol("SELECT `nazwagrupy` FROM `grupyupowaznien` WHERE `firma_id`=$firma_id");
$dupsbaza = array();
$tablicaszkolen = json_decode($_SESSION['tablicaszkolen'], true);
unset($_SESSION['tablicaszkolen']);
foreach ($tablicaszkolen as $wierszyk) {
    if (!in_array($wierszyk, $szkoleniaprzypisane)) {
        array_push($dupsbaza, $wierszyk);
    }
}
$zwrot = "ok";
if (!empty($dupsbaza)) {
    $zwrot = $dupsbaza;
}
echo json_encode($zwrot);
                //koniec wylapywania nowych grup, ktorych nie ma przypisanych do firmy
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

