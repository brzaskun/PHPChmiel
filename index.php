<?php
//force the page to use ssl 
//if ($_SERVER["HTTP_HOST"] != "localhost:8000" && $_SERVER["SERVER_PORT"] != 443) {
//    $redir = "Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
//    header($redir);
//    exit();
//}
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');
if (session_status() == 2) {
    session_start(); 
    ini_set('session.gc_probability', 1);
    $_SESSION = array();
    session_destroy();//kk
}
error_reporting(E_ALL);
$sciezkaroot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
require_once($sciezkaroot . '/resources/php/Rb.php');
require_once($sciezkaroot . '/resources/php/Zerowanieciastek.php');
date_default_timezone_set('Europe/Warsaw');
//inicjujemy clase do lazczenia sie z baza danych
R::setup('mysql:host=172.16.0.6;dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
//Zerowanieciastek::usunciastka(); 
if (isset($_GET['mail'])) {
    $mail = filter_input(INPUT_GET, 'mail', FILTER_VALIDATE_EMAIL);
    session_start();
    $_SESSION = array();
    $_SESSION['automail'] = $mail;
    $url = 'sprawdzlogin_1.php';
    header("Location: $url"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v180118" />
        <link rel="stylesheet" href="/resources/dataTableNew/media/css/jquery.dataTables.css?v180118"/>
        <link rel="stylesheet" href="/resources/css/tablecss.css?v180118"/>
        <link rel="stylesheet" href="/resources/css/main.css?v180118"/>
        <link rel="stylesheet" href="/resources/css/details.css?v180118"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v180118"/>
        <link rel="stylesheet" href="/resources/primeui-4.1.12/primeui.min.css?v180118"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/resources/css/images/ODOLogoVector.png?v180118"/>
        <script src="/resources/js/jquery-1.12.3.js?v180118"></script>
        <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v180118"></script>
        <script src="/resources/js/jquery.form.js?v180118"></script>
        <script src="/resources/dataTableNew/media/js/jquery.dataTables.js?v180118"></script>
        <script src="/resources/contextmenu/jquery.contextMenu.js?v180118"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v180118"></script>
        <script src="/resources/js/main.js?v180118"></script>
        <script src="/resources/js/globales.js?v180118"></script>
        <script src="/resources/js/ciasteczka.js?v180118"></script>
        <script src="/resources/primeui-4.1.12/primeui.min.js?v180118"></script>
        <!--[if lt IE 9]>
                 <script src="https://html5shim.googlecode.com/svn/trunk/html5.js?v180118"></script>
         <![endif]-->
        <title>Testy Dane Wrażliwe</title>
        <script>
            MYAPP = {};
            $(document).ready(function () {
                $("#email").keyup(function () {
                    validate();
                })
                $('#email').focus();
            });
            $(document).ajaxStart(function () {
                $("#wiadomoscajax").text("Trwa logowanie");
            });
            $(document).ajaxStop(function () {
                $("#wiadomoscajax").text("Skończono logowanie. Trwa weryfikacja danych");
            });
        </script>
    </head>
    <body>
        <div class="box">
            <div class="slajd">
                <div id="loginnaglowek">
                    <h2>E-szkolenia: Ochrona Danych Osobowych, Systemy Zarządzania Jakością, Bezpieczeństwo Informacji</h2> 
                </div>
                <div id="logininfo">
                    <h2>W celu zalogowania wpisz swój email</h2>
                </div>
                <form id="loginform" >
                    <input type="text" id="email" name="mail" value="" style="color: rgb(74,26,15); padding-left: 10px;"  autocomplete="off"
                           title="Wpisz nazwę adresu email, na który został wysłana informacja o szkoleniu"><br/>
                    <div id="polepin" style="display: none; margin-left: 24.5%;" >
                        <label for="pin">podaj pin</label>
                        <input id="pin" name="pin" type="text" onkeyup="sprawdzpin();" style="color: rgb(74,26,15);" />
                    </div>
                    <br/>
                    <div class="margin1" style="height: 20px; margin-top: 1%;">
                        <span id="result" style="font-size: 80%;"></span>
                    </div> 
                    <button id="buttonlogowanie" type="submit"  title="Kliknij celem rozpoczęcia szkolenia" 
                            formaction="sprawdzlogin_1.php" formmethod="POST">
                        <span class="spanszkolenie" >zaloguj</span></button>
                </form>
                <div class="margin2" style="height: 10px; text-align: left;">
                    <span id="wiadomoscajax"></span>
                </div>
                <div class="margin1" style="margin-top: 5%; text-align: left;">
                    <span>Szkolenie rozpoczyna się pod warunkiem wpisania właściwego adresu email</span>
                </div>
            </div>
        </div>
        <div id="notify"></div>
    </body> 
</html>