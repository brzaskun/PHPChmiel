<?php
error_reporting(E_ALL & ~E_DEPRECATED);
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
if(session_status()!=2){    
    session_start(); 
};
$zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
if (isset($_POST['zakonczszkolenie'])) {
    $_SESSION['testrozpoczety'] = "tak";
    $url = "test.php?$zm";
    header("Location: $url");
    exit();
}
require_once("resources/php/NextslideSzkolenie.php");
if (isset($_POST['nextszkolenie'])) {
    NextslideSzkolenie::next();
} else if (isset($_POST['backszkolenie'])) {
    NextslideSzkolenie::back();
} else {
    NextslideSzkolenie::init();
}
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/PL_EN.php');
$lang = PL_EN::wybierzjezyk($_SESSION['uczestnik']['nazwaszkolenia']);
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v190707" />
        <link rel="stylesheet" href="/resources/dataTableNew/media/css/jquery.dataTables.css?v190707"/>
        <link rel="stylesheet" href="/resources/css/tablecss.css?v190707"/>
        <link rel="stylesheet" href="/resources/css/main.css?v190707"/>
        <link rel="stylesheet" href="/resources/css/details.css?v190707"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v190707"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/resources/css/images/ODOLogoVector.png"/>
        <script src="/resources/js/jquery-1.12.3.js?v190707"></script>
        <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v190707"></script>
        <script src="/resources/js/jquery.form.js?v190707"></script>
        <script src="/resources/dataTableNew/media/js/jquery.dataTables.js?v190707"></script>
        <script src="/resources/contextmenu/jquery.contextMenu.js?v190707"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v190707"></script>
        <script src="/resources/js/main.js?v190707"></script>
        <script src="/resources/js/ciasteczka.js?v190707"></script>
        <!--[if lt IE 9]>
		<script src="https://html5shim.googlecode.com/svn/trunk/html5.js?v190707"></script>
	<![endif]-->
        <title>Testy Dane Wrażliwe</title>

    </head>
    <body>



<div class="box">
        <div class="slajd">
    <?php 
    if(session_status()!=2){     session_start(); };
//    
    if (!isset($_SESSION['szkolenietrwa'])) {
        die("<div id='gornawklejka'><span>prosimy nie używać przycisku powrotu w przeglądarce!</span>
            </div><div id='szkolenienaglowek'><h2>Rozpoczęto już test, nie można wrócić do szkolenia</h2></div>
            <div style='width: 700px; height: 40px; padding: 10px; margin-left: auto; margin-right: auto; font-size: larger;'>
                    <form id='form' action='' method='post' >
                    <button id='zalogujponownie' name='zalogujponownie' class='buttonszkolenie' type='submit' formaction='index.php' style='float: left;' title='Powrót do strony logowania'><span class='spanszkolenie'>login</span></button>
                    </form>
            </div></div></body></html>
            ");
    }
    if ($_SESSION['szkolenietrwa'] != "tak") {
        $_SESSION['testrozpoczety'] = "nie";
        die("<div id='gornawklejka'><span>prosimy nie używać przycisku powrotu w przeglądarce!</span>
            </div><div id='szkolenienaglowek'><h2>Rozpoczęto już test, nie można wrócić do szkolenia</h2></div>
            <div style='width: 700px; height: 40px; padding: 10px; margin-left: auto; margin-right: auto; font-size: larger;'>
                    <form id='form' action='' method='post' >
                    <button id='zalogujponownie' name='zalogujponownie' class='buttonszkolenie' type='submit' formaction='index.php' style='float: left;' title='Powrót do strony logowania'><span class='spanszkolenie'>login</span></button>
                    </form>
            </div></div></body></html>
            ");
    }
    ?>
            <form id="form" action="" method="post">
            <div id="gornawklejka">
                <span style="font-size: larger;"><?php  echo NextslideSzkolenie::$opisszkolenia; ?></span> 
            </div>
            <div id="szkolenienaglowek">
                <h2><?php  echo NextslideSzkolenie::$szkolenie[NextslideSzkolenie::$ilosc]['naglowek']; ?></h2>
            </div>
            
                <div class="trescszkolenia" style="margin-top: 10px;">
                    <span><?php  echo NextslideSzkolenie::$szkolenie[NextslideSzkolenie::$ilosc]['tresc']; ?></span>
                </div>
                <div class="zakonczylesszkolenie">
                    <span id="koniecszkolenia" style="display: none; "><?= PL_EN::$koniec_szkolenia[$lang]?></span>
                </div>
                <div class="dolneprzyciski" >
                    <button id="backszkolenie" name="backszkolenie" class="buttonszkolenie"  type="submit" title="Powrót do poprzedniej strony szkolenia"><span class="spanszkolenie"><?= PL_EN::$powrot[$lang]?></span></button>
                    <button id="nextszkolenie" name="nextszkolenie" class="buttonszkolenie" type="submit" style="float: right;" title="Przejście do kolejnej strony szkolenia"><span class="spanszkolenie"><?= PL_EN::$dalej[$lang]?></span></button>
                    <button id="zakonczszkolenie" name="zakonczszkolenie" class ="buttonszkolenie" type="submit" style="float: right;" title="Definitywne zakończenie szkolenia i rozpoczęcie testu"><span class="spanszkolenie"><?= PL_EN::$test[$lang]?></span></button>
                </div>
                <script>
                    (function() {
                        var nrkolejny = <?php  echo $_SESSION['ilosc'] + 1 ?>;
                        var max = <?php  echo $_SESSION['szkoleniesize'] ?>;
                        if (nrkolejny < max) {
                            $('#nextszkolenie').show();
                        }
                        if (nrkolejny > 1) {
                            $('#backszkolenie').show();
                        } else {
                            $('#backszkolenie').hide();
                        }
                        if (nrkolejny === max) {
                            $('#zakonczszkolenie').show();
                            $('#nextszkolenie').hide();
                            $('#koniecszkolenia').show();
                        } else {
                            $('#nextszkolenie').show();
                            $('#zakonczszkolenie').hide();
                            $('#koniecszkolenia').hide();
                        }
                    }());
                </script>
            </form>
        </div>
</div>
    </body>
</html>
