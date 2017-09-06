<?php
    session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');
    if (session_status() != 2) {
        session_start();
    };
    error_reporting(E_ALL & ~E_DEPRECATED);
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
            <link rel="stylesheet" href="/resources/dataTable/start/jquery-ui-1.10.3.custom.css?v220817a" />
            <link rel="stylesheet" href="/resources/css/main.css?v220817a"/>
            <link rel="stylesheet" href="/resources/css/details.css?v220817a"/>
            <script src="/resources/js/jquery-1.12.3.js?v220817a"></script>
            <script src="/resources/dataTable/jquery-ui-1.10.3.custom.js?v220817a"></script>
            <script src="/resources/js/jquery.form.js?v220817a"></script>
            <script src="/resources/contextmenu/jquery.ui.position.js?v220817a"></script>
            <script src="/resources/primeui-4.1.12/primeui.min.js?v220817a"></script>
            <script src="/resources/js/main.js?v220817a"></script>
            <script src="/resources/js/ciasteczka.js?v220817a"></script>
        <title>Testy Dane Wrażliwe</title> 
    </head>
    <body>
        <?php
        require_once('resources/php/CertyfikatGenerowanie.php');
        require_once('resources/php/UpowaznienieGenerowanie.php');
//CertyfikatGenerowanie::generuj();
        require_once('resources/php/Rb.php');
        echo "R setup" . "\r\n";
        R::setup('mysql:host=localhost;dbname=tb152026_testdane', 'tb152026_madrylo', 'Testdane7005*');
        echo "Mail setup" ."\r\n";
        require_once('resources/php/Mail.php');
        date_default_timezone_set('Europe/Warsaw');
        $id = $_SESSION['uczestnik']['id'];
        echo "id " . $id . "\r\n";
        $email = $_SESSION['uczestnik']['email'];
        echo "email " . $email . "\r\n";
        if ($id > 0) {
            echo "zaczynam generowac zaswiadczenie"."\r\n";
            $email = $_SESSION['uczestnik']['email'];
            $szkolenie = $_SESSION['uczestnik']['nazwaszkolenia'];
            $uczestnik = $_SESSION['uczestnik'];
            $plec = $_SESSION['uczestnik']['plec'];
            $imienaz = $_SESSION['uczestnik']['imienazwisko'];
            $kontakt = $_SESSION['uczestnik']['kontakt'];
            $bcc = CertyfikatGenerowanie::pobierzBCC();
            $datadozapisu = date("d.m.Y");
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
            echo Mail::mailcertyfikat($imienaz, $plec, $email, $nazwapliku, $poziomzaswiadczenie, $kontakt, $bcc, $szkolenie, $id);
            echo "wyslalem zaswiadczenie\r" . +"\r\n";
            //czas sesji zaswiadcza, ze funkcja zostala wykonana bez bledu do konca 
            $czasbiezacy = date("Y-m-d H:i:s");
            $id = $_SESSION['uczestnik']['id'];
            R::exec("UPDATE  `uczestnicy` SET  `zaswiadczeniedata`='$czasbiezacy' WHERE  `uczestnicy`.`id` = '$id';");
        }

