<?php

class Mailtext {
     public final static function mailautomatKobieta($email, $instrukcja) {
        $zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
        return '
         <h4>Dzień dobry,</h4>
        <div style="width: 550px; text-align: justify;">
        <p>Pani adres email został zarejestrowany w systemie e-learningu. </p>
        <p>Zapraszamy do wzięcia udziału w szkoleniu przygotowanym przez firmę ODO Management Group. 
        Szkolenie kończy się testem wielokrotnego wyboru. Po ukończeniu testu generowane jest stosowne zaświadczenie (plik PDF). 
        W przypadku niezaliczenia testu należy zalogować się jeszcze raz i ponownie przystąpić do szkolenia i do testu.</p>
        <p style="color: rgb(243,112,33);">Poniższy link pozostaje aktywny przez 24 godziny od momentu pierwszego zalogowania do systemu.</p>
        <p>Kliknij w ten link, aby rozpocząć <a href="https://szkolenie.odomg.pl/index.php?mail=' . urlencode($email) . '&' . $zm . '">SZKOLENIE</a> </p>
        <p><a href="https://szkolenie.odomg.pl/resources/css/pics/' . $instrukcja . '">instrukcja do e-szkolenia,</a></p>
         Wzięcie udziału w szkoleniu wymaga umieszczenia na komputerze użytkownika plików cookie.
         Rozpoczęcie szkolenia oznacza wyrażenie zgody na użycie plików cookie.</p>
		 <p>Wymagania systemowe umożliwiające prawidłowe funkcjonowanie programu: zainstalowany program Acrobat Reader (od wersji 10.0). <br/>
		 Rekomendowane przeglądarki: Chrome, Mozilla Firefox, Internet Explorer (w ostatnich wersjach)</p>
          
        <p>Powodzenia!</p>
        <p>Zespół ODO Management Group</p><br/>
        <p style="font-weight: bold;">Tę wiadomość wygenerowano automatycznie,  prosimy na nią nie odpowiadać.</p>
        </div>
    ';
    }

    public final static function mailautomatMezczyzna($email, $instrukcja) {
        return '
        <h4>Dzień dobry,</h4>
        <div style="width: 550px; text-align: justify;">
        <p>Pana adres email został zarejestrowany w systemie e-learningu. </p>
        <p>Zapraszamy do wzięcia udziału w szkoleniu przygotowanym przez firmę ODO Management Group. 
        Szkolenie kończy się testem wielokrotnego wyboru. Po ukończeniu testu generowane jest stosowne zaświadczenie (plik PDF). 
        W przypadku niezaliczenia testu należy zalogować się jeszcze raz i ponownie przystąpić do szkolenia i do testu.</p>
        <p style="color: rgb(243,112,33);">Poniższy link pozostaje aktywny przez 24 godziny od momentu pierwszego zalogowania do systemu.</p>
        <p>Kliknij w ten link, aby rozpocząć <a href="https://szkolenie.odomg.pl/index.php?mail=' . urlencode($email) . '&' . $zm . '">SZKOLENIE</a> </p>
        <p><a href="https://szkolenie.odomg.pl/resources/css/pics/' . $instrukcja . '">instrukcja do e-szkolenia,</a></p>
         Wzięcie udziału w szkoleniu wymaga umieszczenia na komputerze użytkownika plików cookie.
         Rozpoczęcie szkolenia oznacza wyrażenie zgody na użycie plików cookie.</p>
		 <p>Wymagania systemowe umożliwiające prawidłowe funkcjonowanie programu: zainstalowany program Acrobat Reader (od wersji 10.0). <br/>
		 Rekomendowane przeglądarki: Chrome, Mozilla Firefox, Internet Explorer (w ostatnich wersjach)</p>
        <p>Powodzenia!</p>
        <p>Zespół ODO Management Group</p><br/>
        <p style="font-weight: bold;">Tę wiadomość wygenerowano automatycznie,  prosimy na nią nie odpowiadać.</p>
        </div>
    ';
    }
    
