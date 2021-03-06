<?php
    session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
    if (session_status() != 2) {
        session_start();
    };
    error_reporting(E_ALL & ~E_DEPRECATED);
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
        require_once('resources/php/CertyfikatGenerowanie.php');
        require_once('resources/php/UpowaznienieGenerowanie.php');
//CertyfikatGenerowanie::generuj();
        require_once('resources/php/Rb.php');
        if ($_SERVER["HTTP_HOST"] != "localhost:8000") {
            $_SESSION['host'] = 'mysql:host=172.16.0.6;';
        } else {
            $_SESSION['host'] = 'mysql:host=localhost;';
        }
//        echo "R setup" . "\r\n";
        R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
//        echo "Mail setup" ."\r\n";
        require_once('resources/php/Mail.php');
        date_default_timezone_set('Europe/Warsaw');
        $id = $_SESSION['uczestnik']['id'];
//        echo "id " . $id . "\r\n";
        $email = $_SESSION['uczestnik']['email'];
//        echo "email " . $email . "\r\n";
        if ($id > 0) {
//            echo "zaczynam generowac zaswiadczenie"."\r\n";
            $email = $_SESSION['uczestnik']['email'];
            $szkolenie = $_SESSION['uczestnik']['nazwaszkolenia'];
            $uczestnik = $_SESSION['uczestnik'];
            $plec = $_SESSION['uczestnik']['plec'];
            $imienaz = $_SESSION['uczestnik']['imienazwisko'];
            $kontakt = "ODO Management Group";
            if (isset($_SESSION['uczestnik']['kontakt'])) {
                $kontakt = $_SESSION['uczestnik']['kontakt'];
            }
            $bcc = CertyfikatGenerowanie::pobierzBCC($kontakt);
            $datadozapisu = R::getCell("SELECT `sessionend` FROM `uczestnicy` WHERE  `uczestnicy`.`id` = '$id';");
            $datadozapisu = date('d.m.Y', strtotime($datadozapisu));
            $poziomzaswiadczenie = CertyfikatGenerowanie::pobierzPoziomZaswiadczenia();
            $html = CertyfikatGenerowanie::pobierzTrescZaswiadczenia($imienaz, $datadozapisu, $poziomzaswiadczenie);
            require_once('resources/MPDF57/mpdf.php');
            $mpdf = new mPDF();
            $mpdf->SetImportUse();
            $id_zaswiadczenie = (int) R::getCell("SELECT id_zaswiadczenie FROM szkoleniewykaz WHERE nazwa = '$szkolenie'");
            $pdf = R::getCell("SELECT pdf FROM zaswiadczenia WHERE id = '$id_zaswiadczenie'");
            if ($pdf) {
                $pagecount = $mpdf->SetSourceFile('resources/css/pics/'.$pdf);
            } else {
                $pagecount = $mpdf->SetSourceFile('resources/css/pics/zaswiadczenie1.pdf');
            }
            $tplId = $mpdf->ImportPage($pagecount);
            $mpdf->UseTemplate($tplId);
            $mpdf->WriteHTML($html);
            require_once('resources/php/ConvertNames.php');
            $imienazplik = ConvertNames::cn($imienaz);
            $id_szkolenia = R::getCell("SELECT id FROM szkoleniewykaz WHERE nazwa = '$szkolenie'");
            $nazwapliku = 'resources/zaswiadczenia/zaswiadczenie' . $id . '_' . $imienazplik . '.' . $id_szkolenia . '.' . 'pdf';
            $mpdf->Output($nazwapliku, 'F');
            $czysiewyslalo = "nie";
            $czysiewyslalo = Mail::mailzaswiadczenie($imienaz, $plec, $email, $nazwapliku, $poziomzaswiadczenie, $bcc, $szkolenie, $id);
//            echo "wyslalem zaswiadczenie\r" . +"\r\n";
            //czas sesji zaswiadcza, ze funkcja zostala wykonana bez bledu do konca 
            if ($czysiewyslalo=="tak") {
                $czasbiezacy = date("Y-m-d H:i:s");
                $id = $_SESSION['uczestnik']['id'];
                R::exec("UPDATE  `uczestnicy` SET  `zaswiadczeniedata`='$czasbiezacy' WHERE  `uczestnicy`.`id` = '$id';");
            }
        }

