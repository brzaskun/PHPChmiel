<?php 
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
if (session_status() != 2) {
    session_start();
};
error_reporting(1);
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Rb.php');
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$id = $_POST['iduser'];
$email = $_POST['email'];
$imienazwisko = $_POST['imienazwisko'];
$imienazwisko = addslashes($imienazwisko);
$sessionstart = NULL;
if ($_POST['datazalogowania'] == "") {
    $sessionstart = NULL;
} else {
    $sessionstart = $_POST['datazalogowania'];
}
$nazwaszkolenia = $_POST['szkolenieuser'];
$uprawnienia = $_POST['uprawnieniauser'];
$firma = $_POST['firmausernazwa'];
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/FirmaNazwaToId.php');
$firma_id = FirmaNazwaToId::wyszukaj($firma);
$plec = $_POST['plecuser'];
$zaswiadczenieuser = $_POST['zaswiadczenieuser']; 
$upowaznienieuser = $_POST['upowaznienieuser']; 
$nic = NULL;
$zwrot = 0;
date_default_timezone_set('Europe/Warsaw');
$czasbiezacy = date("Y-m-d H:i:s");
try {
    //musza byc dwa bo wpisywal 0 a nie null jak bylo nic w stringu a musi byc null bo tylko wtedy generuje rozpoczecie sesji
    $sql = "UPDATE  `uczestnicy` SET  `email` =  '$email', `imienazwisko` =  '$imienazwisko', `plec` = '$plec', `firma` = '$firma', `firma_id` = '$firma_id', `nazwaszkolenia` = '$nazwaszkolenia', `sessionstart` = '$sessionstart' , `uprawnienia`='$uprawnienia', zmodyfikowany = '$czasbiezacy', wyslanycert = '$zaswiadczenieuser', wyslaneup = '$upowaznienieuser' WHERE  `uczestnicy`.`id` = '$id';";
    $sqlnull = "UPDATE  `uczestnicy` SET  `email` =  '$email', `imienazwisko` =  '$imienazwisko', `plec` = '$plec', `firma` = '$firma', `nazwaszkolenia` = '$nazwaszkolenia', `sessionstart` = NULL, `uprawnienia`='$uprawnienia', zmodyfikowany = '$czasbiezacy', wyslanycert = '$zaswiadczenieuser', wyslaneup = '$upowaznienieuser' WHERE  `uczestnicy`.`id` =  '$id'";
    R::exec($sessionstart == null ? $sqlnull : $sql);
} catch (Exception $e) {
    $zwrot = 1;
}
echo $zwrot;
?>