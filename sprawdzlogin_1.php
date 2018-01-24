<?php
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');
if (session_status() != 2) {
    session_start();
};
$_SESSION['host'] = 'mysql:host=172.16.0.6;';
//$_SESSION['host'] = 'mysql:host=localhost;';
error_reporting(E_ALL);
$zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
require_once('resources/php/Rb.php');
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$iduczestnika = $_COOKIE['iduczestnika'];
setcookie("iduczestnika", "", time() - 3600);
$mail = "";
if (isset($_SESSION['automail'])) {
    $mail = $_SESSION['automail'];
    $_SESSION['automail'] = null;
} else {
    $mail = $_POST['mail'];
}
$_COOKIE['mail'] = $mail;
setcookie("mail", $mail, time() + 3600);
$parametr = "email = '$mail'";
$uczestnik = R::findAll('uczestnicy', $parametr);
if (isset($iduczestnika)) {
    $parameter = "id='$iduczestnika'";
    $znaleziony_ucz = R::findOne('uczestnicy', $parameter);
    $_SESSION['uczestnik'] = $znaleziony_ucz->getProperties();
    $url = "sprawdzlogin_2.php?$zm";
    header("Location: $url");
    exit();
} else if (sizeof($uczestnik) == 0) {
    $url = "index.php?$zm";
    header("Location: $url");
    $_SESSION['wyjdz'] = 'tak';
    exit();
} else if (sizeof($uczestnik) == 1) {
    $_SESSION['uczestnik'] = array_values($uczestnik)[0]->getProperties();
    $url = "sprawdzlogin_2.php?$zm";
    header("Location: $url");
    exit();
} else {
    $_SESSION['mail'] = $mail;
    $url = "sprawdzlogin_wybor.php?$zm";
    header("Location: $url");
    exit();
}
?>
