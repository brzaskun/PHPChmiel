<?php
    session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');
    if (session_status() != 2) {
        session_start();
    };
   error_reporting(E_ALL & ~E_DEPRECATED);
    require_once('resources/php/Rb.php');
    if ($_SERVER["HTTP_HOST"] != "localhost:8000") {
        $_SESSION['host'] = 'mysql:host=172.16.0.6;';
    } else {
        $_SESSION['host'] = 'mysql:host=localhost;';
    }
    $_SESSION['danewrazliwe'] = "dane szczególnej kategorii";
    R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1'); 
    date_default_timezone_set('Europe/Warsaw');
    //chodzi o niewyslane zaswiadczenie
    require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/UpowaznienieDWGenerowanie.php');
    $ilemaili = 0;
    $maile = array();
    $uzerywyslane = array();
    $sql = "Select DISTINCT s.id FROM uczestnicy s LEFT OUTER JOIN uczestnikgrupy o ON o.id_uczestnik=s.id WHERE s.sessionend IS NOT NULL AND s.datanadania IS NOT NULL AND (s.dataustania IS NULL OR s.dataustania='') AND s.wyslanycert=1 AND s.wyslaneup=1 AND s.wyslaneupdanewrazliwe=0 AND o.grupa='dane szczególnej kategorii';";
    $sarekordybezupowaznieniaDW = R::getAll($sql);
    echo "Ilosc niewyslanych upowaznien DANE SZCZEGÓLNEJ KATEGORII w bazie".sizeof($sarekordybezupowaznieniaDW);
    echo "start dane szczególej kategorii";
    echo "<br />\n";
    foreach ($sarekordybezupowaznieniaDW as $value) {
            $parameter = "id=".$value['id'];
//            echo "Zaczynam przetwarzanie".$value['imienazwisko'];
//            echo "<br />\n";
            $znaleziony_ucz = R::findOne('uczestnicy', $parameter);
            $_SESSION['uczestnik'] = $znaleziony_ucz->getProperties();
            $id = $_SESSION['uczestnik']['id'];
            if ($id==16184) {
                echo "robie brzaskuna<br />\n";
            }
            $dataustania = $_SESSION['uczestnik']['dataustania'];
            if ($dataustania == null || $dataustania == "") {
                $sagrupy = UpowaznienieDWGenerowanie::pobierzgrupy($id);
                    if (strlen($sagrupy) > 0) {
                        $wynik3 = UpowaznienieDWGenerowanie::generuj();
                        if ($wynik3) {
                            $ilemaili = $ilemaili+1;
                            array_push($maile, $_SESSION['uczestnik']['email']);
                            echo $_SESSION['uczestnik']['imienazwisko'];
                            echo " ";
                            echo $_SESSION['uczestnik']['sessionend'];
                            echo " ";
                            echo $_SESSION['uczestnik']['email'];
                            echo "<br />\n";
                            array_push($uzerywyslane, $value);
                        }
                    }
            }
    }
    echo "<br />\n";
    if ($ilemaili > 0) {
        echo "Ilosc maili tylko upowaznienie wyslanych w sumie".$ilemaili;
        try {
            require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Mail.php');
        } catch (Exception $em) {
 
        }
        Mail::mailwyslanoawaryjnie($uzerywyslane);
        echo "<br />\n";
        echo "Wyslano mail dla admina";
    }
    echo "Koniec procedury";
    echo "<br />\n";
?>

