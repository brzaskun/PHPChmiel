<?php
    session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');
    if (session_status() != 2) {
        session_start();
    };
    error_reporting(E_ALL & ~E_DEPRECATED);
    require_once('resources/php/Rb.php');
    R::setup('mysql:host=localhost;dbname=tb152026_testdane', 'tb152026_madrylo', 'Testdane7005*');
    date_default_timezone_set('Europe/Warsaw');
    $parametr = "sessionend IS NOT NULL AND wyslanycert=0 AND id > 13230";
    $jestwbazie = R::findAll("uczestnicy", $parametr);
    echo sizeof($jestwbazie);
    echo "<br />\n";
    require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/CertyfikatGenerowanie.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/UpowaznienieGenerowanie.php');
    $ilemaili = 0;
    $maile = array();
    foreach ($jestwbazie as $value) {
        $parameter = "id=".$value['id'];
        $znaleziony_ucz = R::findOne('uczestnicy', $parameter);
        $_SESSION['uczestnik'] = $znaleziony_ucz->getProperties();
        CertyfikatGenerowanie::generuj();
        UpowaznienieGenerowanie::generuj();
        $ilemaili = $ilemaili+1;
        array_push($maile, $_SESSION['uczestnik']['email']);
        echo $_SESSION['uczestnik']['imienazwisko'];
        echo " ";
        echo $_SESSION['uczestnik']['sessionend'];
        echo "<br />\n";
    }
    if ($ilemaili > 0) {
        try {
            require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Mail.php');
        } catch (Exception $em) {
 
        }
        Mail::mailwyslanoawaryjnie($maile);
    }
?>

