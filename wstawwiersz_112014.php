<?php error_reporting(0);
$slidenr = $_POST['slidenr'];
$nazwaszkolenia = $_POST['Nnazwaszkolenia'];
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
if ($_SERVER["HTTP_HOST"] != "localhost:8000") {
    $_SESSION['host'] = 'mysql:host=172.16.0.6;';
} else {
    $_SESSION['host'] = 'mysql:host=localhost;';
}
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$tabelaszkolen = R::getAll('SELECT * FROM szkolenie ORDER BY `id` DESC');
foreach ($tabelaszkolen as $kolejnyslide) {
    $wybraneszkolenienr = ($kolejnyslide['id']);
    if ($wybraneszkolenienr>$slidenr) {
        $nr = $wybraneszkolenienr + 1;
        $p2 = $kolejnyslide['nazwaszkolenia'];
        $p3 = $kolejnyslide['naglowek'];
        $p4 = $kolejnyslide['temat'];
        $p5 = $kolejnyslide['tresc'];
        $sql = "DELETE FROM `szkolenie` WHERE `id`=$wybraneszkolenienr";
        R::exec($sql);
        $sql = "INSERT INTO  `szkolenie` (`id` ,`nazwaszkolenia` ,`naglowek` ,`temat`,`tresc`) VALUES ('$nr', '$p2', '$p3', '$p4', '$p5');";
        R::exec($sql);
    } else if  ($wybraneszkolenienr===$slidenr){
        try {
            $nr = $wybraneszkolenienr + 1;
            $p3 = "proszę wypełnić";
            $p4 = "";
            $p5 = "";
            $sql = "INSERT INTO  `szkolenie` (`id` ,`nazwaszkolenia` ,`naglowek` ,`temat`,`tresc`) VALUES ('$nr', '$nazwaszkolenia', '$p3', '$p4', '$p5');";
            echo R::exec($sql);
        } catch (Exception $e) {
            $d = $e;
        }
        break; 
    }
}
?>
    