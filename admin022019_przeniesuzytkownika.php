<!DOCTYPE html>
<html lang="pl">
    <?php error_reporting(0);
    if(session_status()!=2){     session_start(); };
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
        <script src="/resources/js/admin_022019_przeniesuzytkownika.js?v190707"></script>
        <script src="/resources/js/jquery.selectlistactions.js?v190707"></script>
        <title>Testy Dane Wrażliwe</title>
        <script>
              $(document).ready(function() {
                $('#notify').puigrowl({
                    life: 6000
                });
                $('#btnRight').click(function (e) {
                    $('select').moveToListAndDelete('#pracownicyfirma', '#pracownicyfirma2');
                    $('#notify').puigrowl('show', [{severity: 'info', summary: 'Przesunięto w prawo'}]);
                e.preventDefault();
                });

                $('#btnAllRight').click(function (e) {
                    $('select').moveAllToListAndDelete('#pracownicyfirma', '#pracownicyfirma2');
                    $('#notify').puigrowl('show', [{severity: 'info', summary: 'Przesunięto wszystko w prawo'}]);
                    e.preventDefault();
                });

                $('#btnLeft').click(function (e) {
                    $('select').moveToListAndDelete('#pracownicyfirma2', '#pracownicyfirma');
                    $('#notify').puigrowl('show', [{severity: 'info', summary: 'Przesunięto w lewo'}]);
                    e.preventDefault();
                });

                $('#btnAllLeft').click(function (e) {
                    $('select').moveAllToListAndDelete('#pracownicyfirma2', '#pracownicyfirma');
                    $('#notify').puigrowl('show', [{severity: 'info', summary: 'Przesunięto wszystko w lewo'}]);
                    e.preventDefault();
                });
            });
           
        </script>
        <style>
            .columna {
                float: left;
                width: 44%;
              }
            .columnas {
                float: left;
                width: 12%;
                text-align: center;
            }

              /* Clear floats after the columns */
              .rowa:after {
                content: "";
                display: table;
                clear: both;
              }
        </style>
    </head> 
    <body>
         <?php
            include_once './menu_przeniesuzytkownika.php';
        ?>
        <div id="notify"></div>
        <div id="panelladowaniapliku" style="box-shadow: 10px 10px 5px #888; padding: 20px;  margin-top: 10px; background-color: #e9e9e9;">
            <span>Przenoszenie uczestników z firmy do firmy</span>
            <form>
            <div class="rowa" style="width: 900px;margin-top: 10px;">
                <div class="columna">
                    <div style="width:420px;">
                        <select id="aktywnafirma" name="aktywnafirma"></select>
                    </div>
                    <div style="width:420px;">
                        <select id="pracownicyfirma" name="pracownicyfirma" style="height: 300px; width: 300px; display: none;" size="15">
                            
                        </select>
                    </div>
                </div>
                <div  class="columnas">
                    <div class="row">
                        <div class="subject-info-arrows text-center" style="width: 60px; text-align: center;">
                            <br /><br />
                            <input type='button' id='btnAllRight' value='>>' class="btn btn-default" /><br />
                            <input type='button' id='btnRight' value='>' class="btn btn-default" /><br />
                            <input type='button' id='btnLeft' value='<' class="btn btn-default" /><br />
                            <input type='button' id='btnAllLeft' value='<<' class="btn btn-default" />
                        </div>
                    </div>
                </div>
                <div class="columna">
                    <div style="width:420px;">
                        <select id="aktywnafirma2" name="aktywnafirma2"></select>
                    </div>
                    <div style="width:420px;">
                        <select id="pracownicyfirma2" name="pracownicyfirma2" style="height: 300px; width: 300px; display: none;" size="15">
                            
                        </select>
                    </div>
                </div>
            </div>
            <div style="margin-top: 10px;">
                <input id="buttonzachowaj" name="buttonzachowaj" value="zachowaj" type="button" style="width: 120px; display: none;" onclick="zachowajprzesuniecie()"/>
            </div>
            </form>
        </div>
    </body>
</html>
