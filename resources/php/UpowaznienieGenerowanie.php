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
class UpowaznienieGenerowanie {

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
        $niewyslano = (int)R::getCell("SELECT  `wyslaneup` FROM `uczestnicy` WHERE  `uczestnicy`.`id` = '$id';");
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
        $niewyslano = (int)R::getCell("SELECT  `wyslaneup` FROM `uczestnicy` WHERE  `uczestnicy`.`id` = '$id';");
        $email = $_SESSION['uczestnik']['email'];
        if ($niewyslano == 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
                    $bcc = UpowaznienieGenerowanie::pobierzBCC($kontakt);
                    //echo "adrez zbiorczy ".$bcc;
                    $nrupowaznienia = $_SESSION['uczestnik']['nrupowaznienia'];
                    $datanadania = R::getCell("SELECT  `datanadania` FROM `uczestnicy` WHERE  `uczestnicy`.`id` = '$id';");
                    $dataustania = $_SESSION['uczestnik']['dataustania'];
                    if ($dataustania == null || $dataustania == "") {
                        $firma_id = $_SESSION['uczestnik']['firma_id'];
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/FirmaNazwaToId.php');
                        $sqlfirma = FirmaNazwaToId::wyszukajNazwa($firma_id);
                        $nrupowaznienia = $_SESSION['uczestnik']['nrupowaznienia'];
                        $sql = "SELECT `miejscowosc` FROM `zakladpracy` WHERE `zakladpracy`.`id`='$firma_id';";
                        $miejscowosc = R::getCell($sql);
                        $sql = "SELECT `ulica` FROM `zakladpracy` WHERE `zakladpracy`.`id`='$firma_id';";
                        $ulica = R::getCell($sql);
                        require_once("resources/MPDF57/mpdf.php");
                        require_once('resources/php/UpowaznienieText.php');
                        if (strpos($sqlfirma, 'Sąd Rejonowy') !== false) {
                            $miejscowosc = substr($sqlfirma,16);
                            $szef = self::wersjaPrezes0Dyrektor1($id);
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
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/ConvertNames.php');
                        $imienazplik = ConvertNames::cn($imienaz);
                        $id_szkolenia = R::getCell("SELECT id FROM szkoleniewykaz WHERE nazwa = '$szkolenie'");
                        $nazwapliku = 'resources/upowaznienia/upowaznienie' . $id . '-' . $imienazplik . '.' . $id_szkolenia . '.' . 'pdf';
                        $mpdf->Output($nazwapliku, 'F');
                        Mail::mailupowaznienie($imienaz, $plec, $email, $nazwapliku, $poziomzaswiadczenie, $bcc, $id);
                        //czas sesji zaswiadcza, ze funkcja zostala wykonana bez bledu do konca 
                        $czasbiezacy = date("Y-m-d H:i:s");
                        $id = $_SESSION['uczestnik']['id'];
                        R::exec("UPDATE  `uczestnicy` SET  `upowaznieniedata`='$czasbiezacy' WHERE  `uczestnicy`.`id` = '$id';");
                        $wynik = true;
                    }
                }
            } catch (Exception $error) {
                Mail::mailerror($error);
            }
        }
        return $wynik;
    }
    
     public final static function pobierzBCC($kontakt) {
        session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
        if (session_status() != 2) {
            session_start();
        };
        $firma_id = $_SESSION['uczestnik']['firma_id'];
        $sql = "SELECT `email` FROM `zakladpracy` WHERE `zakladpracy`.`id`='$firma_id';";
        $bcc = R::getCell($sql);
        $_SESSION['uczestnik']['BCC'] = $bcc;
        $zwrot = array();
        $zwrot = array($bcc => $kontakt);
        $szkolenie = $_SESSION['uczestnik']['nazwaszkolenia'];
        $sql = "SELECT email FROM szkolenieust WHERE szkolenieust.firma_id = '$firma_id' AND szkolenieust.nazwaszkolenia = '$szkolenie'";
        $email2 = R::getCell($sql);
        if (isset($email2) && $email2!="") {
            $zwrot[$email2] = $kontakt;
        }
        return $zwrot;
    }

    public final static function pobierzgrupy($id) {
        $sql = "SELECT uczestnikgrupy.grupa FROM uczestnikgrupy WHERE id_uczestnik = '$id'  AND grupa!='dane szczególnej kategorii'";
        $zapisanegrupy = R::getCol($sql);
        $output = implode(", ",$zapisanegrupy);
        return $output;
    }
    
    public final static function wersjaPrezes0Dyrektor1($id) {
        $sql = "SELECT uczestnikgrupy.grupa FROM uczestnikgrupy WHERE id_uczestnik = '$id'  AND grupa!='dane szczególnej kategorii'";
        $zapisanegrupy = R::getCol($sql);
        $zapisanegrupy = mb_strtolower(trim($zapisanegrupy[0]),'UTF-8');
        $grupaPrezes = array("sędzia","referendarz sądowy","asystent sędziego","aplikant kuratorski","kurator zawodowy","starszy kurator zawodowy","ławnik","kurator społeczny","praktykant","kurator specjalny","dyrektor");
        $grupaDyrektor = array("sekretarz sądowy","starszy sekretarz sądowy","specjalista ds. administracyjnych i finansowych","administrator systemu informatycznego","główny księgowy","zastępca głównego księgowego","p.o. sekretarka","protokolant sądowy","woźny sadowy","sekretarka","sekretarz","specjalista ds. administracyjno-gospodarczych","kasjer","starszy inspektor","praktykant absolwencki","pracownik archiwum","informatyk");
        $output = "Prezes";
        if (in_array($zapisanegrupy, $grupaDyrektor)) {
            $output = "Dyrektor";
        }
        return $output;
    }
    
     
}
?>

