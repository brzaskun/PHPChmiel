<!DOCTYPE html>
<html lang="pl">
<?php 
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');
error_reporting(0);
if(session_status()!=2){     session_start(); };
$_SESSION['szkolenietrwa'] = "nie";
$_SESSION['testrozpoczety']= "nie";
?>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v190529" />
        <link rel="stylesheet" href="/resources/dataTableNew/media/css/jquery.dataTables.css?v190529"/>
        <link rel="stylesheet" href="/resources/css/tablecss.css?v190529"/>
        <link rel="stylesheet" href="/resources/css/main.css?v190529"/>
        <link rel="stylesheet" href="/resources/css/details.css?v190529"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v190529"/>
        <script src="/resources/js/jquery-1.12.3.js?v190529"></script>
        <script src="/resources/js/jquery.form.js?v190529"></script>
        <script src="/resources/dataTableNew/media/js/jquery.dataTables.js?v190529"></script>
        <script src="/resources/contextmenu/jquery.contextMenu.js?v190529"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v190529"></script>
        <script src="/resources/primeui-4.1.12/primeui.min.js?v190529"></script>
        <script src="/resources/js/main.js?v190529"></script>
        <script src="/resources/js/ciasteczka.js?v190529"></script>
        <title>Testy Dane Wrażliwe</title>
       </head>
    <body>
      
        <div class="box">
             
            <div class="slajd">
            <div id="testnaglowek">
                    <h2>Usługa e-szkoleń dla twojej firmy jest juz nieaktywna.</h2>
                </div>
                <div class="trescszkolenia"> 
                    <p>
                      :(   
                    </p>
                </div>
    </body>
</html>