<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Zerowanieciastek
 *
 * @author Osito
 */
class UpowaznienieDWGenerowanie {

    public final static function sprawdzupo() {
        session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
        if (session_status() != 2) {
            session_start();
        };
        try {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Rb.php');
                R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
        } catch (exception $e) {};
        $id = $_SESSION['uczestnik']['id'];
        date_default_timezone_set('Europe/Warsaw');
        $niewyslano = (int)R::getCell("SELECT  `wyslaneupdanewrazliwe` FROM `uczestnicy` WHERE  `uczestnicy`.`id` = '$id';");
        $email = $_SESSION['uczestnik']['email'];
        if ($niewyslano == 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                $grupy = self::pobierzgrupy($id);
                if (strlen($grupy) > 0) {
                    return "true";
                } else {
                    return "false";
                }
            } catch (Exception $em) {
                
            }
        }
    }
    
    
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
        $wynik = false;
        $id = $_SESSION['uczestnik']['id'];
        date_default_timezone_set('Europe/Warsaw');
        $wyslanoupowaz = (int)R::getCell("SELECT  `wyslaneup` FROM `uczestnicy` WHERE  `uczestnicy`.`id` = '$id';");
        $niewyslano = (int)R::getCell("SELECT  `wyslaneupdanewrazliwe` FROM `uczestnicy` WHERE  `uczestnicy`.`id` = '$id';");
        $email = $_SESSION['uczestnik']['email'];
        if ($wyslanoupowaz==1 && $niewyslano == 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Mail.php'); 
            } catch (Exception $em) {
                
            }
            try {
                $grupy = self::pobierzgrupy($id);
                if (strlen($grupy) > 0) {
                    $uczestnik = $_SESSION['uczestnik'];
                    $szkolenie = $_SESSION['uczestnik']['nazwaszkolenia'];
                    $plec = $_SESSION['uczestnik']['plec'];
                    $imienaz = $_SESSION['uczestnik']['imienazwisko'];
                    $kontakt = "ODO Management Group";
                    if (isset($_SESSION['uczestnik']['kontakt'])) {
                        $kontakt = $_SESSION['uczestnik']['kontakt'];
                    }
                    $bcc = UpowaznienieDWGenerowanie::pobierzBCC($kontakt);
                    //echo "adrez zbiorczy ".$bcc;
                    $nrupowaznienia = $_SESSION['uczestnik']['nrupowaznienia'];
                    if ($nrupowaznienia!="") {
                        $pocz = substr($nrupowaznienia,0,3);
                        $koniec = substr($nrupowaznienia,2);
                        $nrupowaznienia = $pocz."DSK".$koniec;
                    }
                    $datanadania = R::getCell("SELECT  `datanadaniadsk` FROM `uczestnicy` WHERE  `uczestnicy`.`id` = '$id';");
                    $dataustania = $_SESSION['uczestnik']['dataustania'];
                    if ($dataustania == null || $dataustania == "") {
                        $firma_id = $_SESSION['uczestnik']['firma_id'];
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/FirmaNazwaToId.php');
                        $sqlfirma = FirmaNazwaToId::wyszukajNazwa($firma_id);
                        $sql = "SELECT `miejscowosc` FROM `zakladpracy` WHERE `zakladpracy`.`id`='$firma_id';";
                        $miejscowosc = R::getCell($sql);
                        $sql = "SELECT `ulica` FROM `zakladpracy` WHERE `zakladpracy`.`id`='$firma_id';";
                        $ulica = R::getCell($sql);
                        require_once($_SERVER['DOCUMENT_ROOT'].'/resources/MPDF57/mpdf.php');
                        require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/UpowaznienieDWText.php');
                        if ($plec == "k") {
                            $html = UpowaznienieDWText::upowaznienie_kobieta_old($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy);
                        } else {
                            $html = UpowaznienieDWText::upowaznienie_mezczyzna_old($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy);
                        }
                        $mpdf = new mPDF();
                        $mpdf->WriteHTML($html);
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/ConvertNames.php');
                        $imienazplik = ConvertNames::cn($imienaz);
                        $id_szkolenia = R::getCell("SELECT id FROM szkoleniewykaz WHERE nazwa = '$szkolenie'");
                        $nazwapliku = 'resources/upowaznienia/upowaznienieDW' . $id . '-' . $imienazplik . '.' . $id_szkolenia . '.' . 'pdf';
                        $mpdf->Output($nazwapliku, 'F');
                        Mail::mailupowaznienieDW($imienaz, $plec, $email, $nazwapliku, $poziomzaswiadczenie, $bcc, $id);
                        //czas sesji zaswiadcza, ze funkcja zostala wykonana bez bledu do konca 
                        $czasbiezacy = date("Y-m-d H:i:s");
                        $id = $_SESSION['uczestnik']['id'];
                        R::exec("UPDATE  `uczestnicy` SET `wyslaneupdanewrazliwe`=1, `upowaznieniedwdata`='$czasbiezacy' WHERE  `uczestnicy`.`id` = '$id';");
                        $wynik = true;
                    }
                }
            } catch (Exception $error) {
                Mail::mailerror($error);
            }
        }
        return $wynik;
    }
    
   public final static function pobierzBCC() {
        session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
        if (session_status() != 2) {
            session_start();
        };
        $firma_id = $_SESSION['uczestnik']['firma_id'];
        $sql = "SELECT `email` FROM `zakladpracy` WHERE `zakladpracy`.`id`='$firma_id';";
        $bcc = R::getCell($sql);
        $firma_id = $_SESSION['uczestnik']['firma_id'];
        $_SESSION['uczestnik']['BCC'] = $bcc;
        $zwrot = array();
        $zwrot = array($bcc => $kontakt);
        $szkolenie = $_SESSION['uczestnik']['nazwaszkolenia'];
        $firma = $_SESSION['uczestnik']['firma'];
        $sql = "SELECT email FROM szkolenieust WHERE szkolenieust.firma_id = '$firma_id' AND szkolenieust.nazwaszkolenia = '$szkolenie'";
        $email2 = R::getCell($sql);
        if (isset($email2) && $email2!="") {
            $zwrot[$email2] = $kontakt;
        }
        return $zwrot;
    }

    public final static function pobierzgrupy($id) {
        $sql = "SELECT uczestnikgrupy.grupa FROM uczestnikgrupy WHERE id_uczestnik = '$id' AND grupa='dane szczególnej kategorii'";
        $zapisanegrupy = R::getCol($sql);
        $output = mb_strtolower(implode(", ",$zapisanegrupy),'UTF-8');
        return $output;
    }
    
     
}
?>

