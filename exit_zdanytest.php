<!DOCTYPE html>
<html lang="pl">
<?php
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
error_reporting(0); 
if(session_status()!=2){    
    session_start(); 
};
$_SESSION['szkolenietrwa'] = "nie";
$_SESSION['testrozpoczety']= "nie";
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/PL_EN.php');
$lang = PL_EN::wybierzjezyk($_SESSION['uczestnik']['nazwaszkolenia']);
?>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v190707" />
        <link rel="stylesheet" href="/resources/css/main.css?v190707"/>
        <link rel="stylesheet" href="/resources/css/details.css?v190707"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v190707"/>
        <script src="/resources/js/jquery-1.12.3.js?v190707"></script>
        <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v190707"></script>
        <script src="/resources/js/jquery.form.js?v190707"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v190707"></script>
        <script src="/resources/primeui-4.1.12/primeui.min.js?v190707"></script>
        <script src="/resources/js/main.js?v190707"></script>
        <script src="/resources/js/ciasteczka.js?v190707"></script>
        <title>Testy Dane Wrażliwe</title>
       </head>
    <body>
         <?php error_reporting(0);
             require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Wynikiarchiwum.php');
             Wynikiarchiwum::pobierzwynikiarchiwalne();
            ?>
      
        <div class="box">
             
            <div class="slajd">
            <div id="testnaglowek">
                    <h2><?= PL_EN::$wynikpozytywny[$lang]?> </h2>
                </div>
            <form id="form" action="">
                <div class="trescszkolenia"> 
                    <p><?= PL_EN::$momentrozpoczecia[$lang]?> <?php error_reporting(0); echo Wynikiarchiwum::$datarozpoczecia?></p>
                    <p><?= PL_EN::$momentzakonczenia[$lang]?><?php error_reporting(0); echo Wynikiarchiwum::$datazakonczenia?></p>
                    <p>p<?= PL_EN::$iloscpoprawnych[$lang]?> <?php error_reporting(0); echo Wynikiarchiwum::$iloscpoprawnych?></p>
                    <p><?= PL_EN::$iloscblednych[$lang]?> <?php error_reporting(0); echo Wynikiarchiwum::$iloscblednych?></p>
                    <p><?= PL_EN::$roznicapunktow[$lang]?><?php error_reporting(0); echo Wynikiarchiwum::$roznicapunktow?></p>
                    <p><?= PL_EN::$iloscodpowiedzi[$lang]?><?php error_reporting(0); echo Wynikiarchiwum::$iloscodpowiedzi?></p>
                    <p>z<?= PL_EN::$wynik[$lang]?><?php error_reporting(0); echo Wynikiarchiwum::$wynik?>%</p><div id="zaliczeniebar"><div></div></div>
                    <p><?= PL_EN::$progzdawalnosci[$lang]?><?php error_reporting(0); echo Wynikiarchiwum::$progzdawalnosci?>%</p><div id="zdawalnoscbar"><div></div></div>
                </div>
                <div class="dolneprzyciski"
                     >
                    <button id="zaswiadczenie" 
                            name="zaswiadczenie" class="buttonszkolenie" formaction="drukzaswiadczenie.php?<?=bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM))?>" formmethod="post"
                                    type="submit"  style="float: right;" title="Pobranie zaświadczenia o ukończeniu szkolenia" onclick="generujtesty()">
                                <span class="spanszkolenie"><?= PL_EN::$zaswiadczenie[$lang]?></span>
                            </button>
                </div>
                <script>
                    (function(){
                        $( "#zaliczeniebar" ).progressbar({
                            value: <?php error_reporting(0); echo Wynikiarchiwum::$wynik?>
                        });
                        $( "#zdawalnoscbar" ).progressbar({
                            value: <?php error_reporting(0); echo Wynikiarchiwum::$progzdawalnosci?>
                        });
                          $( "#zaliczeniebar" ).css({
                            'background': 'white'
                        });
                        $( "#zaliczeniebar > div" ).css({
                            'background': '#e05424'
                        });
                        $( "#zdawalnoscbar" ).css({
                            'background': 'white'
                        });
                        $( "#zdawalnoscbar > div" ).css({
                            'background': '#422421'
                        });

                    }());
                     </script>
            </form>
        </div>
        </div>
          <div id="ajax_sun" title="generowanie" style="display: none; text-align: center; z-index: -1; position: absolute; width: 100px; height: 120px;">
            <img src="/images/ajax_loaderc.gif" alt="ajax" height="90" width="95">;
        </div>
    </body>
</html>