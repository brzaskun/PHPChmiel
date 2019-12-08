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
    require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/CertyfikatGenerowanie.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/UpowaznienieGenerowanie.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/UpowaznienieDWGenerowanie.php');
    $maile = array();
    $uzerywyslane = array();
    //inna sciezka, jest zaswiadczenie ale nie wyslano upowaznienia z jakiegosc powodu
    $ilemaili = 0;
    $parametr2 = "sessionend IS NOT NULL AND datanadania IS NOT NULL AND wyslanycert=1 AND wyslaneup=0";
    $sarekordybezupowaznienia = R::findAll("uczestnicy", $parametr2);
    echo "Ilosc niewyslanych upowaznien w bazie".sizeof($sarekordybezupowaznienia);
    echo "start upoważnienia";
    echo "<br />\n";
    foreach ($sarekordybezupowaznienia as $value) {
            $parameter = "id=".$value['id'];
//            echo "Zaczynam przetwarzanie".$value['imienazwisko'];
//            echo "<br />\n";
            $znaleziony_ucz = R::findOne('uczestnicy', $parameter);
            $_SESSION['uczestnik'] = $znaleziony_ucz->getProperties();
            $id = $_SESSION['uczestnik']['id'];
            $sagrupy = UpowaznienieGenerowanie::pobierzgrupy($id);
                if (strlen($sagrupy) > 0) {
                    if ($_SESSION['uczestnik']['email']=="brzaskun@gmail.com") {
                        $razdwa = true;
                    }
                    $wynik2 = true;
                    $sql = "UPDATE uczestnicy SET  wyslaneup = 1 WHERE id = '$id'";
                    $res = R::exec($sql);
                    if ($wynik2) {
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
    
?>

