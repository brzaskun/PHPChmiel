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
    session_destroy(); 
}
error_reporting(2);
$sciezkaroot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
require_once($sciezkaroot . '/resources/php/Rb.php');
require_once($sciezkaroot . '/resources/php/Zerowanieciastek.php');
date_default_timezone_set('Europe/Warsaw');
//inicjujemy clase do lazczenia sie z baza danych
R::setup('mysql:host=localhost;dbname=tb152026_testdane', 'tb152026_madrylo', 'Testdane7005*');
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
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v220817a" />
        <link rel="stylesheet" href="/resources/dataTableNew/media/css/jquery.dataTables.css?v220817a"/>
        <link rel="stylesheet" href="/resources/css/tablecss.css?v220817a"/>
        <link rel="stylesheet" href="/resources/css/main.css?v220817a"/>
        <link rel="stylesheet" href="/resources/css/details.css?v220817a"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v220817a"/>
        <link rel="stylesheet" href="/resources/primeui-4.1.12/primeui.min.css?v220817a"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/resources/css/images/ODOLogoVector.png?v220817a"/>
        <script src="/resources/js/jquery-1.12.3.js?v220817a"></script>
        <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v220817a"></script>
        <script src="/resources/js/jquery.form.js?v220817a"></script>
        <script src="/resources/dataTableNew/media/js/jquery.dataTables.js?v220817a"></script>
        <script src="/resources/contextmenu/jquery.contextMenu.js?v220817a"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v220817a"></script>
        <script src="/resources/js/main.js?v220817a"></script>
        <script src="/resources/js/globales.js?v220817a"></script>
        <script src="/resources/js/ciasteczka.js?v220817a"></script>
        <script src="/resources/primeui-4.1.12/primeui.min.js?v220817a"></script>
        <!--[if lt IE 9]>
                 <script src="https://html5shim.googlecode.com/svn/trunk/html5.js?v220817a"></script>
         <![endif]-->
        <title>Testy Dane Wrażliwe</title>
    </head>
    <body>
        <div class="box">
            <div class="slajd">
                <div id="loginnaglowek">
                    <h2>E-szkolenia: Ochrona Danych Osobowych, Systemy Zarządzania Jakością, Bezpieczeństwo Informacji</h2> 
                </div>
                <div id="logininfo">
                    <h2>Strona e-szkoleń została czasowo wyłączona. Trwają prace konserwacyjne do 15.01.2018</h2>
                    <h2>Przepraszamy za utrudnienia.</h2>
                </div>
                
                <div class="margin2" style="height: 10px; text-align: left;">
                    <span id="wiadomoscajax"></span>
                </div>
                
            </div>
        </div>
        <div id="notify"></div>
    </body> 
</html>