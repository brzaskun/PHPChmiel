<!DOCTYPE html>
<html lang="pl">
    <?php error_reporting(0);
    if(session_status()!=2){     session_start(); };
    ?>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
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
    $firmy = R::findAll("zakladpracy");
    $sql1  ="SELECT DISTINCT grupyupowaznien.firma FROM grupyupowaznien ORDER BY grupyupowaznien.firma ASC";
    $grupyupo = R::getAll($sql1);
    echo "start<br/>";
    foreach ($grupyupo as $fyrma) {
//        echo ($fyrma['firma']);
//        echo "<br/>";
        foreach ($firmy as $value2) {
            if ($value2['nazwazakladu']==$fyrma['firma']) {
                $ffirma = $fyrma['firma'];
                $id = $value2['id'];
                $sql2 = "UPDATE grupyupowaznien SET firma_id='$id' WHERE firma='$ffirma'";
                R::exec($sql2);
                echo ($ffirma);
                echo " - ";
                echo ($value2['nazwazakladu']);
                echo " - ";
                echo ($value2['id']);
                echo "<br/>";
                break;
            }
        }
        
    }
    echo "koniec";
    $sql1  ="SELECT DISTINCT uczestnicy.firma FROM uczestnicy ORDER BY uczestnicy.firma ASC";
    $grupyupo = R::getAll($sql1);
    echo "start<br/>";
    foreach ($grupyupo as $fyrma) {
//        echo ($fyrma['firma']);
//        echo "<br/>";
        foreach ($firmy as $value2) {
            if ($value2['nazwazakladu']==$fyrma['firma']) {
                $ffirma = $fyrma['firma'];
                $id = $value2['id'];
                $sql2 = "UPDATE uczestnicy SET firma_id='$id' WHERE firma='$ffirma'";
                R::exec($sql2);
                echo ($ffirma);
                echo " - ";
                echo ($value2['nazwazakladu']);
                echo " - ";
                echo ($value2['id']);
                echo "<br/>";
                break;
            }
        }
        
    }
    echo "koniec";
    $sql1  ="SELECT DISTINCT szkolenieust.firma FROM szkolenieust ORDER BY szkolenieust.firma ASC";
    $grupyupo = R::getAll($sql1);
    echo "start<br/>";
    foreach ($grupyupo as $fyrma) {
//        echo ($fyrma['firma']);
//        echo "<br/>";
        foreach ($firmy as $value2) {
            if ($value2['nazwazakladu']==$fyrma['firma']) {
                $ffirma = $fyrma['firma'];
                $id = $value2['id'];
                $sql2 = "UPDATE szkolenieust SET firma_id='$id' WHERE firma='$ffirma'";
                R::exec($sql2);
                echo ($ffirma);
                echo " - ";
                echo ($value2['nazwazakladu']);
                echo " - ";
                echo ($value2['id']);
                echo "<br/>";
                break;
            }
        }
        
    }
    echo "koniec";
?></body>
</html>