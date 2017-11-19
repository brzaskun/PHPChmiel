<?php
    session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');
    if (session_status() != 2) {
        session_start();
    };
    error_reporting(E_ALL & ~E_DEPRECATED);
    try {
        require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Mail.php');
    } catch (Exception $em) {
 
    }
    require_once('resources/php/Rb.php');
    R::setup('mysql:host=localhost;dbname=tb152026_testdane', 'tb152026_madrylo', 'Testdane7005*');
    date_default_timezone_set('Europe/Warsaw');
    $parametr = "wyslanymailupr=0 AND id > 16180";
    $jestwbazie = R::findAll("uczestnicy", $parametr);
    echo sizeof($jestwbazie);
    echo "<br />\n";
    $ilemaili = 0;
    $uzery = array();
    $uzeryniewyslane = array();
    foreach ($jestwbazie as $value) {
        $parameter = "id=".$value['id'];
        $znaleziony_ucz = R::findOne('uczestnicy', $parameter);
        $ws = $value->getProperties();
        $wynik = Mail::mailautomat($ws['imienazwisko'], $ws['plec'], $ws['email'], $ws['nazwaszkolenia'], $ws['id']);
        if (strpos($wynik, "@") !== false) {
            array_push($uzeryniewyslane, $ws);
        }
        $ilemaili = $ilemaili+1;
        array_push($uzery, $ws);
    }
    if ($ilemaili > 0) {
        Mail::mailwyslanolinki($uzery,$uzeryniewyslane);
    }
?>

