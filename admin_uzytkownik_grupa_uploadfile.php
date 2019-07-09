<!DOCTYPE html>
<html lang="pl">
    <?php error_reporting(0);
    session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');   if(session_status()!=2){     session_start(); };
    if ($_SESSION['uczestnik']['uprawnienia'] != "admin") {
        die("Nie jesteś upoważniony do przeglądania zasobu");
    }
    ?>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v190707" />
        <link rel="stylesheet" href="/resources/dataTableNew/media/css/jquery.dataTables.css?v190707"/>
        <link rel="stylesheet" href="/resources/css/tablecss.css?v190707"/>
        <link rel="stylesheet" href="/resources/css/main.css?v190707"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v190707"/>
        <link rel="stylesheet" href="/resources/primeui-4.1.12/primeui.min.css?v190707"/>
        <link rel="stylesheet" href="/resources/primeui-4.1.12/themes/bootstrap/theme.css?v190707"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/resources/css/images/ODOLogoVector.png"/>
        <script src="/resources/js/jquery-1.12.3.js?v190707"></script>
        <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v190707"></script>
        <script src="/resources/js/jquery.form.js?v190707"></script>
        <script src="/resources/contextmenu/jquery.contextMenu.js?v190707"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v190707"></script>
        <script src="/resources/dataTableNew/media/js/jquery.dataTables.js?v190707"></script>
        <script src="/resources/js/globales.js?v190707"></script>
        <script src="/resources/js/fileupload.js?v190707"></script>
        <script src="/resources/js/admin_uzytkownik_grupa_uploadfile.js?v190707"></script>
<!--        <script src="/resources/js/main.js?v190707"></script>
        <script src="/resources/js/potwierdzenia.js?v190707"></script-->
        <script src="/resources/js/ciasteczka.js?v190707"></script>
        <script src="/resources/ckeditor/ckeditor.js?v190707"></script>
        <script src="/resources/primeui-4.1.12/primeui.min.js?v190707"></script>
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
        <?php
            include_once './admin_uzytkownik_grupa_plik.php'; 
        ?>
    </body>
</html>