//UpowaznienieGenerowanie::generuj();
        $id = $_SESSION['uczestnik']['id'];
        date_default_timezone_set('Europe/Warsaw');
        $niewyslano = (int) R::getCell("SELECT  `wyslaneup` FROM `uczestnicy` WHERE  `uczestnicy`.`id` = '$id';");
        $email = $_SESSION['uczestnik']['email'];
        echo "sporawdzam generowac upowaznienie\n" . +"\r\n";
        if ($niewyslano == 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $grupy = UpowaznienieGenerowanie::pobierzgrupy($id);
            if (strlen($grupy) > 0) {
                echo "zaczynam generowac upowaznienie\n"."\r\n";
                $uczestnik = $_SESSION['uczestnik'];
                $szkolenie = $_SESSION['uczestnik']['nazwaszkolenia'];
                $plec = $_SESSION['uczestnik']['plec'];
                $imienaz = $_SESSION['uczestnik']['imienazwisko'];
                $kontakt = $_SESSION['uczestnik']['kontakt'];
                $bcc = UpowaznienieGenerowanie::pobierzBCC();
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
                    if ($bcc == "") {
                        $bcc = "mchmielewska@interia.pl";
                    }
                    require_once("resources/MPDF57/mpdf.php");
                    if ($plec == "k") {
                        $html = '<!DOCTYPE html><html lang="pl">' .
                                '<head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>' .
                                '<link rel="stylesheet" href="/resources/css/upowaznienie.css"/></head><body>' .
                                '<p align="center"><b>UPOWAŻNIENIE nr ' . $nrupowaznienia . '</p>' .
                                '<p align="center"><b>do przetwarzania danych osobowych<br/>' .
                                'w systemie informatycznym lub w zbiorze w wersji papierowej</b></p>' .
                                '<p align="center"> w <span>' . $sqlfirma . ' z siedzibą w ' . $miejscowosc . ' ' . $ulica . '</span></p>' .
                                '<p></p>' .
                                '<p style="font-size: large;">Z dniem ' . $datanadania . 'r. Pani ' . $imienaz . '</p>' .
                                '<p>otrzymuje upoważnienie do przetwarzania danych osobowych w następujących zbiorach danych:</p>' .
                                '<p><b>' . $grupy . '</b></p>' .
                                '<p align="justify">Zobowiązuję Panią do przestrzegania przepisów dotyczących ochrony danych osobowych oraz wprowadzonych i wdrożonych do stosowania przez Administratora Danych „Polityki Bezpieczeństwa Informacji” oraz „Instrukcji zarządzania systemem informatycznym służącym do przetwarzania danych osobowych.”</p>' .
                                '<p align="justify">Upoważnienie obowiązuje do dnia zakończenia wykonywania obowiązków służbowych względem Administratora Danych świadczonych na podstawie umowy o pracę lub umowy cywilnoprawnej.</p>' .
                                '<p align="center"><b>OŚWIADCZENIE</b></p>' .
                                '<p align="justify" style="font-size: small;">Oświadczam, iż zostałam zapoznana z przepisami dotyczących ochrony danych osobowych, w szczególności ustawy z dnia 29 sierpnia 1997r. o ochronie danych osobowych (tj. Dz.U. z 2016r., poz. 922 z późn.zm.), wydanych na jej podstawie aktów wykonawczych oraz wprowadzonych i wdrożonych do stosowania przez Administratora Danych „Polityki Bezpieczeństwa Informacji” oraz „Instrukcji zarządzania systemem informatycznym służącym do przetwarzania danych osobowych.”</p>' .
                                '<p>Zobowiązuję się do:</p>' .
                                '<ul>' .
                                '<li><p>zachowania w tajemnicy danych osobowych, do których mam lub będę miała dostęp w związku z wykonywaniem zadań służbowych lub obowiązków pracowniczych</p></li>' .
                                '<li><p>niewykorzystywania danych osobowych w celach pozasłużbowych o ile nie są one jawne</p></li>' .
                                '<li><p>zachowania w tajemnicy sposobów zabezpieczenia danych osobowych o ile nie są one jawne</p></li>' .
                                '<li><p>korzystania ze sprzętu IT oraz oprogramowania wyłącznie w związku z wykonywaniem obowiązków pracowniczych</p></li>' .
                                '<li><p>wykorzystywania jedynie legalnego oprogramowania pochodzącego od Pracodawcy</p></li>' .
                                '<li><p>należytej dbałości o sprzęt i oprogramowanie zgodnie z dokumentacją ochrony danych osobowych</p></li>' .
                                '<li><p>korzystania z komputerów przenośnych zgodnie z dokumentacją ochrony danych osobowych</p></li>' .
                                '</ul>' .
                                '<p align="justify">Przyjmuję do wiadomości, iż postępowanie sprzeczne z powyższymi zobowiązaniami, może być uznane przez Pracodawcę za ciężkie naruszenie obowiązków pracowniczych w rozumieniu art. 52 § 1 pkt 1 Kodeksu Pracy lub za naruszenie przepisów karnych ww. ustawy o ochronie danych osobowych.</p>' .
                                '<p></p>' .
                                '<p>………………………</p>' .
                                '<p><i> podpis pracownika</i></p>' .
                                '</body></html>';
                    } else {
                        $html = '<!DOCTYPE html><html lang="pl">' .
                                '<head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>' .
                                '<link rel="stylesheet" href="/resources/css/upowaznienie.css"/></head><body>' .
                                '<p align="center"><b>UPOWAŻNIENIE nr ' . $nrupowaznienia . '</p>' .
                                '<p align="center"><b>do przetwarzania danych osobowych<br/>' .
                                'w systemie informatycznym lub w zbiorze w wersji papierowej</b></p>' .
                                '<p align="center"> w <span>' . $sqlfirma . ' z siedzibą w ' . $miejscowosc . ' ' . $ulica . '</span></p>' .
                                '<p></p>' .
                                '<p style="font-size: large;">Z dniem ' . $datanadania . 'r. Pan ' . $imienaz . '</p>' .
                                '<p>otrzymuje upoważnienie do przetwarzania danych osobowych w następujących zbiorach danych:</p>' .
                                '<p><b>' . $grupy . '</b></p>' .
                                '<p align="justify">Zobowiązuję Pana do przestrzegania przepisów dotyczących ochrony danych osobowych oraz wprowadzonych i wdrożonych do stosowania przez Administratora Danych „Polityki Bezpieczeństwa Informacji” oraz „Instrukcji zarządzania systemem informatycznym służącym do przetwarzania danych osobowych.”</p>' .
                                '<p align="justify">Upoważnienie obowiązuje do dnia zakończenia wykonywania obowiązków służbowych względem Administratora Danych świadczonych na podstawie umowy o pracę lub umowy cywilnoprawnej.</p>' .
                                '<p align="center"><b>OŚWIADCZENIE</b></p>' .
                                '<p align="justify" style="font-size: small;">Oświadczam, iż zostałem zapoznany z przepisami dotyczących ochrony danych osobowych, w szczególności ustawy z dnia 29 sierpnia 1997r. o ochronie danych osobowych (tj. Dz.U. z 2016r., poz. 922 z późn.zm.), wydanych na jej podstawie aktów wykonawczych oraz wprowadzonych i wdrożonych do stosowania przez Administratora Danych „Polityki Bezpieczeństwa Informacji” oraz „Instrukcji zarządzania systemem informatycznym służącym do przetwarzania danych osobowych.”</p>' .
                                '<p>Zobowiązuję się do:</p>' .
                                '<ul>' .
                                '<li><p>zachowania w tajemnicy danych osobowych, do których mam lub będę miała dostęp w związku z wykonywaniem zadań służbowych lub obowiązków pracowniczych</p></li>' .
                                '<li><p>niewykorzystywania danych osobowych w celach pozasłużbowych o ile nie są one jawne</p></li>' .
                                '<li><p>zachowania w tajemnicy sposobów zabezpieczenia danych osobowych o ile nie są one jawne</p></li>' .
                                '<li><p>korzystania ze sprzętu IT oraz oprogramowania wyłącznie w związku z wykonywaniem obowiązków pracowniczych</p></li>' .
                                '<li><p>wykorzystywania jedynie legalnego oprogramowania pochodzącego od Pracodawcy</p></li>' .
                                '<li><p>należytej dbałości o sprzęt i oprogramowanie zgodnie z dokumentacją ochrony danych osobowych</p></li>' .
                                '<li><p>korzystania z komputerów przenośnych zgodnie z dokumentacją ochrony danych osobowych</p></li>' .
                                '</ul>' .
                                '<p align="justify">Przyjmuję do wiadomości, iż postępowanie sprzeczne z powyższymi zobowiązaniami, może być uznane przez Pracodawcę za ciężkie naruszenie obowiązków pracowniczych w rozumieniu art. 52 § 1 pkt 1 Kodeksu Pracy lub za naruszenie przepisów karnych ww. ustawy o ochronie danych osobowych.</p>' .
                                '<p></p>' .
                                '<p>………………………</p>' .
                                '<p><i> podpis pracownika</i></p>' .
                                '</body></html>';
                    }
                    $mpdf = new mPDF();
                    $mpdf->WriteHTML($html);
                    require_once('resources/php/ConvertNames.php');
                    $imienazplik = ConvertNames::cn($imienaz);
                    $id_szkolenia = R::getCell("SELECT id FROM szkoleniewykaz WHERE nazwa = '$szkolenie'");
                    $nazwapliku = 'resources/upowaznienia/upowaznienie' . $id . '-' . $imienazplik . '.' . $id_szkolenia . '.' . 'pdf';
                    $mpdf->Output($nazwapliku, 'F');
                    Mail::mailupowaznienie($imienaz, $plec, $email, $nazwapliku, $poziomzaswiadczenie, $kontakt, $bcc, $id);
                    //czas sesji zaswiadcza, ze funkcja zostala wykonana bez bledu do konca 
                    $czasbiezacy = date("Y-m-d H:i:s");
                    $id = $_SESSION['uczestnik']['id'];
                    R::exec("UPDATE  `uczestnicy` SET  `upowaznieniedata`='$czasbiezacy' WHERE  `uczestnicy`.`id` = '$id';");
                }
            }
        }
        echo "skonczylem generowac upowaznienie\r"."\r\n";
        ?>        
        <div class="box">
            <div class="slajd">
            <div id="testnaglowek">
                    <h2>Wygenerowano zaświadczenie id_<?=$_SESSION['uczestnik']['id']?>_id</h2>
                </div>
                <div class="pytanietest">
                  <p style="font-size: 150%; margin-left: 3%"> Gratulujemy ukończenia szkolenia przygotowanego przez</p>
                    <p style="font-size: 150%; margin-left: 3%"> ODO Management Group.</p>
                    <div style="padding: 3%; padding-top: 1%">
                        <p>Na adres email, którym logowaleś się do systemu e-szkoleń zostało właśnie wysłane zaświadczenie potwierdzające zaliczenie testu.</p>
                    </div>
                    <div style="padding: 3%;">
                        <p>Dziękujemy za skorzystanie z naszego systemu e-szkoleń.</p>
                        <p>Zespół ODO Management Group</p> 
                    </div>
                   
                </div>
            
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
