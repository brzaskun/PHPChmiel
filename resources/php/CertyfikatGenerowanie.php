<?php


class CertyfikatGenerowanie {
       
    public final static function generuj() {
        session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');
        if (session_status() != 2) {
            session_start();
        };
        try {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Rb.php');
            R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
        } catch (Exception $e) {
            
        };
        try {
            require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Mail.php');
        } catch (Exception $em) {
            
        }
        date_default_timezone_set('Europe/Warsaw');
        $wynik = false;
        try {
            $id = $_SESSION['uczestnik']['id'];
            if ($id > 0) {
                $stacjonarny = $_SESSION['uczestnik']['stacjonarny'];
                $email = $_SESSION['uczestnik']['email'];
                $szkolenie = $_SESSION['uczestnik']['nazwaszkolenia'];
                $uczestnik = $_SESSION['uczestnik'];
                $plec = $_SESSION['uczestnik']['plec'];
                $imienaz = $_SESSION['uczestnik']['imienazwisko'];
                $kontakt = "ODO Management Group";
                if (isset($_SESSION['uczestnik']['kontakt'])) {
                    $kontakt = $_SESSION['uczestnik']['kontakt'];
                }
                //$bcc = "brzaskun@o2.pl";
                $bcc = self::pobierzBCC();
                $datadozapisu = R::getCell("SELECT `sessionend` FROM `uczestnicy` WHERE  `uczestnicy`.`id` = '$id';");
                $datadozapisu = date('d.m.Y', strtotime($datadozapisu));
                $poziomzaswiadczenie = self::pobierzPoziomZaswiadczenia();
                $html = self::pobierzTrescZaswiadczenia($imienaz, $datadozapisu, $poziomzaswiadczenie);
                require_once($_SERVER['DOCUMENT_ROOT'].'/resources/MPDF57/mpdf.php');
                $mpdf = new mPDF();
                $mpdf->SetImportUse();
                $id_zaswiadczenie = (int)R::getCell("SELECT id_zaswiadczenie FROM szkoleniewykaz WHERE nazwa = '$szkolenie'");
                $pdf = R::getCell("SELECT pdf FROM zaswiadczenia WHERE id = '$id_zaswiadczenie'");
                if ($pdf) {
                    $pagecount = $mpdf->SetSourceFile('resources/css/pics/'.$pdf);
                } else {
                    $pagecount = $mpdf->SetSourceFile('resources/css/pics/zaswiadczenie1.pdf');
                }
                $tplId = $mpdf->ImportPage($pagecount);
                $mpdf->UseTemplate($tplId); 
                $mpdf->WriteHTML($html);
                require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/ConvertNames.php');
                $imienazplik = ConvertNames::cn($imienaz);
                $id_szkolenia = R::getCell("SELECT id FROM szkoleniewykaz WHERE nazwa = '$szkolenie'");
                $nazwapliku = 'resources/zaswiadczenia/zaswiadczenie'.$id.'-'.$imienazplik.'.'.$id_szkolenia.'-'.$stacjonarny.'.'.'pdf'; 
                $mpdf->Output($nazwapliku, 'F');
                Mail::mailzaswiadczenie($imienaz, $plec, $email, $nazwapliku, $poziomzaswiadczenie, $kontakt, $bcc, $szkolenie, $id);
                //czas sesji zaswiadcza, ze funkcja zostala wykonana bez bledu do konca 
                $czasbiezacy = date("Y-m-d H:i:s");
                $id = $_SESSION['uczestnik']['id'];
                R::exec("UPDATE  `uczestnicy` SET  `zaswiadczeniedata`='$czasbiezacy' WHERE  `uczestnicy`.`id` = '$id';");
                $wynik = true;
            }
        } catch (Exception $error) {
            $email = $_SESSION['uczestnik']['email'];
            $szkolenie = $_SESSION['uczestnik']['nazwaszkolenia'];
            Mail::mailerror2($error, $email, $szkolenie);
        }
        return $wynik;
    }
    
    public final static function pobierzBCC() {
        $bcc = "";
        $sqlfirma = $_SESSION['uczestnik']['firma_id'];
        $sql = "SELECT `email` FROM `zakladpracy` WHERE `zakladpracy`.`id`='$sqlfirma';";
        if (isset($sql)){
            $_SESSION['uczestnik']['BCC'] = R::getCell($sql);
        }
        if (isset($_SESSION['uczestnik']['BCC']) && !empty($_SESSION['uczestnik']['BCC'])) {
            $bcc = $_SESSION['uczestnik']['BCC'];
        }
        //email inny dla szkolenia ustawiany w firma-szkolenie 
        $szkolenie = $_SESSION['uczestnik']['nazwaszkolenia'];
        $firma = $_SESSION['uczestnik']['firma'];
        $sql = "SELECT email FROM szkolenieust WHERE szkolenieust.firma = '$firma' AND szkolenieust.nazwaszkolenia = '$szkolenie'";
        $email = R::getCell($sql);
        if (isset($email)) {
            $bcc = $email;
        }
        return $bcc;
    }

