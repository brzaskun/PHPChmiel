<?php
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
if (session_status() != 2) {
    session_start();
}
error_reporting(2);
$sciezkaroot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
require_once($sciezkaroot . '/resources/php/Rb.php');
require_once($sciezkaroot . '/resources/php/Zerowanieciastek.php');
//inicjujemy clase do lazczenia sie z baza danych
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$mail = $_SESSION['mail'];
$parametr = "email = '$mail'";
$uczestnicy = R::findOne('uczestnicy', $parametr);
$_SESSION['uczestnik']['firma'] = $uczestnicy['firma'];
$sqlfirma = $_SESSION['uczestnik']['firma'];
$sql = "SELECT `firmaaktywna` FROM `zakladpracy` WHERE `zakladpracy`.`nazwazakladu`='$sqlfirma';";
$firmaaktywna = R::getCell($sql);
//jezeli uczestnik jest z firmy nieaktywnej to przekieruj na specjalny slide
if ($firmaaktywna==0) {
    $url = "exit_.php?$zm";
    header("Location: $url");
    $_SESSION['wyjdz'] = 'tak';
    exit();
}
//to usuuwamy bo sa wyjatki
//if (isset($_SESSION['uczestnik']['dataustania']) && $_SESSION['uczestnik']['dataustania']!='') {
//    $zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
//    $url = "exit_dataustania.php?$zm";
//    header("Location: $url");
//    $_SESSION['wyjdz'] = 'tak';
//    exit();
//}
$szkolenianowe = array();
$szkoleniazdane = array();
$uczestnicy = R::findAll('uczestnicy', $parametr);
foreach (array_values($uczestnicy) as $val) {
    if ($val->wyslanycert == 1) {
        if ($val->dataustania!='') {
            $szkoleniazdane[$val->nazwaszkolenia] = -1;
        } else {
            $szkoleniazdane[$val->nazwaszkolenia] = $val->id;
        }
    } else {
        $szkolenianowe[$val->nazwaszkolenia] = $val->id;
    }
}
//if (isset($_GET['mail'])) {
//    $mail = filter_input(INPUT_GET, 'mail', FILTER_VALIDATE_EMAIL);
//    $_SESSION['mail'] = $mail;
//    $url = 'sprawdzlogin.php';
//    header("Location: $url");
//    exit();
//}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v190707" />
        <link rel="stylesheet" href="/resources/dataTableNew/media/css/jquery.dataTables.css?v190707"/>
        <link rel="stylesheet" href="/resources/css/tablecss.css?v190707"/>
        <link rel="stylesheet" href="/resources/css/main.css?v190707"/>
        <link rel="stylesheet" href="/resources/css/details.css?v190707"/>
        <link rel="stylesheet" href="/resources/contextmenu/jquery.contextMenu.css?v190707"/>
        <link rel="stylesheet" href="/resources/primeui-4.1.12/primeui.min.css?v190707"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/resources/css/images/ODOLogoVector.png"/>
        <script src="/resources/js/jquery-1.12.3.js?v190707"></script>
        <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v190707"></script>
        <script src="/resources/js/jquery.form.js?v190707"></script>
        <script src="/resources/dataTableNew/media/js/jquery.dataTables.js?v190707"></script>
        <script src="/resources/contextmenu/jquery.contextMenu.js?v190707"></script>
        <script src="/resources/contextmenu/jquery.ui.position.js?v190707"></script>
        <script src="/resources/js/main.js?v190707"></script>
        <script src="/resources/js/globales.js?v190707"></script>
        <script src="/resources/js/ciasteczka.js?v190707"></script>
        <script src="/resources/primeui-4.1.12/primeui.min.js?v190707"></script>
        <!--[if lt IE 9]>
                 <script src="https://html5shim.googlecode.com/svn/trunk/html5.js?v190707"></script>
         <![endif]-->
        <title>Wybór szkolenia</title>
        <script>
            var odhaczinne = function (obj, iduczestnika) {
                var par = $(obj).closest("tr");
                var czekboxy = $(par).siblings();
                $.each(czekboxy, function () {
                    if (this !== par) {
                        $(this).find(".czekbox").attr('checked', false);
                    }
                });
                var ciastko = new Cookie("iduczestnika");
                ciastko.value = iduczestnika;
                ciastko.save();
                $("#buttonlogowanie").show();
                $("#wyborszkoleniainfo").hide();
            }
        </script>
    </head>
    <body>
        <div class="box">
            <div class="slajd">
                <div id="loginnaglowek">
                    <h2>Twoje szkolenia</h2>
                </div>
                <div style="text-align: center;">
                    <h2>Przygotowano dla Ciebie więcej niż jedno szkolenie.</h2>
                    <h2>Wybierz, które chcesz rozpocząć.</h2>
                </div>
                <div style="padding: 10px; margin-left: 25%;">
                    <form id="loginform">
                        <table>
                            <?php
                            foreach ($szkolenianowe as $key => $value) {
                                echo "<tr>";
                                echo "<td style='font-size: larger'><input type='checkbox' class='czekbox' onclick='odhaczinne(this,\"$value\")'></input><span>$key - nowe, rozpocznij szkolenie</span></td>";
                                echo "</tr>";
                            }
                            foreach ($szkoleniazdane as $key => $value) {
                                if ($value==-1) {
                                    echo "<tr>";
                                    echo "<td style='font-size: larger'><input type='checkbox' disabled class='czekboxover' ></input><span style-'itaklic' >$key - zdane i zarchiwizowane, nie można się zalogować</span></td>";
                                    echo "</tr>";
                                } else {
                                    echo "<tr>";
                                     echo "<td style='font-size: larger'><input type='checkbox' class='czekbox' onclick='odhaczinne(this,\"$value\")'></input><span>$key - zdane, pobierz certyfikat</span></td>";
                                    echo "</tr>";

                                }
                            }
                            ?>
                        </table>
                        <button id="buttonlogowanie" type="submit"  title="Kliknij celem rozpoczęcia szkolenia" 
                                formaction="sprawdzlogin_1.php" formmethod="POST" style="display: none;">
                            <span class="spanszkolenie" >wybierz</span>
                        </button>
                    </form>
                </div>
                <div class="margin2" style="height: 10px; text-align: left;">
                    <span id="wiadomoscajax"></span>
                </div>
                <div class="margin1" style="margin-top: 5%; text-align: left;">
                    <span id="wyborszkoleniainfo">Szkolenie rozpoczyna się pod warunkiem wybrania jednego szkolenia z wielu</span>
                </div>
            </div>
        </div>
        <div id="notify"></div>
    </body>
</html>
