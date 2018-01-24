<?php error_reporting(2);
if(session_status()!=2){     session_start(); };
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$slide = R::getAll("SELECT * FROM `szkoleniepodglad`");
$slidedopokazania = $slide[0];
$opis = $_GET['opis'];
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v180118" />
        <link rel="stylesheet" href="/resources/dataTableNew/media/css/jquery.dataTables.css?v180118"/>
        <link rel="stylesheet" href="/resources/css/tablecss.css?v180118"/>
        <link rel="stylesheet" href="/resources/css/main.css?v180118"/>
        <link rel="stylesheet" href="/resources/css/details.css?v180118"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v180118"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/resources/css/images/ODOLogoVector.png"/>
        <script src="/resources/js/jquery-1.12.3.js?v180118"></script>
        <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v180118"></script>
        <script src="/resources/js/jquery.form.js?v180118"></script>
        <script src="/resources/dataTableNew/media/js/jquery.dataTables.js?v180118"></script>
        <script src="/resources/contextmenu/jquery.contextMenu.js?v180118"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v180118"></script>
        <script src="/resources/js/main.js?v180118"></script>
        <script src="/resources/js/ciasteczka.js?v180118"></script>
        <title>Testy Dane Wrażliwe</title>

    </head>
    <body>

<div class="box">
        <div class="slajd">
    <?php 
    if(session_status()!=2){     session_start(); };
    ?>
            <div id="gornawklejka">
                <span><?php  echo $opis; ?></span>
            </div>
            <div id="szkolenienaglowek">
                <h2><?php  echo $slidedopokazania['naglowek']; ?></h2>
            </div>
            <form id="form" action="" method="post" >
                <div class="trescszkolenia" style="margin-top: 10px;">
                    <span><?php  echo $slidedopokazania['tresc']; ?></span>
                </div>
                <div class="zakonczylesszkolenie">
                    <span id="koniecszkolenia" style="display: none; ">Zakończyłeś szkolenie. Możesz rozpocząć test. W tym celu kliknij poniżej.</span>
                </div>
                <div class="dolneprzyciski" >
                    <button id="backszkolenie" name="backszkolenie" class="buttonszkolenie"  type="button" title="Powrót do poprzedniej strony szkolenia"><span class="spanszkolenie">wróć</span></button>
                    <button id="nextszkolenie" name="nextszkolenie" class="buttonszkolenie" type="button" style="float: right;" title="Przejście do kolejnej strony szkolenia"><span class="spanszkolenie">dalej</span></button>
                    <button id="zakonczszkolenie" name="zakonczszkolenie" class ="buttonszkolenie" type="button" style="float: right;" title="Definitywne zakończenie szkolenia i rozpoczęcie testu"><span class="spanszkolenie">test</span></button>
                </div>
         
            </form>
        </div>
</div>
    </body>
</html>
