 <?php
    error_reporting(0);
    if (session_status() != 2) {
        session_start();
    };
    if ($_SESSION['uczestnik']['uprawnienia'] != "admin") {
        die("Nie jesteś upoważniony do przeglądania zasobu");
    }
    ?>
<!DOCTYPE html>
<html lang="pl">
    <meta charset="utf-8">
    <head>
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v190707" />
        <link rel="stylesheet" href="/resources/dataTableNew/media/css/jquery.dataTables.css?v190707"/>
         <link href="resources/dataTableNew/extensions/KeyTable/css/keyTable.dataTables.css?v190707" rel="stylesheet" type="text/css"/>
        <link href="resources/dataTableNew/extensions/Select/css/select.dataTables.css?v190707" rel="stylesheet" type="text/css"/>
        <link href="resources/dataTableNew/extensions/Buttons/css/buttons.dataTables.css?v190707" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="/resources/css/tablecss.css?v190707"/>
        <link rel="stylesheet" href="/resources/css/main.css?v190707"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v190707"/>
        <link rel="stylesheet" href="./resources/primeui-4.1.12/primeui.min.css?v190707"/>
        <link href="resources/font-awesome/css/font-awesome.min.css?v190707" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="/resources/primeui-4.1.12/themes/bootstrap/theme.css?v190707"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/resources/css/images/ODOLogoVector.png"/>
        <script src="/resources/js/jquery-1.12.3.js?v190707"></script>
        <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v190707"></script>
        <script src="/resources/dataTableNew/media/js/dataTables.jqueryui.js?v190707" type="text/javascript"></script>
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
        <script src="resources/dataTableNew/extensions/KeyTable/js/dataTables.keyTable.js?v190707" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Select/js/dataTables.select.js?v190707" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Buttons/js/dataTables.buttons.js?v190707" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Buttons/js/buttons.html5.min.js?v190707" type="text/javascript"></script>
        <script src="/resources/ckeditor/ckeditor.js?v190707"></script>
        <script src="/resources/primeui-4.1.12/primeui.min.js?v190707"></script>
        <script src="/resources/js/globales.js?v190707"></script>
        <script src="/resources/js/require.js?v190707"></script>
        <script src="/resources/js/admin_112014_uzytkownik_grupy.js?v190707"></script>
        
        
        <title>Testy Dane Wrażliwe</title>

        <script>
            $(document).ready(function() {
                $('#notify').puigrowl({
                    life: 6000
                });
//                var tabela = $("#tabuser").dataTable();
//                tabela.$(".czekboks").on("click", function() {
//                    var parent = this.parentNode.children;
//                    czyscinnewiersze(this.parentNode);
//                    try {
//                        if (parent[3].children[0].checked === true) {
//                            parent[4].children[0].style.display = "inline";
//                            parent[5].children[0].style.display = "inline";
//                        } else {
//                            parent[4].children[0].style.display = "none";
//                            parent[5].children[0].style.display = "none";
//                        }
//                    } catch (ex) {
//                    }
//                });

                //                $('#t-btn-show').puibutton({  
                //                    click: function() {  
                //                        $('#notify').puigrowl('show', [{severity: 'info', summary: 'Message Summary', detail: 'Message Detail'}]);
                //                    }  
                //                });  
            });
        </script>
    </head>
    <body>
        <div id="notify"></div>
        <?php
        include_once './menu_uzytkownik_grupy.php';
        ?>
        <?php
        include_once './admin_uzytkownikgrupy112014.php';
        ?>
        
    </body>
</html>
