<?php
    session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');
    if (session_status() != 2) {
        session_start();
    };
    error_reporting(E_ALL & ~E_DEPRECATED);
    require_once('resources/php/Rb.php');
    R::setup('mysql:host=localhost;dbname=tb152026_testdane', 'tb152026_madrylo', 'Testdane7005*');
    date_default_timezone_set('Europe/Warsaw');
    //chodzi o niewyslane zaswiadczenie
    $parametr = "sessionend IS NOT NULL AND wyslanycert=0";
    $jestwbazie = R::findAll("uczestnicy", $parametr);
    echo "Ilosc niewyslanych zaswiadczen w bazie".sizeof($jestwbazie);
    echo "<br />\n";
    require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/CertyfikatGenerowanie.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/UpowaznienieGenerowanie.php');
    $ilemaili = 0;
    $maile = array();
    $uzerywyslane = array();
    foreach ($jestwbazie as $value) {
        if (strtotime($value['sessionend']) > strtotime("2017-10-01")) {
            $parameter = "id=".$value['id'];
//            echo "Zaczynam przetwarzanie".$value['imienazwisko'];
//            echo "<br />\n";
            $znaleziony_ucz = R::findOne('uczestnicy', $parameter);
            $_SESSION['uczestnik'] = $znaleziony_ucz->getProperties();
            $wynik1 = CertyfikatGenerowanie::generuj();
            $wynik2 = UpowaznienieGenerowanie::generuj();
            if ($wynik1 || $wynik2) {
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
        echo "Ilosc maili wyslanych w sumie".$ilemaili;
        try {
            require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Mail.php');
        } catch (Exception $em) {
 
        }
        Mail::mailwyslanoawaryjnie($uzerywyslane);
        echo "<br />\n";
        echo "Wyslano mail dla admina";
    }
?>

