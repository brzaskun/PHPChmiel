<?php
    session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
    if (session_status() != 2) {
        session_start();
    };
     error_reporting(E_ALL & ~E_DEPRECATED);
    $_SESSION['szkolenietrwa'] = "nie";
    $_SESSION['testrozpoczety'] = "nie";
    require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/PL_EN.php');
    $lang = PL_EN::wybierzjezyk($_SESSION['uczestnik']['nazwaszkolenia']);
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v190707" />
        <link rel="stylesheet" href="/resources/css/main.css?v190707"/>
        <link rel="stylesheet" href="/resources/css/details.css?v190707"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v190707"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/resources/css/images/ODOLogoVector.png"/>
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
        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Sprawdzwyniki.php');
        Sprawdzwyniki::jakoscodpowiedzi();
        ?>
        <div class="box">
            <div class="slajd">
                <div id="testnaglowek">
                    <h2><?= PL_EN::$wyniktestu[$lang]?></h2>
                </div>
                <form id="form" action="">
                    <div style="width: 90%; height: 320px; margin-left: auto; margin-right: auto; margin-top: 0px; font-size: 120%;"> 
                        <!--                <div style="height: 100px; text-align: left; font-size: 120%;">
                                            <p id="odpowiedz">Zadane w teście pytania:</p>
                                            <php foreach (Sprawdzwyniki::$zadanepytania as $pytanie) {?>
                                            <span><php echo $pytanie['pytanie']?></span><br/>
                                            <php }?>
                                        </div>-->
                        <div class="trescszkolenia"> 
                            <p><?= PL_EN::$punkty_1[$lang]?><?php error_reporting(0);
        echo Sprawdzwyniki::$iloscpoprawnych ?></p>
                            <p><?= PL_EN::$punkty_2[$lang]?><?php error_reporting(0);
        echo Sprawdzwyniki::$iloscblednych ?></p>
                            <p><?= PL_EN::$punkty_3[$lang]?><?php error_reporting(0);
        echo Sprawdzwyniki::$roznicapunktow ?></p>
                            <p><?= PL_EN::$punkty_4[$lang]?><?php error_reporting(0);
        echo Sprawdzwyniki::$iloscodpowiedzi ?></p>
                            <p><?= PL_EN::$punkty_5[$lang]?><?php error_reporting(0);
        echo Sprawdzwyniki::$wynik ?>%</p><div id="zaliczeniebar"><div></div></div>
                            <p><?= PL_EN::$punkty_6[$lang]?><?php error_reporting(0);
        echo Sprawdzwyniki::$progzdawalnosci ?>%</p><div id="zdawalnoscbar"><div></div></div>
                        </div>
                        <div class="dolneprzyciski" >
<!--                            <button id="zaswiadczenie" name="zaswiadczenie" class="buttonszkolenie" type="button" onclick="generujtesty()" style="float: right;" title="Pobranie zaświadczenia o ukończeniu szkolenia">
                                <span class="spanszkolenie">zaświadczenie</span>
                            </button>-->
                            <button id="zaswiadczenie" name="zaswiadczenie" class="buttonszkolenie" formaction="drukzaswiadczenie.php?<?=bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM))?>" 
                                    formmethod="post"
                                    type="submit"  style="float: right;" title="Pobranie zaświadczenia o ukończeniu szkolenia" onclick="generujtesty()">
                                <span class="spanszkolenie"><?= PL_EN::$zaswiadczenie[$lang]?></span>
                            </button>
                            <button id="powtorztest" name="powtorztest" type="submit" class="buttonszkolenie" formaction="nowylogin.php?<?=bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM))?>" formmethod="post"
                                    style="float: right;"><span class="spanszkolenie" title="Możliwość powtórzenia szkolenia i testu"><?= PL_EN::$powtorz[$lang]?></span></button>
                        </div>
                    </div>
                </form>

                <script>
                    (function () {
                        var zdane = <?php error_reporting(0);
        echo Sprawdzwyniki::$zdane ?>;
                        if (zdane === 1) {
                            $('#zaswiadczenie').show();
                            $('#powtorztest').hide();
                        } else {
                            $('#zaswiadczenie').hide();
                            $('#powtorztest').show();
                        }
                        $("#zaliczeniebar").progressbar({
                            value: <?php error_reporting(0);
        echo Sprawdzwyniki::$wynik ?>
                        });
                        $("#zaliczeniebar").css({
                            'background': 'white'
                        });
                        $("#zaliczeniebar > div").css({
                            'background': 'rgb(74,26,15)'
                        });
                        $("#zdawalnoscbar").progressbar({
                            value: <?php error_reporting(0);
        echo Sprawdzwyniki::$progzdawalnosci ?>
                        });
                        $("#zdawalnoscbar").css({
                            'background': 'white'
                        });
                        $("#zdawalnoscbar > div").css({
                            'background': 'rgb(243,112,33)'
                        });

                    }());
                </script>
        <?php error_reporting(0);
        require_once('resources/php/KoniecTestu.php');
        if (Sprawdzwyniki::$zdane ==1) {
            KoniecTestu::odnotuj();
            KoniecTestu::archiwizuj();
        }
        ?>;
            </div>
        </div>
        <div id="ajax_sun" title="generowanie " style="display: none; text-align: center; z-index: -1; position: absolute; width: 100px; height: 120px;">
            <img src="/images/ajax_loaderc.gif" alt="ajax" height="90" width="95">;
        </div>
    </body>
</html>