//UpowaznienieGenerowanie::generuj();
        $id = $_SESSION['uczestnik']['id'];
        date_default_timezone_set('Europe/Warsaw');
        $niewyslano = (int) R::getCell("SELECT  `wyslaneup` FROM `uczestnicy` WHERE  `uczestnicy`.`id` = '$id';");
        $email = $_SESSION['uczestnik']['email'];
//        echo "sporawdzam generowac upowaznienie\n" . +"\r\n";
        if ($niewyslano == 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $grupy = UpowaznienieGenerowanie::pobierzgrupy($id);
            if (strlen($grupy) > 0) {
//                echo "zaczynam generowac upowaznienie\n"."\r\n";
                $uczestnik = $_SESSION['uczestnik'];
                $szkolenie = $_SESSION['uczestnik']['nazwaszkolenia'];
                $plec = $_SESSION['uczestnik']['plec'];
                $imienaz = $_SESSION['uczestnik']['imienazwisko'];
                $kontakt = "ODO Management Group";
                if (isset($_SESSION['uczestnik']['kontakt'])) {
                    $kontakt = $_SESSION['uczestnik']['kontakt'];
                }
                $bcc = UpowaznienieGenerowanie::pobierzBCC($kontakt);
                $nrupowaznienia = $_SESSION['uczestnik']['nrupowaznienia'];
                $datanadania = R::getCell("SELECT  `datanadania` FROM `uczestnicy` WHERE  `uczestnicy`.`id` = '$id';");
                $dataustania = $_SESSION['uczestnik']['dataustania'];
                if ($dataustania == null || $dataustania == "") {
                    $sqlfirma = $_SESSION['uczestnik']['firma'];
                    $nrupowaznienia = $_SESSION['uczestnik']['nrupowaznienia'];
                    $sql = "SELECT `miejscowosc` FROM `zakladpracy` WHERE `zakladpracy`.`nazwazakladu`='$sqlfirma';";
                    $miejscowosc = R::getCell($sql);
                    $sql = "SELECT `ulica` FROM `zakladpracy` WHERE `zakladpracy`.`nazwazakladu`='$sqlfirma';";
                    $ulica = R::getCell($sql);
                    require_once("resources/MPDF57/mpdf.php");
                    require_once('resources/php/UpowaznienieText.php');
                    if (strpos($sqlfirma, 'Sąd Rejonowy') !== false) { 
                        $miejscowosc = substr($sqlfirma,16);
                        $sql = "SELECT uczestnikgrupy.grupa FROM uczestnikgrupy WHERE id_uczestnik = '$id'  AND grupa!='dane szczególnej kategorii'";
                        $zapisanegrupy = R::getCol($sql);
                        $zapisanegrupy = trim($zapisanegrupy[0]);
                        $grupaPrezes = array("sekretarz sądowy","starszy sekretarz sądowy","sędzia","aplikant studencki","referendarz sądowy","asystent sędziego","aplikant kuratorski","kurator zawodowy","starszy kurator zawodowy","ławnik","kurator społeczny","praktykant","kurator specjalny");
                        $grupaDyrektor = array("sekretarz sądowy","starszy sekretarz sądowy","specjalista ds. administracyjnych i finansowych","administrator systemu informatycznego","główny księgowy","zastępca głównego księgowego","p.o. sekretarka","protokolant sądowy","woźny sadowy","sekretarka","sekretarz","specjalista ds. administracyjno-gospodarczych","kasjer","starszy inspektor","praktykant absolwencki","pracownik archiwum");
                        $szef = "Prezes";
                        if (in_array($zapisanegrupy, $grupaDyrektor)) {
                            $szef = "Dyrektor";
                        }
                        if ($plec == "k") {
                            $html = UpowaznienieText::upowaznienie_kobieta_SR($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy, $szef);
                        } else {
                            $html = UpowaznienieText::upowaznienie_mezczyzna_SR($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy, $szef);
                        }
                    } else if  (strpos($sqlfirma, 'TKwadrat') !== false) {
                        if ($plec == "k") {
                            $html = UpowaznienieText::upowaznienie_kobieta_Fundacja($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy);
                        } else {
                            $html = UpowaznienieText::upowaznienie_mezczyzna_Fundacja($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy);
                        }
                    } else if  (strpos($sqlfirma, 'Rzecznik') !== false) {
                        if ($plec == "k") {
                            $html = UpowaznienieText::upowaznienie_kobieta_Rzecznik($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy);
                        } else {
                            $html = UpowaznienieText::upowaznienie_mezczyzna_Rzecznik($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy);
                        }
                    } else if  (strpos($sqlfirma, 'Dyscyplinarny') !== false) {
                        if ($plec == "k") {
                            $html = UpowaznienieText::upowaznienie_kobieta_SD($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy);
                        } else {
                            $html = UpowaznienieText::upowaznienie_mezczyzna_SD($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy);
                        }
                    } else {
                        if ($plec == "k") {
                            $html = UpowaznienieText::upowaznienie_kobieta_old($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy);
                        } else {
                            $html = UpowaznienieText::upowaznienie_mezczyzna_old($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy);
                        }
                    }
                    $mpdf = new mPDF();
                    $mpdf->WriteHTML($html);
                    require_once('resources/php/ConvertNames.php');
                    $imienazplik = ConvertNames::cn($imienaz);
                    $id_szkolenia = R::getCell("SELECT id FROM szkoleniewykaz WHERE nazwa = '$szkolenie'");
                    $nazwapliku = 'resources/upowaznienia/upowaznienie' . $id . '-' . $imienazplik . '.' . $id_szkolenia . '.' . 'pdf';
                    $mpdf->Output($nazwapliku, 'F');
                    $czysiewyslalo2 = "nie";
                    $czysiewyslalo2 = Mail::mailupowaznienie($imienaz, $plec, $email, $nazwapliku, $poziomzaswiadczenie, $bcc, $id);
                    //czas sesji zaswiadcza, ze funkcja zostala wykonana bez bledu do konca 
                    if ($czysiewyslalo2=="tak") {
                        $czasbiezacy = date("Y-m-d H:i:s");
                        $id = $_SESSION['uczestnik']['id'];
                        R::exec("UPDATE  `uczestnicy` SET  `upowaznieniedata`='$czasbiezacy' WHERE  `uczestnicy`.`id` = '$id';");
                    }
                }
            }
        }
