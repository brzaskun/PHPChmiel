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
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v190529" />
        <link rel="stylesheet" href="/resources/dataTableNew/media/css/jquery.dataTables.css?v190529"/>
         <link href="resources/dataTableNew/extensions/KeyTable/css/keyTable.dataTables.css?v190529" rel="stylesheet" type="text/css"/>
        <link href="resources/dataTableNew/extensions/Select/css/select.dataTables.css?v190529" rel="stylesheet" type="text/css"/>
        <link href="resources/dataTableNew/extensions/Buttons/css/buttons.dataTables.css?v190529" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="/resources/css/tablecss.css?v190529"/>
        <link rel="stylesheet" href="/resources/css/main.css?v190529"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v190529"/>
        <link rel="stylesheet" href="/resources/primeui-4.1.12/primeui.min.css?v190529"/>
        <link href="resources/font-awesome/css/font-awesome.min.css?v190529" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="/resources/primeui-4.1.12/themes/bootstrap/theme.css?v190529"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/resources/css/images/ODOLogoVector.png"/>
        <script src="/resources/js/jquery-1.12.3.js?v190529"></script>
        <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v190529"></script>
        <script src="/resources/js/jquery.form.js?v190529"></script>
        <script src="/resources/contextmenu/jquery.contextMenu.js?v190529"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v190529"></script>
        <script src="/resources/dataTableNew/media/js/jquery.dataTables.js?v190529"></script>
        <script src="resources/dataTableNew/extensions/KeyTable/js/dataTables.keyTable.js?v190529" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Select/js/dataTables.select.js?v190529" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Buttons/js/dataTables.buttons.js?v190529" type="text/javascript"></script>
        <script src="resources/jszip.min/jszip.min.js?v190529" type="text/javascript"></script>
        <script src="resources/PDFMAKE_files/pdfmake.min.js?v190529" type="text/javascript"></script>
        <script src="resources/PDFMAKE_files/vfs_fonts.js?v190529" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Buttons/js/buttons.html5.min.js?v190529" type="text/javascript"></script>
        <script src="/resources/ckeditor/ckeditor.js?v190529"></script>
        <script src="/resources/primeui-4.1.12/primeui.min.js?v190529"></script>
        <script src="/resources/js/admin_112014_upowaznienie_grupy.js?v190529"></script>
        <script src="/resources/js/globales.js?v190529"></script>
        <script src="/resources/js/admin_062018_zaswiadczenia.js?v190529"></script>
        <title>Testy Dane Wrażliwe</title>
      </head>
    <body>
        <?php
            include_once './menu_zaswiadczenia.php';
        ?>
        <div style="box-shadow: 10px 10px 5px #888; padding: 30px;  margin-top: 10px; background-color: gainsboro; ">
           <?php
            set_time_limit(0);
            ini_set('memory_limit','256M');
            $directory = 'resources/zaswiadczenia/';

            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
            $file = array();
            while($it->valid()) {

                if (!$it->isDot()) {
                    $wiersz = array();
                    $wiersz[0] = $it->getSubPathName();
                    $wiersz[1] = $it->key();
                    $wiersz[2] = date ("Y.m.d H:i:s.", filemtime($it->key()));
                    array_push($file, $wiersz);
                }

                $it->next();
            }

            ?>
            <div style="width: 900px">
            <table id="tabelazplikami" style="width: 850px;">
                <thead>
                    <th></th>
                    <th>nazwa</th>
                    <th>data/link</th>
            </thead>
            <tbody>
                    <? 
                    $licz = 1;
                    foreach ($file as $fil) { ?>
                    <tr>
                        <td><?= $licz++ ?></td>
                        <td><?= $fil[0] ?></td>
                        <td><a href="<?= $fil[1] ?>" target="_blank"><?= $fil[2] ?></a></td>
                    </tr>
                    <? } ?>
                    </tbody>
            </table>
                </div>
        </div>
        
    </body>
</html>
