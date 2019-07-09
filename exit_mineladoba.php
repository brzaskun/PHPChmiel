<?php
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
if (session_status() != 2) {
    session_start();
}
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
        <script src="/resources/js/jquery-1.12.3.js?v190707"></script>
        <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v190707"></script>
        <script src="/resources/js/jquery.form.js?v190707"></script>
        <script src="/resources/dataTableNew/media/js/jquery.dataTables.js?v190707"></script>
        <script src="/resources/contextmenu/jquery.contextMenu.js?v190707"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v190707"></script>
        <script src="/resources/js/main.js?v190707"></script>
        <script src="/resources/js/ciasteczka.js?v190707"></script>
        <title>Testy Dane Wrażliwe</title>
    </head>

    <body>
        <div class="box">
         <div class="slajd">
            <div id="gornawklejka">
                <span>Szkolenie z zakresu ochrony danych osobowych</span>
            </div>
            <div id="szkolenienaglowek">
                <h2></h2>
            </div>
            <form id="form" action="" method="post" >
                <div class="odpowiedzitest">
                    <span>Zgodnie z regulaminem szkoleń do serwisu można logować się w ciągu 24 godzin od czasu pierwszego zalogowania.</span><br/><br/>
                    <span>Pierwsze zalogowanie z użyciem adresu <?php error_reporting(0); session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');   if(session_status()!=2){     session_start(); }; echo $_SESSION['uczestnik']['email'];?> miało miejsce
                        <?php error_reporting(0);  echo $_SESSION['uczestnik']['sessionstart'];?></span><br/><br/>
                    <span>Jeżeli pierwsze zalogowanie nastąpiło omyłkowo prosimy, w celu reaktywacji konta, skontaktować się z osobą odpowiedzialną za szkolenia.</span><br/>
                    <p> W twojej firmie jest to: <?php error_reporting(0); echo $_SESSION['uczestnik']['kontakt'];?>.</p>
                </div>
            </form>
         </div>
        </div>
    </body>
</html>