    public final static function mailzaswiadczenieKobieta($message, $poziomzaswiadczenie) {
        $zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
        return '
                    <!DOCTYPE html><html lang="pl">
                    <head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
                    <link rel="stylesheet" href="/resources/css/zaswiadczenie.css"/></head><body>
                    <div style="text-align: left; font-size: 12pt; height: 250px; color: rgb(74,26,15);">
                    <p>Dzień dobry.</p>
                    <p>Gratulujemy ukończenia szkolenia ' . $poziomzaswiadczenie . '</p>
                    <p>przygotowanego przez ODO Management Group.</p>
                    <p>W załączniku tej wiadomości znajduje się zaświadczenie (plik PDF) potwierdzające zaliczenie testu.</p>
                    <br/>
                    <p>Dziękujemy za skorzystanie z naszego systemu e-szkoleń.</p>
                    <p>Zespół ODO Management Group</p><br/>
                    <img src="' . // Embed the file
                $message->embed(Swift_Image::fromPath($_SERVER['DOCUMENT_ROOT'] . '/resources/css/pics/ODOLogoVector.png')) .
                '" width="93" height="61"><span style="margin-left: 5px; color: white;">a</span>
                    <img src="' . // Embed the file
                $message->embed(Swift_Image::fromPath($_SERVER['DOCUMENT_ROOT'] . '/resources/css/pics/ODOLogoVector1.png')) .
                '" width="152" height="32" margin-left="5">
                    <p style="font-weight: bold; font-size: smaller;">Tę wiadomość wygenerowano automatycznie,  prosimy na nią nie odpowiadać.</p>
                    </div>
                    <div style="height: 40px;">
                    </div>
                    </body></html> 
                ';
    }

    public final static function mailzaswiadczenieMezczyzna($message, $poziomzaswiadczenie) {
        $zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
        return '
                    <!DOCTYPE html><html lang="pl">
                    <head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
                    <link rel="stylesheet" href="/resources/css/zaswiadczenie.css"/></head><body>
                    <div style="text-align: left; font-size: 12pt; height: 250px; color: rgb(74,26,15);">
                    <p>Dzień dobry.</p>
                     <p>Gratulujemy ukończenia szkolenia ' . $poziomzaswiadczenie . '</p>
                    <p>przygotowanego przez ODO Management Group.</p>
                    <p>W załączniku tej wiadomości znajduje się zaświadczenie (plik PDF) potwierdzające zaliczenie testu.</p>
                    <br/>
                    <p>Dziękujemy za skorzystanie z naszego systemu e-szkoleń.</p>
                    <p>Zespół ODO Management Group</p><br/>
                    <img src="' . // Embed the file
                $message->embed(Swift_Image::fromPath($_SERVER['DOCUMENT_ROOT'] . '/resources/css/pics/ODOLogoVector.png')) .
                '" width="93" height="61"><span style="margin-left: 5px; color: white;">a</span>
                    <img src="' . // Embed the file
                $message->embed(Swift_Image::fromPath($_SERVER['DOCUMENT_ROOT'] . '/resources/css/pics/ODOLogoVector1.png')) .
                '" width="152" height="32">
                    <p style="font-weight: bold; font-size: smaller;">Tę wiadomość wygenerowano automatycznie,  prosimy na nią nie odpowiadać.</p>
                    </div>
                    <div style="height: 40px;">
                    </div>
                    </body></html>
                ';
    }
    
