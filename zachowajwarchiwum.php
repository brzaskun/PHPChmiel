<?php
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');
if (session_status() != 2) {
        session_start();
};
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Rb.php');
R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
//$firma = "ODOMG";
//if ($firma != "" && $firma != 'null' && $firma != "wybierz bieżącą firmę" && $firma != "wszystkiefirmy") {
//    $sql = "SELECT * FROM uczestnicy WHERE `uczestnicy`.`firma` = '$firma'";
//} else if ($firma == "wszystkiefirmy") {
//    $sql = "SELECT * FROM zakladpracy INNER JOIN uczestnicy ON `uczestnicy`.`firma` = `zakladpracy`.`nazwazakladu` WHERE `zakladpracy`.`firmaaktywna` = 1 ORDER BY `uczestnicy`.`id` DESC";
//} else {
//    echo "brak";
//}
$sql = "SELECT * FROM uczestnicy";
$uczestnicy = R::getAll($sql);
date_default_timezone_set('Europe/Warsaw');
foreach ($uczestnicy as $val) {
    $wyslanycert = $val['wyslanycert'];
    if ($wyslanycert) {
        $id = $val['id'];
        $wyslanymailupr = $val['wyslanymailupr'];
        $sessionstart = $val['sessionstart'];
        $sessionend = $val['sessionend'];
        $wyniktestu = $val['wyniktestu'];
        $ilosclogowan = $val['ilosclogowan'];
        $iloscpoprawnych = $val['iloscpoprawnych'];
        $iloscblednych = $val['iloscblednych'];
        $iloscodpowiedzi = $val['iloscodpowiedzi'];
        $nrupowaznienia = $val['nrupowaznienia'];
        $indetyfikator = $val['indetyfikator'];
        $datanadania = $val['datanadania'];
        $dataustania = $val['dataustania'];
        $wyslaneup = $val['wyslaneup'];
        $data = date("Y-m-d H:i:s");
        $nazwaszkolenia = $val['nazwaszkolenia'];
        $sql = "INSERT INTO `tb152026_testdane`.`uczestnicyarchiwum`
        (`id_uzytkownik`,`wyslanymailupr`,`sessionstart`,`sessionend`,`wyniktestu`,`wyslanycert`,
        `ilosclogowan`,`iloscpoprawnych`,`iloscblednych`,`iloscodpowiedzi`,`nrupowaznienia`,
        `indetyfikator`,`datanadania`,`dataustania`,`wyslaneup`,`data`,`nazwaszkolenia`)
        VALUES
        ('$id','$wyslanymailupr','$sessionstart','$sessionend','$wyniktestu','$wyslanycert','$ilosclogowan','$iloscpoprawnych','$iloscblednych','$iloscodpowiedzi'
            ,'$nrupowaznienia','$indetyfikator','$datanadania','$dataustania','$wyslaneup','$data','$nazwaszkolenia')";
        R::exec($sql);
    }
}
echo "koniec";
?>

