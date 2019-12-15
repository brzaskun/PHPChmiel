<?php

class Mail {

    public static function mailautomat($imienazwisko, $plec, $email, $szkolenieuser, $id_uzytkownik) {
        $email = trim($email);
        require_once 'resources/swiftmailer/swift_required.php';
        $poziomzaswiadczenie = Mail::pobierzPoziomZaswiadczenia($szkolenieuser, $plec);
        $instrukcja = R::getCell("SELECT instrukcja FROM szkoleniewykaz WHERE  nazwa = '$szkolenieuser'");
        $linia1 = Mail::pobierzLinia1Zaswiadczenia($szkolenieuser);
        // Create the Mailer using your created Transport 
        $mailer = Mail::mailerFactory();
        $logger = Mail::loggerFactory($mailer);
        // Create a message
        $message = Swift_Message::newInstance('Rejestracja do e-szkolenia ' . $linia1) 
                        ->setContentType('text/plain')
                        ->setFrom(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setReplyTo(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setTo(array($email => $imienazwisko));
        require_once('resources/php/MailText.php');
            if ($plec === "k") {
                $message->setBody(Mailtext::mailautomatKobieta($email, $instrukcja), 'text/html');
            } else {
                $message->setBody(Mailtext::mailautomatMezczyzna($email, $instrukcja), 'text/html');
            }
            // Send the message
            $failedRecipients = array();
            $numSent = 0;
            // Send the message
            $numSent = $mailer->send($message, $failedRecipients);
            if (stripos($logger->dump(), "250 OK id") == 0) {
                Mail::mailniewyslano($email,$logger, "rejestracja automatyczna");
                echo $email;
            } else if ($numSent == 1) {
                $sql = "UPDATE  `uczestnicy` SET  `wyslanymailupr` = '1' WHERE  `uczestnicy`.`id` = $id_uzytkownik;";
                $res = R::exec($sql);
                return "";
            }
    }
    
    public final static function pobierzPoziomZaswiadczenia($szkolenie, $plec) { 
        $czy_jest_zaswiadczenie = (int)R::getCell("SELECT id_zaswiadczenie FROM szkoleniewykaz WHERE nazwa = '$szkolenie'");
        $poziomzaswiadczenie = "";
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
    
     public final static function pobierzLinia1Zaswiadczenia($szkolenie) { 
        $czy_jest_zaswiadczenie = (int)R::getCell("SELECT id_zaswiadczenie FROM szkoleniewykaz WHERE nazwa = '$szkolenie'");
        $linia1 = "";
        if ($czy_jest_zaswiadczenie) {
            $linia1 = R::getCell("SELECT linia1 FROM zaswiadczenia WHERE id = '$czy_jest_zaswiadczenie'");
        }
        return $linia1;
    }
           
    public static function mailzaswiadczenie($imienazwisko, $plec, $email, $filename, $poziomzaswiadczenie, $bcc, $szkolenieuser, $id) {
        $kontakt = trim($kontakt);
        $wiadomosc = "nie";
        require_once 'resources/swiftmailer/swift_required.php';
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $linia1 = Mail::pobierzLinia1Zaswiadczenia($szkolenieuser);
            // Create the Mailer using your created Transport
            $mailer = Mail::mailerFactory();
            $logger = Mail::loggerFactory($mailer);
            require_once('resources/php/MailText.php');
            // Create a message
            $message = null;
            if ($plec === "k") {
                $message = Swift_Message::newInstance($imienazwisko.' - zaświadczenie ukończenia e-szkolenia - ' . $linia1)
                        ->setContentType('text/plain')
                        ->setFrom(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setReplyTo(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setTo(array($email => $imienazwisko))
                        ->setBcc($bcc);
                $message->setBody(Mailtext::mailzaswiadczenieKobieta($message, $poziomzaswiadczenie), 'text/html');
            } else {
                $message = Swift_Message::newInstance($imienazwisko.' - zaświadczenie ukończenia e-szkolenia - ' . $linia1)
                        ->setContentType('text/plain')
                        ->setFrom(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setTo(array($email => $imienazwisko))
                        ->setBcc($bcc)
                        ->setReplyTo(array('mail@odomg.com.pl' => 'ODO Management Group'));
                $message->setBody(Mailtext::mailzaswiadczenieMezczyzna($message, $poziomzaswiadczenie), 'text/html');
            }
            //zalacz plik
            $message->attach(Swift_Attachment::fromPath($filename));
            // Send the message
            $failedRecipients = array();
            $numSent = 0;
            // Send the message
            try {
                $numSent = $mailer->send($message, $failedRecipients);
            } catch(exception $ex) {
                echo $ex;
            }
            if (stripos($logger->dump(), "250 OK id") == 0) {
                $niewyslano = $failedRecipients[0];
                Mail::mailniewyslano($niewyslano, $logger, "ukończenie szkolenia");
            } 
            //else { nie mozn azrobic else bo sa fikcyjne adresy. ciagle usilowalby dostarczyc bez skutecznie
                $sql = "UPDATE uczestnicy SET wyslanycert = 1 WHERE id = '$id'";
                $res = R::exec($sql);
                $wiadomosc = "tak";
            //}
        }
        return $wiadomosc;
    }

    public static function mailupowaznienie($imienazwisko, $plec, $email, $filename, $poziomzaswiadczenie, $bcc, $id) {
        $kontakt = trim($kontakt);
//        $bcc = "brzaskun@o2.pl";
//        $kontakt = "Grzegorz";
        $wiadomosc = "nie";
        require_once 'resources/swiftmailer/swift_required.php';
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Create the Mailer using your created Transport
                $mailer = Mail::mailerFactory();
                $logger = Mail::loggerFactory($mailer);
                 require_once('resources/php/MailText.php');
                // Create a message
                $message = null;
                if ($plec === "k") {
                    $message = Swift_Message::newInstance($imienazwisko.' - upoważnienie do przetwarzania danych osobowych')
                            ->setContentType('text/plain')
                            ->setFrom(array('mail@odomg.com.pl' => 'ODO Management Group'))
                            ->setReplyTo(array('mail@odomg.com.pl' => 'ODO Management Group'))
                            ->setTo(array($email => $imienazwisko))
                            ->setBcc($bcc);
                    $message->setBody(Mailtext::mailzaupowaznienieKobieta($message), 'text/html');
                } else {

                    $message = Swift_Message::newInstance($imienazwisko.' - upoważnienie do przetwarzania danych osobowych')
                            ->setContentType('text/plain')
                            ->setFrom(array('mail@odomg.com.pl' => 'ODO Management Group'))
                            ->setTo(array($email => $imienazwisko))
                            ->setBcc($bcc)
                            ->setReplyTo(array('mail@odomg.com.pl' => 'ODO Management Group'));
                    $message->setBody(Mailtext::mailzaupowaznienieMezczyzna($message), 'text/html');
                }
                //zalacz plik
                $message->attach(Swift_Attachment::fromPath($filename));
                $failedRecipients = array();
                $numSent = 0;
                // Send the message 
                $numSent = $mailer->send($message, $failedRecipients);
                if (stripos($logger->dump(), "250 OK id") == 0) {
                    throw new Exception("Wystąpił błąd. Nie wysłano upoważnienia do użytkownika $email");
                } else if ($numSent > 0) {
                    $niewyslano = NULL;
                    $wiadomosc = "tak";
                    if ($numSent == 1) {
                        $niewyslano = $failedRecipients[0];
                        Mail::mailniewyslano($niewyslano,$logger, "wysyłka upoważnienia");
                    }
                    //else { nie mozn azrobic else bo sa fikcyjne adresy. ciagle usilowalby dostarczyc bez skutecznie
                        $sql = "UPDATE uczestnicy SET  wyslaneup = 1 WHERE id = '$id'";
                        $res = R::exec($sql);
                    //}
    //                if ($res == 1) {
    //                    throw new Exception("Wysłano mail z upoważnieniem na adres $email, ale nie udało się zaznaczyć tego w tabeli");
    //                }
                }
        }
        return $wiadomosc;
    }
    
    
     public static function mailupowaznienieDW($imienazwisko, $plec, $email, $filename, $poziomzaswiadczenie,$bcc, $id) {
        $kontakt = trim($kontakt);
//        $bcc = "brzaskun@o2.pl";
//        $kontakt = "Grzegorz";
        $wiadomosc = "nie";
        require_once 'resources/swiftmailer/swift_required.php';
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Create the Mailer using your created Transport
                $mailer = Mail::mailerFactory();
                $logger = Mail::loggerFactory($mailer);
                require_once('resources/php/MailText.php');
                // Create a message
                $message = null;
                if ($plec === "k") {
                    $message = Swift_Message::newInstance($imienazwisko.' - upoważnienie do przetwarzania danych osobowych')
                            ->setContentType('text/plain')
                            ->setFrom(array('mail@odomg.com.pl' => 'ODO Management Group'))
                            ->setReplyTo(array('mail@odomg.com.pl' => 'ODO Management Group'))
                            ->setTo(array($email => $imienazwisko))
                            ->setBcc($bcc);
                    $message->setBody(Mailtext::mailzaupowaznienieDWKobieta($message), 'text/html');
                } else {

                    $message = Swift_Message::newInstance($imienazwisko.' - upoważnienie do przetwarzania danych osobowych')
                            ->setContentType('text/plain')
                            ->setFrom(array('mail@odomg.com.pl' => 'ODO Management Group'))
                            ->setTo(array($email => $imienazwisko))
                            ->setBcc($bcc)
                            ->setReplyTo(array('mail@odomg.com.pl' => 'ODO Management Group'));
                    $message->setBody(Mailtext::mailzaupowaznienieDWMezczyzna($message), 'text/html');
                }
                //zalacz plik
                $message->attach(Swift_Attachment::fromPath($filename));
                $failedRecipients = array();
                $numSent = 0;
                // Send the message 
                $numSent = $mailer->send($message, $failedRecipients);
                if (stripos($logger->dump(), "250 OK id") == 0) {
                    throw new Exception("Wystąpił błąd. Nie wysłano upoważnienia do użytkownika $email");
                } else if ($numSent > 0) {
                    $niewyslano = NULL;
                    $wiadomosc = "tak";
                    if ($numSent == 1) {
                        $niewyslano = $failedRecipients[0];
                        Mail::mailniewyslano($niewyslano,$logger, "wysyłka upoważnienia");
                    } 
                    //else { nie mozn azrobic else bo sa fikcyjne adresy. ciagle usilowalby dostarczyc bez skutecznieelse {
                        $sql = "UPDATE uczestnicy SET  wyslaneupdanewrazliwe = 1 WHERE id = '$id'";
                        $res = R::exec($sql);
                    //}
    //                if ($res == 1) {
    //                    throw new Exception("Wysłano mail z upoważnieniem na adres $email, ale nie udało się zaznaczyć tego w tabeli");
    //                }
                }
        }
        return $wiadomosc;
    }
    
    private static function mailerFactory() {
//        $transport = Swift_SmtpTransport::newInstance('futurehost.pl', 465);
//        $transport->setEncryption('ssl');
//        $transport->setUsername('odomg@taxman.biz.pl');
//        $transport->setPassword('qwerty1234');
        $_SESSION['host'] = 'mysql:host=172.16.0.6;';
        //$_SESSION['host'] = 'mysql:host=localhost;';
        try {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Rb.php');
            R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
        } catch (Exception $e) {
            
        };
        $parametr = "id = 2";
        $dane = R::findOne('x', $parametr);
        $p = $dane->getProperties();
        $transport = Swift_SmtpTransport::newInstance($p['host'], $p['port'], $p['tryb']);
        $transport->setUsername($p['adres']);
        $transport->setPassword($p['pas']);
        // Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);
        // And specify a time in seconds to pause for (30 secs)
        //$mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(50, 90));
        return $mailer;
    }
    
    public static function loggerFactory($mailer) {
        // To use the ArrayLogger
        //The Logger plugins helps with debugging during the process of sending.
        // It can help to identify why an SMTP server is rejecting addresses, or any other hard-to-find problems that may arise.
        $logger = new Swift_Plugins_Loggers_ArrayLogger();
        $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));
        return $logger;
    }
    
    public static function mailniewyslano($niewyslano,$logger, $etap) {
        require_once 'resources/swiftmailer/swift_required.php';
            // Create the Mailer using your created Transport
            $mailer = Mail::mailerFactory();
            // Create a message 
            $message = Swift_Message::newInstance('Odo raport o błędach') 
                        ->setContentType('text/plain')
                        ->setFrom(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setReplyTo(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setTo(array("brzaskun@gmail.com" => "Grzegorz Grzelczyk"))
//                        ->setBcc(array("mchmielewska@interia.pl" => "Magdalena Chmielewska"))
                        ->setBody('<!DOCTYPE html><html lang="pl">
                        <head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
                        <link rel="stylesheet" href="/resources/css/zaswiadczenie.css"/></head><body>
                        <div style="text-align: left; font-size: 12pt; color: rgb(74,26,15);">'
                                . '<p> id: '.$_SESSION['uczestnik']['id'].'</p>'
                                . '<p> email zalogowanej osoby: '.$_SESSION['uczestnik']['email'].'</p>'
                                . '<p> szkolenie: '.$_SESSION['uczestnik']['nazwaszkolenia'].'</p>'
                                . '<p> etap: '.$etap.'</p>'
                                . '<p> nie wysłano maila do: '.$niewyslano.'</p>'
                                . '</div>
                        <div>
                        <span>treść loggera</span>
                        <p>'.$logger->dump().'</p>
                        </div>
                        </body></html>
                        ', 'text/html');
            $failedRecipients = array();
            $mailer->send($message, $failedRecipients);
    }
    
    public static function mailwyslanoawaryjnie($uzerywyslane) {
        require_once 'resources/swiftmailer/swift_required.php';
        $mailelista = "";
        $licznik = 1;
        foreach ($uzerywyslane as $value) {
            $mailelista = $mailelista." ".$licznik++.". ".$value['imienazwisko'].", ".$value['email'].", ".$value['nazwaszkolenia'].", ".$value['firma']."<br />\n";
        }
            // Create the Mailer using your created Transport
            $mailer = Mail::mailerFactory();
            // Create a message 
            $message = Swift_Message::newInstance('Wysłano automatycznie zaświadczenia i upoważnienia dla następujących osób') 
                        ->setContentType('text/plain')
                        ->setFrom(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setReplyTo(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setTo(array("brzaskun@gmail.com" => "Grzegorz Grzelczyk"))
//                        ->setBcc(array("mchmielewska@interia.pl" => "Magdalena Chmielewska"))
                        ->setBody('<!DOCTYPE html><html lang="pl">
                        <head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
                        <link rel="stylesheet" href="/resources/css/zaswiadczenie.css"/></head><body>
                        <div style="text-align: left; font-size: 12pt; color: rgb(74,26,15);">'
                                . '<p> ilosc maili '.sizeof($uzerywyslane).'</p>'
                                . '<p> maile '.$mailelista.'</p>'
                        . '</div>
                        </body></html>
                        ', 'text/html');
            $failedRecipients = array();
            $mailer->send($message, $failedRecipients);
    }
    
    public static function mailwyslanolinki($maile,$maileniewyslane) {
        require_once 'resources/swiftmailer/swift_required.php';
        $mailelista = "";
        $licznik = 1;
        foreach ($maile as $value) {
            $mailelista = $mailelista." ".$licznik++.". ".$value['imienazwisko'].", ".$value['email'].", ".$value['nazwaszkolenia']."<br />\n";
        }
        $mailelista2 = "";
        $licznik = 1;
        if (!empty($maileniewyslane)) {
            foreach ($maileniewyslane as $value) {
                $mailelista2 = $mailelista2." ".$licznik++.". ".$value['imienazwisko'].", ".$value['email'].", ".$value['nazwaszkolenia']."<br />\n";
            }
        }
            // Create the Mailer using your created Transport
            $mailer = Mail::mailerFactory();
            // Create a message 
            $message = Swift_Message::newInstance('Informacja o wysłanych linkach') 
                        ->setContentType('text/plain')
                        ->setFrom(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setReplyTo(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setTo(array("brzaskun@gmail.com" => "Grzegorz Grzelczyk"))
//                        ->setBcc(array("mchmielewska@interia.pl" => "Magdalena Chmielewska"))
                        ->setBody('<!DOCTYPE html><html lang="pl">
                        <head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
                        <link rel="stylesheet" href="/resources/css/zaswiadczenie.css"/></head><body>
                        <div style="text-align: left; font-size: 12pt; color: rgb(74,26,15);">'
                                . '<p> Udało się wysłać linki dla następujących liczby użytkowników '.sizeof($maile).'</p>'
                                . '<p> '.$mailelista.'</p>'
                        . '</div>
                        <div style="text-align: left; font-size: 12pt; color: rgb(74,26,15);">'
                                . '<p> Ilosc nieudanych wysyłek '.sizeof($maileniewyslane).'</p>'
                                . '<p> '.$mailelista2.'</p>'
                        . '</div>
                        </body></html>
                        ', 'text/html');
            $failedRecipients = array();
            $mailer->send($message, $failedRecipients);
    }
    
    public static function mailerror($error) {
        require_once 'resources/swiftmailer/swift_required.php';
            // Create the Mailer using your created Transport
            $mailer = Mail::mailerFactory();
            // Create a message 
            $message = Swift_Message::newInstance('Odo raport o błędach') 
                        ->setContentType('text/plain')
                        ->setFrom(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setReplyTo(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setTo(array("brzaskun@gmail.com" => "Grzegorz Grzelczyk"))
//                        ->setBcc(array("mchmielewska@interia.pl" => "Magdalena Chmielewska"))
                        ->setBody('<!DOCTYPE html><html lang="pl">
                        <head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
                        <link rel="stylesheet" href="/resources/css/zaswiadczenie.css"/></head><body>
                        <div style="text-align: left; font-size: 12pt; height: 200px; color: rgb(74,26,15);">'
                                . '<p> plik: '.$error->getFile().'</p>'
                                . '<p> wiersz: '.$error->getLine().'</p>'
                                . '<p> wiadomość '.$error->getMessage().'</p>'
                                . '<p> kod '.$error->getCode().'</p>'
                                . '<p> trace: '.$error->getTraceAsString().'</p>'
                                . '</div>'
                                . '<div style="text-align: left; font-size: 12pt; height: 350px; color: rgb(74,26,15);">'
                                . '<p> id: '.$_SESSION['uczestnik']['id'].'</p>'
                                . '<p> email zalogowanej osoby: '.$_SESSION['uczestnik']['email'].'</p>'
                                . '<p> szkolenie: '.$_SESSION['uczestnik']['nazwaszkolenia'].'</p>'
                                . '</div>
                        </body></html>
                        ', 'text/html');
            $failedRecipients = array();
            $mailer->send($message, $failedRecipients);
    }
        
    public static function mailerror2($error, $email, $szkolenie) {
        require_once 'resources/swiftmailer/swift_required.php';
            // Create the Mailer using your created Transport
            $mailer = Mail::mailerFactory();
            // Create a message 
            $message = Swift_Message::newInstance('Odo raport o błędach') 
                        ->setContentType('text/plain')
                        ->setFrom(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setReplyTo(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setTo(array("brzaskun@gmail.com" => "Grzegorz Grzelczyk"))
//                        ->setBcc(array("mchmielewska@interia.pl" => "Magdalena Chmielewska"))
                        ->setBody('<!DOCTYPE html><html lang="pl">
                        <head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
                        <link rel="stylesheet" href="/resources/css/zaswiadczenie.css"/></head><body>
                        <div style="text-align: left; font-size: 12pt; height: 200px; color: rgb(74,26,15);">'
                                . '<p> plik: '.$error->getFile().'</p>'
                                . '<p> wiersz: '.$error->getLine().'</p>'
                                . '<p> wiadomość '.$error->getMessage().'</p>'
                                . '<p> kod '.$error->getCode().'</p>'
                                . '<p> trace: '.$error->getTraceAsString().'</p>'
                                . '</div>'
                                . '<div style="text-align: left; font-size: 12pt; height: 350px; color: rgb(74,26,15);">'
                                . '<p> id: '.$_SESSION['uczestnik']['id'].'</p>'
                                . '<p> email zalogowanej osoby: '.$email.'</p>'
                                . '<p> szkolenie: '.$szkolenie.'</p>'
                                . '</div>
                        </body></html>
                        ', 'text/html');
            $failedRecipients = array();
            $mailer->send($message, $failedRecipients);
    }

    public static function mailautomattest($email) {
        $email = trim($email);
        require_once 'resources/swiftmailer/swift_required.php';
        // Create the Mailer using your created Transport 
        $mailer = Mail::mailerFactory();
        $logger = Mail::loggerFactory($mailer);
        require_once('resources/php/MailText.php');
        // Create a message
        $message = null;
        $message = Swift_Message::newInstance('Mail testowy do e-szkolenia') 
                        ->setContentType('text/plain')
                        ->setFrom(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setReplyTo(array('mail@odomg.com.pl' => 'ODO Management Group'))
                        ->setTo(array($email => $email))
                        ->setBody(Mailtext::mailautomattest(), 'text/html');
        // Send the message
        $failedRecipients = array();
        $numSent = 0;
        // Send the message
        $numSent = $mailer->send($message, $failedRecipients);
        if (stripos($logger->dump(), "250 OK id") == 0) {
            Mail::mailniewyslano($email,$logger, "rejestracja automatyczna");
            echo "<span style='color:red'>Błąd nie wysłano maila </span>".$logger->dump();
        } else if ($numSent == 1) {
            echo $logger->dump();
        }
    }
     
}

?>