    public final static function mailzaupowaznienieKobieta($message) {
        $zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
        return '
            <!DOCTYPE html><html lang="pl">
            <head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
            <link rel="stylesheet" href="/resources/css/zaswiadczenie.css"/></head><body>
            <div style="text-align: left; font-size: 12pt; height: 250px; color: rgb(74,26,15);">
            <p>Dzień dobry.</p>
            <p>W załączniku tej wiadomości znajduje się upoważnienie do przetwarzania danych osobowych (plik PDF), należy je niezwłocznie wydrukować oraz podpisać w miejscu oznaczonym i przekazać przełożonemu lub innej osobie zgodnie z przyjętą w twojej firmie procedurą nadawania upoważnień.</p>
            <br/>
            <p>Dziękujemy za skorzystanie z naszego systemu e-szkoleń.</p>
            <p>Zespół ODO Management Group</p><br/>
            <img src="' . // Embed the file
                            $message->embed(Swift_Image::fromPath($_SERVER['DOCUMENT_ROOT'] . '/resources/css/pics/ODOLogoVector.png')) .
                            '" width="93" height="61"><span style="margin-left: 5px; color: white;">a</span>
            <img src="' . // Embed the file
                            $message->embed(Swift_Image::fromPath($_SERVER['DOCUMENT_ROOT'] . '/resources/css/pics/ODOLogoVector1.png')) .
                            '" width="152" height="32" margin-left="5">
            <p style="font-weight: bold; font-size: smaller;">Tę wiadomość wygenerowano automatycznie,  prosimy na nią nie odpowiadać.</p>
            </div>
            <div style="height: 40px;">
            </div>
            </body></html> 
        ';
    }
    
     public final static function mailzaupowaznienieMezczyzna($message) {
        $zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
        return '
            <!DOCTYPE html><html lang="pl">
            <head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
            <link rel="stylesheet" href="/resources/css/zaswiadczenie.css"/></head><body>
            <div style="text-align: left; font-size: 12pt; height: 250px; color: rgb(74,26,15);">
            <p>Dzień dobry.</p>
            <p>W załączniku tej wiadomości znajduje się upoważnienie do przetwarzania danych osobowych (plik PDF), należy je niezwłocznie wydrukować oraz podpisać w miejscu oznaczonym i przekazać przełożonemu lub innej osobie zgodnie z przyjętą w twojej firmie procedurą nadawania upoważnień.</p>
            <br/>
            <p>Dziękujemy za skorzystanie z naszego systemu e-szkoleń.</p>
            <p>Zespół ODO Management Group</p><br/>
            <img src="' . // Embed the file
                            $message->embed(Swift_Image::fromPath($_SERVER['DOCUMENT_ROOT'] . '/resources/css/pics/ODOLogoVector.png')) .
                            '" width="93" height="61"><span style="margin-left: 5px; color: white;">a</span>
            <img src="' . // Embed the file
                            $message->embed(Swift_Image::fromPath($_SERVER['DOCUMENT_ROOT'] . '/resources/css/pics/ODOLogoVector1.png')) .
                            '" width="152" height="32">
            <p style="font-weight: bold; font-size: smaller;">Tę wiadomość wygenerowano automatycznie,  prosimy na nią nie odpowiadać.</p>
            </div>
            <div style="height: 40px;">
            </div>
            </body></html>
        ';
     }
     
      public final static function mailzaupowaznienieDWKobieta($message) {
        $zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
        return'
            <!DOCTYPE html><html lang="pl">
            <head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
            <link rel="stylesheet" href="/resources/css/zaswiadczenie.css"/></head><body>
            <div style="text-align: left; font-size: 12pt; height: 250px; color: rgb(74,26,15);">
            <p>Dzień dobry.</p>
            <p>W załączniku tej wiadomości znajduje się upoważnienie do przetwarzania danych osobowych (plik PDF), należy je niezwłocznie wydrukować oraz podpisać w miejscu oznaczonym i przekazać przełożonemu lub innej osobie zgodnie z przyjętą w twojej firmie procedurą nadawania upoważnień.</p>
            <br/>
            <p>Dziękujemy za skorzystanie z naszego systemu e-szkoleń.</p>
            <p>Zespół ODO Management Group</p><br/>
            <img src="' . // Embed the file
                            $message->embed(Swift_Image::fromPath($_SERVER['DOCUMENT_ROOT'] . '/resources/css/pics/ODOLogoVector.png')) .
                            '" width="93" height="61"><span style="margin-left: 5px; color: white;">a</span>
            <img src="' . // Embed the file
                            $message->embed(Swift_Image::fromPath($_SERVER['DOCUMENT_ROOT'] . '/resources/css/pics/ODOLogoVector1.png')) .
                            '" width="152" height="32" margin-left="5">
            <p style="font-weight: bold; font-size: smaller;">Tę wiadomość wygenerowano automatycznie,  prosimy na nią nie odpowiadać.</p>
            </div>
            <div style="height: 40px;">
            </div>
            </body></html> 
        ';
      }

