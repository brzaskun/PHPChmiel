<?php error_reporting(0);
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
if(session_status()!=2){     
    session_start(); 
    
};
$sciezkaroot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
require_once($sciezkaroot.'/resources/php/Rb.php');
require_once($sciezkaroot.'/resources/php/Nextslide.php');
if ($_SERVER["HTTP_HOST"] != "localhost:8000") {
    $_SESSION['host'] = 'mysql:host=172.16.0.6;';
} else {
    $_SESSION['host'] = 'mysql:host=localhost;';
}
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$mail = $_GET['mail']; 
$_COOKIE['mail'] = $mail;
setcookie("mail", $mail, time()+3600);
$parametr = "email = '$mail'";
$uczestnik = R::findOne('uczestnicy', $parametr);
$_SESSION['danewrazliwe'] = "dane szczególnej kategorii";
if (!isset($uczestnik)) {
    $url = 'index.php';
    header("Location: $url"); 
    $_SESSION['wyjdz'] = 'tak';
    exit();
} else {
    $_SESSION['uczestnik'] = $uczestnik->getProperties();
} 
//admina trzeba od razu przerzucic do jego zakladki
$wyniksprawdzaniahasla = $_GET['wynik'];
if ($_SESSION['uczestnik']['uprawnienia']=="admin"){
    if ($wyniksprawdzaniahasla == 1) {
        $url = 'admin112014_uzytkownicy.php';
        header("Location: $url");
        exit();
    } else {
        $url = 'index.php';
        header("Location: $url");
        $_SESSION['wyjdz'] = 'tak';
        exit();
    }
}
?>