//        echo "skonczylem generowac upowaznienie\r"."\r\n";
        ?>        
        <div class="box">
            <div class="slajd">
            <div id="testnaglowek">
                    <h2><?= PL_EN::$wygenerowanozaś[$lang]?><?=$_SESSION['uczestnik']['id']?>_id</h2>
                </div>
                <div class="pytanietest">
                    <p style="font-size: 150%; margin-left: 3%"> <?= PL_EN::$gratulujemy[$lang]?></p>
                    <p style="font-size: 150%; margin-left: 3%"> ODO Management Group.</p>
                    <div style="padding: 3%; padding-top: 1%">
                        <p><?= PL_EN::$wyslalismycert[$lang]?></p>
                    </div>
                    <div style="padding: 3%;">
                        <p><?= PL_EN::$dziekujemy1[$lang]?></p>
                        <p><?= PL_EN::$dziekujemy2[$lang]?></p> 
                    </div>
                   
                </div>
<!--            <div id="testnaglowek">
                    <h2>Wygenerowano zaświadczenie id_<?=$_SESSION['uczestnik']['id']?>_id</h2>
                </div>
                <div class="pytanietest">
                  <p style="font-size: 150%; margin-left: 3%"> Gratulujemy ukończenia szkolenia przygotowanego przez</p>
                    <p style="font-size: 150%; margin-left: 3%"> ODO Management Group.</p>
                    <div style="padding: 3%; padding-top: 1%">
                        <p>Z powodów technicznych nie mogło być teraz właśnie wysłane zaświadczenie potwierdzające zaliczenie testu.</p>
                    </div>
                    <div style="padding: 3%;">
                        <p>Niezwłocznie po usunięciu awarii serwera, doślemy wygenerowane zaświadczenie. </p>
                        <p>Zespół ODO Management Group</p> 
                    </div>
                   
                </div>-->
        </div>
        </div>
    </body>
    <?php
    $_SESSION['szkolenietrwa'] = "nie";
    $_SESSION['testrozpoczety'] = "nie";
// Na koniec zniszcz sesję
    $_SESSION = array();
    session_destroy();
    ?>
</html>