      public final static function mailzaupowaznienieDWMezczyzna($message) {
        $zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
        return'
            <!DOCTYPE html><html lang="pl">
            <head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
            <link rel="stylesheet" href="/resources/css/zaswiadczenie.css"/></head><body>
            <div style="text-align: left; font-size: 12pt; height: 250px; color: rgb(74,26,15);">
            <p>Dzień dobry.</p>
            <p>W załączniku tej wiadomości znajduje się upoważnienie do przetwarzania danych osobowych (plik PDF), należy je niezwłocznie wydrukować oraz podpisać w miejscu oznaczonym i przekazać przełożonemu lub innej osobie zgodnie z przyjętą w twojej firmie procedurą nadawania upoważnień.</p>
            <br/>
            <p>Dziękujemy za skorzystanie z naszego systemu e-szkoleń.</p>
            <p>Zespół ODO Management Group</p><br/>
            <img src="' . // Embed the file
                            $message->embed(Swift_Image::fromPath($_SERVER['DOCUMENT_ROOT'] . '/resources/css/pics/ODOLogoVector.png')) .
                            '" width="93" height="61"><span style="margin-left: 5px; color: white;">a</span>
            <img src="' . // Embed the file
                            $message->embed(Swift_Image::fromPath($_SERVER['DOCUMENT_ROOT'] . '/resources/css/pics/ODOLogoVector1.png')) .
                            '" width="152" height="32">
            <p style="font-weight: bold; font-size: smaller;">Tę wiadomość wygenerowano automatycznie,  prosimy na nią nie odpowiadać.</p>
            </div>
            <div style="height: 40px;">
            </div>
            </body></html>
        ';
      }
      
      public final static function mailautomattest() {
        $zm = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));
        return'
         <h4>Dzień dobry,</h4>
        <div style="width: 550px; text-align: justify;">
        <p>To jest mail tetsowy wysłany w celu sprawdzenia, czy firma została właściwie skonfigurowana</p>
        <p>Zapraszamy do wzięcia udziału w szkoleniu przygotowanym przez firmę ODO Management Group. 
        Szkolenie kończy się testem wielokrotnego wyboru. Po ukończeniu testu generowane jest stosowne zaświadczenie (plik PDF). 
        W przypadku niezaliczenia testu należy zalogować się jeszcze raz i ponownie przystąpić do szkolenia i do testu.</p>
        Wzięcie udziału w szkoleniu wymaga umieszczenia na komputerze użytkownika plików cookie.
         Rozpoczęcie szkolenia oznacza wyrażenie zgody na użycie plików cookie.</p>
        <p>Wymagania systemowe umożliwiające prawidłowe funkcjonowanie programu: zainstalowany program Acrobat Reader (od wersji 10.0). <br/>
        Rekomendowane przeglądarki: Chrome, Mozilla Firefox, Internet Explorer (w ostatnich wersjach)</p>
        <p>Powodzenia!</p>
        <p>Zespół ODO Management Group</p><br/>
        <p style="font-weight: bold;">Tę wiadomość wygenerowano automatycznie,  prosimy na nią nie odpowiadać.</p>
        </div>
      ';
        
      }
      
}

?>
