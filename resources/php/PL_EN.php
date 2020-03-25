<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PL_EN {
    static $idtabela = ["training1"];
    static $pytanie = ["Pytanie nr ","Question #"];
    static $dalej = ["dalej","next"];
    static $powrot = ["powrót","previous"];
    static $koniec_szkolenia = ["Zakończyłeś szkolenie. Moższe rozpocząć test. W tym celu kliknij poniżej","You finished the training. Start the test. To do this, click below."];
    static $koniec_test = ["Jesli chcesz mozesz teraz zakonczyc test i sprawdzic wynik. Klinknij poniżej","If you answered both questions you can now finish the test and check the result. Click below."];
    static $punkty_1 = ["punkty przyznane za zaznaczenie odp. poprawnych: ","points awarded for selecting correct answers: "];
    static $punkty_2 = ["punkty odjęte za zaznaczenie odp. niepoprawnych: ","points deducted for marking incorrect answers: "];
    static $punkty_3 = ["wynik końcowy - ilość uzyskanych punktów: ","final result - the number of points obtained: "];
    static $punkty_4 = ["maksymalna ilość punktów do uzyskania: ","maximum points to get: "];
    static $punkty_5 = ["zaliczyłeś test w: ","You passed the test in: "];
    static $punkty_6 = ["wyznaczony próg zdawalności: ","set pass rate: "];
    static $zaswiadczenie = ["zaświadczenie","certyficate"];
    static $powtorz = ["powtórz","repeat"];
    static $wyniktestu = ["wynik testu","test results"];
    static $wroc = ["wróc","back"];
    static $test = ["test","test"];
    static $gratulujemy = ["Gratulujemy ukończenia szkolenia przygotowanego przez","Congratulations on completing the training prepared by "];
    static $wygenerowanozaś = ["Wygenerowano zaświadczenie id_","Your certificate have been just generated id_"];
    static $wyslalismycert = ["Na adres email, którym logowaleś się do systemu e-szkoleń zostało właśnie wysłane zaświadczenie potwierdzające zaliczenie testu.","We have sent a certificate confirming passing the test to the email address you used to log into the e-training system"];
    static $dziekujemy1 = ["Dziękujemy za skorzystanie z naszego systemu e-szkoleń.","Thank you for using our e-learning system"];
    static $dziekujemy2 = ["Zespół ODO Management Group","ODO Management Group team"];
    static $nieaktywna = ["Usługa e-szkoleń dla twojej firmy jest juz nieaktywna.","Our e-learning service is not active for your company"];
    static $przekroczono1 = ["Przekroczono liczbę dopuszczalnych logowań do serwisu szkoleń.","The numbers of allowed logins to the training website has been exceeded"];
    static $przekroczono2 = ["Zgodnie z regulaminem szkoleń do serwisu można logować się maksymalnie 4 razy.","According to the training regulations, you can log in to the website up to 4 times."];
    static $przekroczono2a = ["Zgodnie z regulaminem szkoleń do serwisu można logować się w ciągu 24 godzin od czasu pierwszego zalogowania.","According to the training regulations, you can log in to the website within 24 hours of logging in for the first time."];
    static $przekroczono3 = ["Pierwsze zalogowanie z użyciem adresu ","The first login using this email "];
    static $przekroczono3a = [" miało miejsce "," took place "];
    static $przekroczono4 = ["Jeżeli dodatkowe logowania nastąpiły omyłkowo prosimy, w celu reaktywacji konta, skontaktować się z osobą odpowiedzialną za szkolenia.","If additional logins occurred by mistake, please contact the person responsible for training to reactivate your account"];
    static $przekroczono5 = ["W twojej firmie jest to: ","In your company it is: "];


    
    
    
    public static function wybierzjezyk ($sesja) {
        $zwrot = 0;
        if (in_array($sesja, self::$idtabela)) {
            $zwrot = 1;
        }
        return $zwrot;
    }
}