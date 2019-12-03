<!DOCTYPE html>
<html lang="pl">
    <?php error_reporting(0);
    session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
    if(session_status()!=2){     
        session_start(); 
    };
    $_SESSION['stac'] = "inline";
    if ($_SESSION['uczestnik']['uprawnienia'] != "admin") {
        die("Nie jesteś upoważniony do przeglądania zasobu");
    }
    ?>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v190707" />
        <link rel="stylesheet" href="/resources/dataTableNew/media/css/jquery.dataTables.css?v190707"/>
         <link href="resources/dataTableNew/extensions/KeyTable/css/keyTable.dataTables.css?v190707" rel="stylesheet" type="text/css"/>
        <link href="resources/dataTableNew/extensions/Select/css/select.dataTables.css?v190707" rel="stylesheet" type="text/css"/>
        <link href="resources/dataTableNew/extensions/Buttons/css/buttons.dataTables.css?v190707" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="/resources/css/tablecss.css?v190707"/>
        <link rel="stylesheet" href="/resources/css/main.css?v190707"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v190707"/>
        <link rel="stylesheet" href="/resources/primeui-4.1.12/primeui.min.css?v190707"/>
        <link href="resources/font-awesome/css/font-awesome.min.css?v190707" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="/resources/primeui-4.1.12/themes/bootstrap/theme.css?v190707"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/resources/css/images/ODOLogoVector.png"/>
        <script src="/resources/js/jquery-1.12.3.js?v190707"></script>
        <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v190707"></script>
        <script src="/resources/js/jquery.form.js?v190707"></script>
        <script src="/resources/contextmenu/jquery.contextMenu.js?v190707"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v190707"></script>
        <script src="/resources/dataTableNew/media/js/jquery.dataTables.js?v190707"></script>
        <script src="resources/dataTableNew/extensions/KeyTable/js/dataTables.keyTable.js?v190707" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Select/js/dataTables.select.js?v190707" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Buttons/js/dataTables.buttons.js?v190707" type="text/javascript"></script>
        <script src="resources/jszip.min/jszip.min.js?v190707" type="text/javascript"></script>
        <script src="resources/PDFMAKE_files/pdfmake.min.js?v190707" type="text/javascript"></script>
        <script src="resources/PDFMAKE_files/vfs_fonts.js?v190707" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Buttons/js/buttons.html5.min.js?v190707" type="text/javascript"></script>
        <script src="/resources/js/globales.js?v190707"></script>
        <script src="/resources/js/fileupload.js?v190707"></script>
<!--        <script src="/resources/js/main.js?v190707"></script>
        <script src="/resources/js/potwierdzenia.js?v190707"></script-->
        <script src="/resources/js/ciasteczka.js?v190707"></script>
        <script src="/resources/js/admin112014_uploadfile.js?v190707"></script>
        <script src="/resources/ckeditor/ckeditor.js?v190707"></script>
        <script src="/resources/primeui-4.1.12/primeui.min.js?v190707"></script>
        <script src="resources/js/common_generowanietabeli.js?v190707" type="text/javascript"></script>
        <script src="/resources/js/upload_admin_032017.js?v190707"></script>
        <title>Testy Dane Wrażliwe</title>
        <script>
              $(document).ready(function() {
                $('#notify').puigrowl({
                    life: 6000
                });
            });
        </script>
    </head> 
    <body>
         <?php
            include_once './menu_upload_file.php';
        ?>
        <div id="notify"></div>
        <div id="panelinfo2" style="box-shadow: 10px 10px 5px #888; padding: 20px;  margin-top: 10px; background-color: #e9e9e9;">
            <span style="font-weight: bold">moduł wczytywania szkoleń stacjonarnych z pliku - konieczne jest podanie daty szkolenia</span>
        </div>
        <div style="display: inline" >
            <form>
                <script>
                    $().ready(function() {
                       $('#przyciskladowanie').hide();
                    });
                </script>
                <div style="box-shadow: 10px 10px 5px #888; padding: 20px;  margin-top: 10px; background-color: #e9e9e9;">
                    <span>data szkolenia stacjonarnego</span>
                    <input id="dataszkolenia" name="dataszkolenia" 
                           value="<?php
                           $dataszkolenia = $_COOKIE['dataszkolenia'];
                           if (strlen($dataszkolenia)==10) {
                               echo $dataszkolenia;
                           }
                           ?>"
                           type="text" onchange="dataszkoleniazachowaj()" maxlength="10" placeholder="rrrr-mm-dd" style="width: 80px;"/>
                </div>
            </form>
        </div>
        <?php
            include_once './admin_plik_112014.php';
        ?>
    </body>
</html>