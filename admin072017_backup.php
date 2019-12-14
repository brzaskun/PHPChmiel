<!DOCTYPE html>
<html lang="pl">
    <?php
    session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');   if(session_status()!=2){     session_start(); };
    error_reporting(0);
    if ($_SESSION['uczestnik']['uprawnienia'] != "admin") {
        die("Nie jesteś upoważniony do przeglądania zasobu");
    }
    if ($_SERVER["HTTP_HOST"] != "localhost:8000") {
        $_SESSION['host'] = 'mysql:host=172.16.0.6;';
    } else {
        $_SESSION['host'] = 'mysql:host=localhost;';
    }
    require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
    R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
    $_coszukac = "SELECT * FROM `uczestnicy` WHERE datanadania IS NOT NULL AND datanadania <>'' AND wyslanymailupr=0";
    $_uzytkownicybezlinka = R::getAll($_coszukac);
    $_coszukac = "SELECT * FROM `uczestnicy` WHERE sessionend IS NOT NULL AND wyslanycert=0";
    $_uzytkownicybezzaswiadczenia = R::getAll($_coszukac);
    $_coszukac = "SELECT * FROM `uczestnicy` WHERE datanadania IS NOT NULL AND datanadania <>'' AND utworzony IS NOT NULL AND wyslaneup=0";
    $_uzytkownicybezupowaznienia = R::getAll($_coszukac);
    ?>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v190707" />
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
        <script src="/resources/js/globales.js?v190707"></script>
        <script src="/resources/contextmenu/jquery.contextMenu.js?v190707"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v190707"></script>
        <script src="/resources/js/main.js?v190707"></script>
        <script src="/resources/js/potwierdzenia.js?v190707"></script>
        <script src="/resources/primeui-4.1.12/primeui.min.js?v190707"></script>
        <script src="/resources/js/admin_072017_backup.js?v190707"></script>
        <link rel="stylesheet" href="/resources/dataTableNew/media/css/jquery.dataTables.css?v190707"/>
         <link href="resources/dataTableNew/extensions/KeyTable/css/keyTable.dataTables.css?v190707" rel="stylesheet" type="text/css"/>
        <link href="resources/dataTableNew/extensions/Select/css/select.dataTables.css?v190707" rel="stylesheet" type="text/css"/>
        <link href="resources/dataTableNew/extensions/Buttons/css/buttons.dataTables.css?v190707" rel="stylesheet" type="text/css"/>
        <script src="/resources/dataTableNew/media/js/jquery.dataTables.js?v190707"></script>
        <script src="resources/jszip.min/jszip.min.js?v190707" type="text/javascript"></script>
        <script src="resources/PDFMAKE_files/pdfmake.min.js?v190707" type="text/javascript"></script>
        <script src="resources/PDFMAKE_files/vfs_fonts.js?v190707" type="text/javascript"></script>
        <script src="resources/dataTableNew/extensions/Buttons/js/buttons.html5.min.js?v190707" type="text/javascript"></script>
        <title>Testy Dane Wrażliwe</title>
        <style>
            .center {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%); /* Yep! */
                width: 48%;
                height: 59%;
              }
        </style>
      </head>
    <body>
        <?php
            include_once './menu_backup.php';
        ?>
        <div style="box-shadow: 10px 10px 5px #888; padding: 30px;  margin-top: 10px; background-color: #363030; ">
            <div style="width: 1100px;box-shadow: 10px 10px 5px #888; padding: 30px;  margin-top: 10px; background-color: gainsboro; ">
            <form >
                <button id='potwierdz' type='button' value="archiwizuj" onclick="archiwizuj();" style="width: 160px; margin-top: 1%; ">archiwizuj dane</button>
            </form>
            <p id="pole1"  style="display: none; color: blue; margin-left: 3%; font-weight: 900;">Rozpoczynam archiwizację</p>
            <p id="pole2"  style="display: none; color: blue; margin-left: 3%; font-weight: 900;">Zakończyłem archiwizację</p>
            </div>
            <div style="width: 1100px;box-shadow: 10px 10px 5px #888; padding: 30px;  margin-top: 10px; background-color: gainsboro; ">
            <form >
                <span>adres email do przetestowania</span>
                <input id="adresemail" name="adresemail" 
                           type="text" onchange="weryfikujtestemail()"   style="width: 280px;"/>
                <button id='testemail' type='button'  onclick="testemaile()" style="width: 160px; margin-top: 1%; ">test email</button>
            </form>
            <p id="pole3"  style="display: none; color: blue; margin-left: 3%; font-weight: 900;">Wysyłam maila</p>
            <p id="pole4"  style="display: none; color: blue; margin-left: 3%; font-weight: 900;">Zakończyłem wysyłkę maila</p>
            <p id="pole5"  style="display: none; color: green; margin-left: 3%; "><span id="pole6"></span></p>
            </div>
            <div style="width: 1100px;margin-top: 25px;box-shadow: 10px 10px 5px #888; padding: 30px;  margin-top: 10px; background-color: gainsboro; ">
                <p style="font-weight: bolder; color: blue;">Uczestnicy bez wysłanego linka</p>
                <table  id="tab1" style="width: 1050px;">
                        <thead>
                            <tr >
                                <th style="text-align: center">imię i nazwisko</th>
                                <th style="text-align: center">email</th>
                                <th style="text-align: center">firma</th>
                                <th style="text-align: center">zaciągnięty</th>
                            </tr>
                        </thead>
                        <tbody>
                                 <?php 
                                foreach ($_uzytkownicybezlinka as $value) { 
                                ?>
                                <tr>
                                <td style="text-align: left"><?php echo $value[imienazwisko];?></td>
                                <td style="text-align: left"><?php echo $value[email];?></td>
                                <td style="text-align: left"><?php echo $value[firma];?></td>
                                <td style="text-align: left"><?php echo $value[utworzony];?></td>
                                </tr>
                                <?php
                                } ?>
                        </tbody>
                    </table>
            </div>
            <div style="width: 1100px;margin-top: 25px;box-shadow: 10px 10px 5px #888; padding: 30px;  margin-top: 10px; background-color: gainsboro; ">
                <p style="font-weight: bolder; color: blue;">Uczestnicy bez wysłanego zaświadczenia</p>
                <table  id="tab2" style="width: 1050px;">
                        <thead>
                            <tr >
                                <th style="text-align: center">imię i nazwisko</th>
                                <th style="text-align: center">email</th>
                                <th style="text-align: center">firma</th>
                                <th style="text-align: center">zaciągnięty</th>
                                <th style="text-align: center">test zakończony</th>
                            </tr>
                        </thead>
                        <tbody>
                                 <?php 
                                foreach ($_uzytkownicybezzaswiadczenia as $value) { 
                                ?>
                                <tr>
                                <td style="text-align: left"><?php echo $value[imienazwisko];?></td>
                                <td style="text-align: left"><?php echo $value[email];?></td>
                                <td style="text-align: left"><?php echo $value[firma];?></td>
                                <td style="text-align: left"><?php echo $value[utworzony];?></td>
                                <td style="text-align: left"><?php echo $value[sessionend];?></td>
                                </tr>
                                <?php
                                } ?>
                        </tbody>
                    </table>
            </div>
            <div style="width: 1100px;margin-top: 25px;box-shadow: 10px 10px 5px #888; padding: 30px;  margin-top: 10px; background-color: gainsboro; ">
                <p style="font-weight: bolder; color: blue;">Uczestnicy bez wysłanego upoważnienia</p>
                <table  id="tab3" style="width: 1050px;">
                        <thead>
                            <tr >
                                <th style="text-align: center">imię i nazwisko</th>
                                <th style="text-align: center">email</th>
                                <th style="text-align: center">firma</th>
                                <th style="text-align: center">zaciągnięty</th>
                                <th style="text-align: center">data nadania</th>
                            </tr>
                        </thead>
                        <tbody>
                                 <?php 
                                foreach ($_uzytkownicybezupowaznienia as $value) { 
                                $nowadatanadania = explode(".", $value[datanadania]);
                                $nowadatanadania2 = $nowadatanadania[2]."-".$nowadatanadania[1]."-".$nowadatanadania[0];
                                ?>
                                <tr>
                                <td style="text-align: left"><?php echo $value[imienazwisko];?></td>
                                <td style="text-align: left"><?php echo $value[email];?></td>
                                <td style="text-align: left"><?php echo $value[firma];?></td>
                                <td style="text-align: left"><?php echo $value[utworzony];?></td>
                                <td style="text-align: left"><?php echo $nowadatanadania2;?></td>
                                </tr>
                                <?php
                                } ?>
                        </tbody>
                    </table>
            </div>
            <div id="ajax_sun" title="archiwizowanie" style="display: none; text-align: center;" class="center">;
                <img src="/images/ajax_loaderc.gif" alt="ajax" height="70" width="70">;
            </div>
        </div>
    </body>
</html>
