<?php error_reporting(0);
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');
if (session_status()!=2) {
    session_start();
}; 
set_time_limit(0);
ini_set('memory_limit','256M');
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Mail.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/SprawdzWprowadzanyWiersz.php'); 
$firmabaza = urldecode($_COOKIE['firmadoimportu']);
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$tablicapobranychpracownikow = $_SESSION['tablicapobranychpracownikow'];
$nazwygrup = array();
$czasbiezacy = date("Y-m-d H:i:s");
$dataszkolenia = $_COOKIE['datadsk'];
$datanadania = explode("-", $dataszkolenia);
$datanadania = $datanadania[2].".".$datanadania[1].".".$datanadania[0];
$pierwszywiersz = array_shift($tablicapobranychpracownikow);
$dl = count((array)$pierwszywiersz);
$start = $dl-6;
$listadodanychgrup = array();
$listagrupniedodanych = array();
$zleoznaczeni = array();
$dobrzedodani = array();
$liczbadobrzedodanych = 0;
$grupanazwa = $_SESSION['danewrazliwe'];
foreach ($tablicapobranychpracownikow as $wierszbaza) {
    try {
        $imienazwisko = addslashes($wierszbaza[1]);
        $email = $wierszbaza[0];
        $nazwaszkolenia = $wierszbaza[2];
        $sql = "SELECT id FROM `uczestnicy` WHERE imienazwisko='$imienazwisko' AND email='$email' AND nazwaszkolenia='$nazwaszkolenia';";
        $id_uzytkownik = (int) R::getCell($sql);
        if ($id_uzytkownik > 0) {
            $wartoscpola = $wierszbaza[3];
            if ($wartoscpola == 1) {
                try {
                    $sql = "INSERT INTO uczestnikgrupy (email,nazwiskoiimie,grupa,id_uczestnik) VALUES ('$email','$imienazwisko','$grupanazwa', '$id_uzytkownik');";
                    R::exec($sql);
                    $sql = "UPDATE  `uczestnicy` SET  `datanadaniadsk`='$datanadania' WHERE  `uczestnicy`.`id` = '$id_uzytkownik';";
                    R::exec($sql);
                } catch (Exception $e) {
                    array_push($zleoznaczeni, $wierszbaza[0]);
                }
            } else {
                try {
                    $sql = "DELETE FROM uczestnikgrupy WHERE grupa='$grupanazwa' AND id_uczestnik='$id_uzytkownik'";
                    R::exec($sql);
                    $sql = "UPDATE  `uczestnicy` SET  `datanadaniadsk`=NULL WHERE  `uczestnicy`.`id` = '$id_uzytkownik';";
                    R::exec($sql);
                } catch (Exception $e) {
                    array_push($zleoznaczeni, $wierszbaza[0]);
                }
            }
            $liczbadobrzedodanych++;
        }
    } catch (Exception $e) {
        array_push($bledydodawanieuzytkownikow, $wierszbaza[1]);
    }
}
array_push($dobrzedodani, $liczbadobrzedodanych);
$output = json_encode(array($zleoznaczeni, $dobrzedodani));
echo $output;
?>