    public final static function pobierzPoziomZaswiadczenia() { 
        $poziomzaswiadczenie = "";
        $szkolenie = $_SESSION['uczestnik']['nazwaszkolenia'];
        $czy_jest_zaswiadczenie = (int)R::getCell("SELECT id_zaswiadczenie FROM szkoleniewykaz WHERE nazwa = '$szkolenie'");
        if ($czy_jest_zaswiadczenie) {
            $poziomzaswiadczenie = R::getCell("SELECT poziom FROM zaswiadczenia WHERE id = '$czy_jest_zaswiadczenie'");
        }
        switch ($szkolenie) {
            case 'szkolenie1' : 
                $poziomzaswiadczenie = "poziom BASIC";
                break;
            case 'szkolenie2' :
                $poziomzaswiadczenie = "poziom OPTIMUM";
                break;
            case 'szkolenie3' :
                $poziomzaswiadczenie = "poziom PREMIUM";
                break;
        }
        return $poziomzaswiadczenie;
    }
            
     public final static function pobierzPoziomZaswiadczeniaPodglad($nazwazaswiadczenia) {  
        $poziomzaswiadczenie = R::getCell("SELECT poziom FROM zaswiadczenia WHERE nazwa = '$nazwazaswiadczenia'");
        return $poziomzaswiadczenie;
    }
    
    public final static function pobierzTrescZaswiadczenia($imienaz,$dataukonczenia,$poziomzaswiadczenie) {
        $szkolenie = $_SESSION['uczestnik']['nazwaszkolenia'];
        $plec = $_SESSION['uczestnik']['plec'];
        $id_zaswiadczenia = (int)R::getCell("SELECT id_zaswiadczenie FROM szkoleniewykaz WHERE nazwa = '$szkolenie'");
        $html = "";
        if ($id_zaswiadczenia) {
            if ($plec == "m") {
                $html = R::getCell("SELECT trescM FROM zaswiadczenia WHERE id = '$id_zaswiadczenia'");
            } else {
                $html = R::getCell("SELECT trescK FROM zaswiadczenia WHERE id = '$id_zaswiadczenia'");
            }
            $html = str_replace('$imienaz' , $imienaz, $html);
            $html = str_replace('$dataukonczenia' , $dataukonczenia, $html);
            $html = str_replace('$poziomzaswiadczenie' , $poziomzaswiadczenie, $html);
        } else {
            $plec = $_SESSION['uczestnik']['plec'];
            if ($plec == "k") {
                $html = CertyfikatGenerowanie::trescK($imienaz,$dataukonczenia,$poziomzaswiadczenie);
            } else {
                $html = CertyfikatGenerowanie::trescM($imienaz,$dataukonczenia,$poziomzaswiadczenie);
            }
        }
        return $html;
    }
    
    public final static function pobierzTrescZaswiadczeniaPodglad($imienaz,$dataukonczenia,$poziomzaswiadczenie,$nazwazaswiadczenia) {
            $plec = $_SESSION['uczestnik']['plec'];
            $html = null;
            if ($plec == "k") {
                $html = R::getCell("SELECT trescK FROM zaswiadczenia WHERE nazwa = '$nazwazaswiadczenia'");
            } else {
                $html = R::getCell("SELECT trescM FROM zaswiadczenia WHERE nazwa = '$nazwazaswiadczenia'");
            }
            $html = str_replace('$imienaz' , $imienaz, $html);
            $html = str_replace('$dataukonczenia' , $dataukonczenia, $html);
            $html = str_replace('$poziomzaswiadczenie' , $poziomzaswiadczenie, $html);
        return $html;
    }
    
    private final static function trescM($imienaz,$dataukonczenia,$poziomzaswiadczenie) {
            return '<!DOCTYPE html><html lang="pl">'.
                    '<head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>' .
                    '<link rel="stylesheet" href="/resources/css/zaswiadczenie.css"/></head><body>' .
                    '<div style="text-align: center; height: 150px;"></div>' .
                    '<div style="text-align: center; font-size: 370%; height: 180px;">' .
                    '<span></span><span>' .
                    '</div>' .
                    '<div style="text-align: center; font-size: 30pt; height: 100px;">' .
                    '<p>Szanowny Pan</p><p>' . $imienaz . '</p>' .
                    '</div>' .
                    '<div style="text-align: center; font-size: 14pt; height: 250px;">' .
                    '<p>Ukończył dnia ' . $dataukonczenia . ' roku</p>' .
                    '<p style="font-weight: bold;">Szkolenie z Ochrony Danych Osobowych</p>' .
                    '<p style="font-weight: bold;">' . $poziomzaswiadczenie . '</p>' .
                    '</div>' .
                    '</body></html>';
    
    
    }
            
    private final static function trescK($imienaz,$dataukonczenia,$poziomzaswiadczenie) {
            return  '<!DOCTYPE html><html lang="pl">' .
                    '<head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>' .
                    '<link rel="stylesheet" href="/resources/css/zaswiadczenie.css"/></head><body>' .
                    '<div style="text-align: center; height: 150px;"></div>' .
                    '<div style="text-align: center; font-size: 370%; height: 180px;">' .
                    '<span></span><span>' .
                    '</div>' .
                    '<div style="text-align: center; font-size: 30pt; height: 100px;">' .
                    '<p>Szanowna Pani</p><p>' . $imienaz . '</p>' .
                    '</div>' .
                    '<div style="text-align: center; font-size: 14pt; height: 250px;">' .
                    '<p>Ukończyła dnia ' . $dataukonczenia . ' roku</p>' .
                    '<p style="font-weight: bold;">Szkolenie z Ochrony Danych Osobowych</p>' .
                    '<p style="font-weight: bold;">' . $poziomzaswiadczenie . '</p>' .
                    '</div>' .
                    '</body></html>';
    }
}
?>