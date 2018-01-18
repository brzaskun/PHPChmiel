<?php
    if (session_status() != 2) {
        session_start();
    };
    error_reporting(0);
    if ($_SESSION['uczestnik']['uprawnienia'] != "admin") {
        die("Nie jesteś upoważniony do przeglądania zasobu");
    }
?>
<!DOCTYPE html>
<html lang="pl">
    <meta charset="utf-8">
    <head>
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v180118" />
        <link rel="stylesheet" href="/resources/dataTableNew/media/css/jquery.dataTables.css?v180118"/>
        <link href="resources/dataTableNew/extensions/KeyTable/css/keyTable.dataTables.css?v180118" rel="stylesheet" type="text/css"/>
        <link href="resources/dataTableNew/extensions/Select/css/select.dataTables.css?v180118" rel="stylesheet" type="text/css"/>
        <link href="resources/dataTableNew/extensions/Buttons/css/buttons.dataTables.css?v180118" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="resources/css/tablecss.css?v180118"/>
        <link rel="stylesheet" href="/resources/css/main.css?v180118"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v180118"/>
        <link rel="stylesheet" href="/resources/primeui-4.1.12/primeui.min.css?v180118"/>
        <link href="resources/font-awesome/css/font-awesome.min.css?v180118" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="/resources/primeui-4.1.12/themes/bootstrap/theme.css?v180118"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/resources/css/images/ODOLogoVector.png"/>
        <script src="/resources/js/jquery-1.12.3.js?v180118"></script>
        <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v180118"></script>
<!--        <script src="/resources/dataTableNew/media/js/dataTables.jqueryui.js?v180118" type="text/javascript"></script>-->
        <script src="/resources/js/jquery.form.js?v180118"></script>
        <script src="/resources/contextmenu/jquery.contextMenu.js?v180118"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v180118"></script>
        <script src="/resources/dataTableNew/media/js/jquery.dataTables.js?v180118"></script>
        <script src="resources/jszip.min/jszip.min.js?v180118" type="text/javascript"></script>
        <script src="resources/PDFMAKE_files/pdfmake.min.js?v180118" type="text/javascript"></script>
        <script src="resources/PDFMAKE_files/vfs_fonts.js?v180118" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Buttons/js/buttons.html5.min.js?v180118" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/KeyTable/js/dataTables.keyTable.js?v180118" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Select/js/dataTables.select.js?v180118" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Buttons/js/dataTables.buttons.js?v180118" type="text/javascript"></script>
        <script src="resources/jszip.min/jszip.min.js?v180118" type="text/javascript"></script>
        <script src="resources/PDFMAKE_files/pdfmake.min.js?v180118" type="text/javascript"></script>
        <script src="resources/PDFMAKE_files/vfs_fonts.js?v180118" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Buttons/js/buttons.html5.min.js?v180118" type="text/javascript"></script>
        <script src="./resources/ckeditor/ckeditor.js?v180118"></script>
        <script src="./resources/primeui-4.1.12/primeui.min.js?v180118"></script>
        <script src="./resources/js/admin_112014_uzytkownicy.js?v180118"></script>
        <script src="./resources/js/globales.js?v180118"></script>
        <script src="./resources/js/common_generowanietabeli.js?v180118"></script>
        <title>Testy Dane Wrażliwe</title>
        <script> 
            $(document).ready(function () {
                $('#notify').puigrowl({
                    life: 6000
                });
            });
        </script>
    </head> 
    <body>
        <div id="notify"></div>
        <?php
        include_once './menu_uzytkownicy.php';
        ?>
        <?php
        include_once './admin_uzytkownicy112014.php';
        ?>
    </body> 
</html>
