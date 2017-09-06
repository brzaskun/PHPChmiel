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
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v220817a" />
        <link rel="stylesheet" href="/resources/dataTableNew/media/css/jquery.dataTables.css?v220817a"/>
        <link rel="stylesheet" href="/resources/css/tablecss.css?v220817a"/>
        <link rel="stylesheet" href="/resources/css/main.css?v220817a"/>
        <link rel="stylesheet" href="/resources/css/details.css?v220817a"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v220817a"/>
        <script src="/resources/js/jquery-1.12.3.js?v220817a"></script>
        <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v220817a"></script>
        <script src="/resources/js/jquery.form.js?v220817a"></script>
        <script src="/resources/dataTableNew/media/js/jquery.dataTables.js?v220817a"></script>
        <script src="/resources/contextmenu/jquery.contextMenu.js?v220817a"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v220817a"></script>
        <script src="/resources/js/main.js?v220817a"></script>
        <script src="/resources/js/ciasteczka.js?v220817a"></script>
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
                    <span>Wystąpił bląd podczas generowania zaświadczenia.</span>
                    <span>Zaświadczenie i upoważnienie nie zostało wysłane.</span><br/>
                    <br/>
                    <span>Prosimy skontaktować się z osobą odpowiedzialną za szkolenia.</span><br/>
                    <p> W twojej firmie jest to: <?php error_reporting(0); echo $_SESSION['uczestnik']['kontakt'];?>.</p>
                </div>
            </form>
         </div>
        </div>
<?php error_reporting(0); 
if(session_status()!=2){     
   session_start(); };
   $_SESSION = array();
   session_destroy();
?>
    </body>
</html>
