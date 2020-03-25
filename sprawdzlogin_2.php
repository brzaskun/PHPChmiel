<?php
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
if (session_status() != 2) {
    session_start();
};
error_reporting(2);
$sciezkaroot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
require_once($sciezkaroot . '/resources/php/Rb.php');
require_once($sciezkaroot . '/resources/php/Nextslide.php');
require_once($sciezkaroot . '/resources/php/PobierzIP.php');
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$sqlfirma = $_SESSION['uczestnik']['firma'];
$firma_id = $_SESSION['uczestnik']['firma_id'];
$sql = "SELECT `firmaaktywna` FROM `zakladpracy` WHERE `zakladpracy`.`id`='$firma_id';";
$firmaaktywna = R::getCell($sql);
$sql = "SELECT `progzdawalnosci` FROM `zakladpracy` WHERE `zakladpracy`.`id`='$firma_id';";
$_SESSION['progzdawalnosciuczestnik'] = R::getCell($sql);
$sql = "SELECT `maxpracownikow` FROM `zakladpracy` WHERE `zakladpracy`.`id`='$firma_id';";
$_SESSION['maxpracownikow'] = R::getCell($sql);
$sql = "SELECT `managerlimit` FROM `zakladpracy` WHERE `zakladpracy`.`id`='$firma_id';";
$_SESSION['managerlimit'] = R::getCell($sql);
$sql = "SELECT `kontakt` FROM `zakladpracy` WHERE `zakladpracy`.`id`='$firma_id';";
$_SESSION['uczestnik']['kontakt'] = R::getCell($sql);
$nazwaszkolenia = $_SESSION['uczestnik']['nazwaszkolenia'];
$sql = "SELECT `email` FROM `zakladpracy` WHERE `zakladpracy`.`id`='$firma_id';";
$_SESSION['uczestnik']['BCC'] = R::getCell($sql);
$sql = "SELECT `iloscpytan` FROM `szkolenieust` WHERE `szkolenieust`.`firma_id`='$firma_id' AND `szkolenieust`.`nazwaszkolenia`='$nazwaszkolenia';";
$_SESSION['uczestnik']['iloscpytan'] = R::getCell($sql);
$ilosclogowan = $_SESSION['uczestnik']['ilosclogowan'];
//czas sesji jest potrzebny i dla managera i dla usera 
date_default_timezone_set('Europe/Warsaw');
$czasbiezacy = date("Y-m-d H:i:s");
$id = $_SESSION['uczestnik']['id'];
$zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
$ip = PobierzIp::getClientIP(true);
R::exec("UPDATE  `uczestnicy` SET  `iplogowania`='$ip' WHERE  `uczestnicy`.`id` = '$id';");
if (!isset($_SESSION['uczestnik']['sessionstart'])) {
    //rejestrowanie pierwszego zalogowania
    R::exec("UPDATE  `uczestnicy` SET  `sessionstart`='$czasbiezacy' WHERE  `uczestnicy`.`id` = '$id';");
    $_SESSION['uczestnik']['sessionstart'] = $czasbiezacy;
}
//managera tez przerzucamy od razu do jego zakladki :)
if ($_SESSION['uczestnik']['uprawnienia'] == "manager") {
    $url = "manager.php?$zm";
    header("Location: $url");
    exit();
}

//jezeli uczestnik jest z firmy nieaktywnej to przekieruj na specjalny slide
if ($firmaaktywna==0) {
    $url = "exit_.php?$zm";
    header("Location: $url");
    $_SESSION['wyjdz'] = 'tak';
    exit();
}
//to usuuwamy bo sa wyjatki
if (isset($_SESSION['uczestnik']['dataustania']) && $_SESSION['uczestnik']['dataustania']!='') {
    $zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
    $url = "exit_dataustania.php?$zm";
    header("Location: $url");
    $_SESSION['wyjdz'] = 'tak';
    exit();
}
//jezeli uczestnik zdal test to nie ma sensu robic innych rzeczy tylko przekierowac go na strone wynik testu. moze chce sobie przypomniec chwile chwaly
//lub pobrac certyfikat
if (isset($_SESSION['uczestnik']['sessionend'])) {
    $zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
    $url = "exit_zdanytest.php?$zm";
    header("Location: $url");
    $_SESSION['wyjdz'] = 'tak';
    exit();
}
if (isset($_SESSION['uczestnik']['sessionstart'])) {
    $czasrozpoczecia = $_SESSION['uczestnik']['sessionstart'];
    $datetime1 = new DateTime($czasrozpoczecia);
    $datetime2 = new DateTime($czasbiezacy);
    $intervald = $datetime1->diff($datetime2)->d;
    if ($intervald > 0) {
        $url = "exit_mineladoba.php?$zm";
        header("Location: $url");
        exit();
    }
}
//robi update ilosci logowan

if ($_SESSION['uczestnik']['uprawnienia'] != "admin") {
    if ($ilosclogowan > 3) {
        $ilosclogowan++;
        R::exec("UPDATE  `uczestnicy` SET `ilosclogowan`='$ilosclogowan', `dataostatniegologowania`='$czasbiezacy' WHERE  `uczestnicy`.`id` = '$id';");
        $_SESSION['test'] = null;
        $url = "exit_zaduzoszkolen.php?$zm";
        header("Location: $url");
        exit();
    } else {
        $ilosclogowan++;
        R::exec("UPDATE  `uczestnicy` SET `ilosclogowan`='$ilosclogowan', `dataostatniegologowania`='$czasbiezacy' WHERE  `uczestnicy`.`id` = '$id';");
        $_SESSION['test'] = null;
        $_SESSION['szkolenietrwa'] = "tak";
        unset($_SESSION['szkolenie']);
        $nazwaszkolenia = $_SESSION['uczestnik']['nazwaszkolenia'];
        $sql = "SELECT `nazwaszkolenia` FROM `uczestnicy` WHERE `uczestnicy`.`id` = '$id';";
        $_SESSION['uczestnik']['nazwaszkolenia'] = R::getCell($sql);
        $url = "szkolenie.php?$zm";
        header("Location: $url");
        exit();
    }
}
?>

