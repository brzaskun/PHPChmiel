<?php
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
if (session_status() != 2) {
        session_start(); 
};
error_reporting(0);
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Rb.php');
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$_wynik_firmaall = R::getAll('SELECT * FROM zakladpracy');
?>
<script>
    var ajaxpokaz = function() {
     $("#ajax_sun").puidialog({
        height: 120,
        width: 200,
        resizable: false,
        closable: false,
        showEffect: 'fade',
        hideEffect: 'fade',
        location: "center", 
        modal: true   
    });
    $("#ajax_sun").puidialog('show');
    };
    var pokazprzyciskladowania = function(){
        $("#divprzyciskladowania").show();
    };
</script>
<div style="box-shadow: 10px 10px 5px #888; padding: 30px;  margin-top: 10px; background-color: gainsboro" id="glownydiv">
    <div id="plikwzorcowy" style="height: 40px;">
        <h3>jako plik do wczytania należy wykorzystać uprzednio pobrany plik z uczestnikami szkolenia z danej firmy w formacie XLS</h3>
    </div>
    
    <form id="form1" enctype="multipart/form-data" method="post" action="admin_uzytkownik_grupa_uploadfile.php"> 
        <div id="rodzajimportu"  class="selectbar" style="height: 80px;">
        <p>Rodzaj zasysanych danych</p>
        <select id="rodzajdanych" name="rodzajdanych" style="width: 150px;">
            <option value="oo" disabled selected>wybierz odpowiednią opcję</option>
            <option value="wd">wszystkie dane z pliku</option>
            <option value="du">pobierz tylko daty ustania</option>
            <option value="ndu">pobierz jedynie nowe daty ustania</option>
        </select>
        </div>
        <div style="height: 220px; width: 500px;display: none;" id="divprzyciskladowania">
            <div id="przyciskladowanie" style="height: 60px; width: 200px;border: 1px dashed #BBB; cursor:pointer; text-align: center; vertical-align: middle; display: table-cell;">
                <label for="file" style="font-weight: 800;" onmouseover="$(this).css('background', '#339bb9');" 
                       onmouseout="$(this).css('background', 'gainsboro');">Wybierz plik formatu Excel do wczytania</label><br/>
            </div>
            <div style='height: 0px;width:0px; overflow:hidden;'>
                <input type="file" name="file" id="file" onchange="fileSelected();" accept=".xls,.xlsx" 
                       style="height: 40px; padding: 5px; padding: 10px; width: 220px; margin-left: 2%; float: left;"/>
            </div>
            <div id="fileName"></div>
            <div id="fileSize"></div>
            <div id="fileType"></div>
            <div class="row" style="width: 400px;">
                <input id="wyslij" type="submit" value="Wczytaj" 
                       style="padding: 10px; width: 120px; margin-top: 4%; margin-left: auto; margin-right: auto; display: none"
                       onclick="ajaxpokaz()"/>
                <p id="niewlasciwyplik" style="display: none; color: red;">Plik ma niewłaściwe rozszerzenie</p>
            </div>
            <div id="progressNumber"></div>
            <div id="progressEfect" style="display: none;"><p> Plik wczytano </p></div>
        </div>
        </form>
    <?php
    
    error_reporting(0);
    require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/PHPExcel-1.8.1/Classes/PHPExcel/IOFactory.php';
    
    if (isset($_FILES["file"])) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Error: " . $_FILES["file"]["error"] . "<br>";
            echo "Błąd podczas ławowania pliku";
        } else {
            if ($_POST['rodzajdanych'] == "wd") {
               $_SESSION['rodzajdanych'] = "wd";
               echo "<p style=\"color: blue;font-size:large;\">Pobieranie i nanoszenie wszystkich danych z pliku</p>";
               include_once 'admin_uzytkownik_grupa_plik_1.php';
            } else if ($_POST['rodzajdanych'] == "du") {
               $_SESSION['rodzajdanych'] = "du";
               echo "<p style=\"color: blue;font-size:large;\">Pobieranie i nanoszenie wszystkich dat ustania z pliku</p>";
               include_once 'admin_uzytkownik_grupa_plik_2.php';
            } else if ($_POST['rodzajdanych'] == "ndu") {
                $_SESSION['rodzajdanych'] = "ndu";
               echo "<p style=\"color: blue;font-size:large;\">Pobieranie i nanoszenie jedynie nowych dat ustania z pliku</p>";
               include_once 'admin_uzytkownik_grupa_plik_2.php';
            }
        }
}
?>
    <script>
        $(document).ready(function () {
            try {
                if (<?php error_reporting(0);
                    echo sizeof($wykrytoblad)
                    ?> === 0 && <?php echo isset($_FILES["file"])==true ? 1:0; ?> === 1) {
                    $('#rodzajimportu').hide();
                    $('#wyborfirmydiv').show();
                }
            } catch(e){}
             $('#notify').puigrowl({
                    life: 6000
            });
        });
    </script>
    <style>
    .selectbar .ui-dropdown {
        width: 350px;
    }
    .selectbar1 .ui-dropdown {
        width: 150px;
    }
</style>
   
    <!--    zapelnia to javascript-->
    <div id="wyborfirmydiv" class="selectbar" style="height: 80px; display: none; ">
        <p>Nazwa firmy, do której będą importowani pracownicy</p>
        <select id="IMPfirmauser" name="IMPfirmauser" style="width: 350px;">
        </select>
    </div>
    <div class="row" style="width: 450px;">
        <form id="form2"> 
            <input id="zaladuj" type="button" value="Załaduj do bazy"  onclick="uploadfile_uzyt_grupa()"
                   style="padding: 10px; width: 180px; margin-top: 4%; margin-left: auto; margin-right: auto; display: none;"/>
        </form>
    </div>
    <div id="divodpowiedz" style="height: 40px;">
        
    </div>
    <div>
        <p  style="height: 300px;">
        
        </p>
    </div>
</div>
 <div id="ajax_sun" title="ładowanie danych"  style="display: none; text-align: center; z-index: -1;" > 
        <img src="/images/ajax_loaderc.gif" alt="ajax" height="65" width="65">;
    </div> 
<div id="notify"></div>
