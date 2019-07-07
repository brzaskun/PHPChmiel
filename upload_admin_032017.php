<?php error_reporting(0);
if (session_status()!=2) {
    session_start();
}; 
set_time_limit(0);
ini_set('memory_limit','256M');
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Mail.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/SprawdzWprowadzanyWiersz.php'); 
$firmabaza = urldecode($_COOKIE['firmadoimportu']);
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/FirmaNazwaToId.php');
$firma_id = FirmaNazwaToId::wyszukaj($firmabaza);
$dataszkolenia = $_COOKIE['dataszkolenia'];
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$tablicapobranychpracownikow = $_SESSION['tablicapobranychpracownikow'];
$nazwygrup = array();
$czasbiezacy = date("Y-m-d H:i:s");
$dataszkoleniastamp = date($dataszkolenia);
$pierwszywiersz = array_shift($tablicapobranychpracownikow);
$dl = count((array)$pierwszywiersz);
$start = $dl-6;
$listadodanychgrup = array();
$listagrupniedodanych = array();
$bledydodawanieuzytkownikow = array();
$niewyslanymail = array();
$zleoznaczeni = array();
$dobrzedodani = array();
if ($start > 0) {
    for ($i = 6; $i < $dl; $i++) {
        try {
           $nazwygrup[$pierwszywiersz[$i]] = $i;
            $sql = "INSERT INTO `grupyupowaznien` (`firma` ,`firma_id` ,`nazwagrupy`) VALUES ('$firmabaza', '$firma_id',  '$pierwszywiersz[$i]');";
            R::exec($sql);
            array_push($listadodanychgrup,$pierwszywiersz[$i]);
        } catch (Exception $e){
            array_push($listagrupniedodanych,$pierwszywiersz[$i]);
        }
    }
}
$liczbadobrzedodanych = 0;
$czytomabycstacjonarne = $_SESSION["stac"];
if (isset($czytomabycstacjonarne) == true && isset($dataszkolenia) == false) {
    return;
}
$datanadania = "";
if (isset($dataszkolenia) && strlen($dataszkolenia) == "10") {
    $datanadania = explode("-", $dataszkolenia);
    $datanadania = $datanadania[2] . "." . $datanadania[1] . "." . $datanadania[0];
}
foreach ($tablicapobranychpracownikow as $wierszbaza) {
    try {
        if (isset($dataszkolenia) && strlen($dataszkolenia) == "10") {
            $imienazwisko = addslashes($wierszbaza[1]);
            $sql = "INSERT INTO  `uczestnicy` (`email` ,`imienazwisko` ,`plec` ,`firma` ,`firma_id` , `nazwaszkolenia`, `uprawnienia` ,`wyslanymailupr` ,`sessionstart` ,
            `sessionend` ,`wyniktestu` ,`wyslanycert`,`indetyfikator`, `nrupowaznienia`, `utworzony`,`stacjonarny`,`datanadania`)
            VALUES ('$wierszbaza[0]',  '$imienazwisko', '$wierszbaza[2]', '$firmabaza', '$firma_id', '$wierszbaza[3]', 'uzytkownik' , 1, '$dataszkoleniastamp' , '$dataszkoleniastamp', 101 , 0, '$wierszbaza[4]', '$wierszbaza[5]', '$czasbiezacy',1, '$datanadania');";
        } else {
            $imienazwisko = addslashes($wierszbaza[1]);
            $sql = "INSERT INTO  `uczestnicy` (`email` ,`imienazwisko` ,`plec` ,`firma` ,`firma_id` , `nazwaszkolenia`, `uprawnienia` ,`wyslanymailupr` ,`sessionstart` ,
            `sessionend` ,`wyniktestu` ,`wyslanycert`,`indetyfikator`, `nrupowaznienia`, `utworzony`,`stacjonarny`)
            VALUES ('$wierszbaza[0]',  '$imienazwisko', '$wierszbaza[2]', '$firmabaza', '$firma_id', '$wierszbaza[3]', 'uzytkownik' , 0, NULL , NULL , 0 , 0, '$wierszbaza[4]', '$wierszbaza[5]', '$czasbiezacy',0);";
        }
        R::exec($sql);
        $id_uzytkownik = R::getInsertID();
        if ($id_uzytkownik > 0) {
            //$wynik = Mail::mailautomat($wierszbaza[1], $wierszbaza[2], $wierszbaza[0], $wierszbaza[3], $id_uzytkownik);
            if (strpos($wynik, "@") !== false) {
                array_push($niewyslanymail, $wynik);
            }
            foreach ($nazwygrup as $key => $value) {
                $wartoscpola = $wierszbaza[$value];
                if ($wartoscpola == 1) {
                    try {
                        $sql = "INSERT INTO uczestnikgrupy (email,nazwiskoiimie,grupa,id_uczestnik) VALUES ('$wierszbaza[0]','$imienazwisko','$key', '$id_uzytkownik');";
                        R::exec($sql);
                    } catch (Exception $e) {
                        array_push($zleoznaczeni, $wierszbaza[0]);
                    }
                } else {
                    try {
                        $sql = "DELETE FROM uczestnikgrupy WHERE grupa='$key' AND id_uczestnik='$id_uzytkownik'";
                        R::exec($sql);
                    } catch (Exception $e) {
                        array_push($zleoznaczeni, $wierszbaza[0]);
                    }
                }
            }
            $liczbadobrzedodanych++;
        }
    } catch (Exception $e) {
        array_push($bledydodawanieuzytkownikow, $wierszbaza[1]);
        array_push($niewyslanymail, $wierszbaza[0]);
    }
}
array_push($dobrzedodani, $liczbadobrzedodanych);
$output = json_encode(array($listadodanychgrup,$listagrupniedodanych,$bledydodawanieuzytkownikow,$niewyslanymail, $zleoznaczeni, $dobrzedodani));
if (isset($_COOKIE['dataszkolenia'])) {
    unset($_COOKIE['dataszkolenia']);
    setcookie('dataszkolenia', '', time() - 3600, '/'); // empty value and old timestamp
}
echo $output;
?>