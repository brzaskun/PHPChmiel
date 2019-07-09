<?php 
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
if (session_status() != 2) {
    session_start();
};
error_reporting(1);
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Rb.php');
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$firma = $_POST['firmanazwa'];
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/FirmaNazwaToId.php');
$firma_id = FirmaNazwaToId::wyszukaj($firma);
$uczestnicy = json_decode($_POST['uczestnicy']);
date_default_timezone_set('Europe/Warsaw');
$czasbiezacy = date("Y-m-d H:i:s");
try {
    //musza byc dwa bo wpisywal 0 a nie null jak bylo nic w stringu a musi byc null bo tylko wtedy generuje rozpoczecie sesji
    foreach ($uczestnicy as $value) {
        $sql = "UPDATE  `uczestnicy` SET  `firma` = '$firma', `firma_id`= '$firma_id' WHERE  `email` = '$value[1]' AND `imienazwisko` = '$value[0]'";
        R::exec($sql);
    }
} catch (Exception $e) {
    $czasbiezacy = date("Y-m-d H:i:s");
}

?>