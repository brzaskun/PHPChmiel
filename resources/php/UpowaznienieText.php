<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UpowaznienieText {
       
    public final static function upowaznienie_kobieta_old($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy) {
        return '<!DOCTYPE html><html lang="pl">' .
                '<head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>' .
                '<link rel="stylesheet" href="/resources/css/upowaznienie.css"/></head><body>' .
                '<p align="center"><b>UPOWAŻNIENIE nr ' . $nrupowaznienia . '</p>' .
                '<p align="center"><b>do przetwarzania danych osobowych<br/>' .
                '<p align="center"> w <span>' . $sqlfirma . ' z siedzibą w ' . $miejscowosc . ' ' . $ulica . '</span></p>' .
                '<p></p>' .
                '<p>Działając na podstawie art. 29 Rozporządzenia Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (ogólne rozporządzenie o ochronie danych) (Dz. U. UE. L. z 2016 r. Nr 119, str. 1), zwanego dalej "Rozporządzeniem", Administrator informuje, że:</p>' .
                '<p></p>' .
                '<p style="font-size: large;">z dniem ' . $datanadania . 'r.</p>' .
                '<p style="font-size: large;">Pani ' . $imienaz . '</p>' .
                '<p>zostaje upoważniona do przetwarzania danych osobowych, których Administratorem w rozumieniu art. 4 pkt 7 Rozporządzenia jest '. $sqlfirma .'.</p>' .
                '<p>Upoważnienie dotyczy przetwarzania danych osobowych w ramach następujących zbiorów danych osobowych z wykorzystaniem określonego sposobu dostępu do danych:</p>' .
                '<p><b>' . $grupy . '</b></p>' .
                '<p><b>wyłącznie w zakresie wynikającym z poleceń przełożonego (Administratora).</b></p>' .
                '<p align="justify">Upoważnienie traci ważność z chwilą jego cofnięcia lub ustania stosunku umownego wiążącego upoważnionego z administratorem danych.</p>' .
                '<p></p>' .
                '<p>Ja niżej podpisana zostałam zapoznana z dokumentacją przetwarzania i ochrony danych osobowych obowiązujących w '.$sqlfirma.' w tym z procedurą zgłaszania naruszeń i incydentów oraz zobowiązuję się do bezterminowego zachowania w tajemnicy danych osobowych, wszelkich procedur, zabezpieczeń i innych informacji i danych pozyskanych podczas świadczenia pracy / współpracy w tym po ustaniu stosunku umownego. </p>' .
                '<p></p>' .
                '<p>...................................................</p>' .
                '<p><i> podpis osoby otrzymującej upoważnienie</i></p>' .
                '</body></html>';
    }
    
    public final static function upowaznienie_mezczyzna_old($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy) {
        return '<!DOCTYPE html><html lang="pl">' .
                '<head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>' .
                '<link rel="stylesheet" href="/resources/css/upowaznienie.css"/></head><body>' .
                '<p align="center"><b>UPOWAŻNIENIE nr ' . $nrupowaznienia . '</p>' .
                '<p align="center"><b>do przetwarzania danych osobowych<br/>' .
                '<p align="center"> w <span>' . $sqlfirma . ' z siedzibą w ' . $miejscowosc . ' ' . $ulica . '</span></p>' .
                '<p></p>' .
                '<p>Działając na podstawie art. 29 Rozporządzenia Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (ogólne rozporządzenie o ochronie danych) (Dz. U. UE. L. z 2016 r. Nr 119, str. 1), zwanego dalej "Rozporządzeniem", Administrator informuje, że:</p>' .
                '<p></p>' .
                '<p style="font-size: large;">z dniem ' . $datanadania . 'r.</p>' .
                '<p style="font-size: large;">Pan ' . $imienaz . '</p>' .
                '<p>zostaje upoważniony do przetwarzania danych osobowych, których Administratorem w rozumieniu art. 4 pkt 7 Rozporządzenia jest '. $sqlfirma .'.</p>' .
                '<p>Upoważnienie dotyczy przetwarzania danych osobowych w ramach następujących zbiorów danych osobowych z wykorzystaniem określonego sposobu dostępu do danych:</p>' .
                '<p><b>' . $grupy . '</b></p>' .
                '<p><b>wyłącznie w zakresie wynikającym z poleceń przełożonego (Administratora).</b></p>' .
                '<p align="justify">Upoważnienie traci ważność z chwilą jego cofnięcia lub ustania stosunku umownego wiążącego upoważnionego z administratorem danych.</p>' .
                '<p></p>' .
                '<p>Ja niżej podpisany zostałem zapoznany z dokumentacją przetwarzania i ochrony danych osobowych obowiązujących w '.$sqlfirma.' w tym z procedurą zgłaszania naruszeń i incydentów oraz zobowiązuję się do bezterminowego zachowania w tajemnicy danych osobowych, wszelkich procedur, zabezpieczeń i innych informacji i danych pozyskanych podczas świadczenia pracy / współpracy w tym po ustaniu stosunku umownego. </p>' .
                '<p></p>' .
                '<p>...................................................</p>' .
                '<p><i> podpis osoby otrzymującej upoważnienie</i></p>' .
                '</body></html>';
    }
    
     public final static function upowaznienie_kobieta_SR($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy, $szef) {
        return '<!DOCTYPE html><html lang="pl">' .
                '<head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>' .
                '<link rel="stylesheet" href="/resources/css/upowaznienie.css"/></head><body>' .
                '<p></p>' .
                '<p></p>' .
                '<p align="center"><b>UPOWAŻNIENIE ' . $nrupowaznienia . '</p>' .
                '<p align="center">do przetwarzania danych osobowych<br/>' .
                '<p align="center"><b> w Sądzie Rejonowym w '.$miejscowosc.'</b></p>' .
                '<p></p>' .
                '<p>Działając na podstawie art. 29 Rozporządzenia Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (ogólne rozporządzenie o ochronie danych) (Dz. U. UE. L. z 2016 r. Nr 119, str. 1), zwanego dalej "Rozporządzeniem", Administrator <b>informuje, że:</b></p>' .
                '<p></p>' .
                '<p style="font-size: larger;">z dniem ' . $datanadania . 'r.</p>' .
                '<p style="font-size: larger;">Pani ' . $imienaz . '</p>' .
                '<p style="font-size: larger;">zatrudniona na stanowisku: ' . $grupy . '</p>' .
                '<p>zostaje upoważniona do przetwarzania danych osobowych, których Administratorem w rozumieniu art. 4 pkt 7 Rozporządzenia jest '.$szef.' Sądu Rejonowego w '.$miejscowosc.'.</p>' .
                '<p align="justify">Upoważnienie dotyczy przetwarzania danych osobowych w ramach otrzymanego zakresu obowiązków, odpowiedzialności i uprawnień  oraz  w zakresie wynikającym z poleceń przełożonego.</p>' .
                '<p></p>' .
                '<p align="justify">Upoważnienie traci ważność z chwilą jego cofnięcia lub ustania stosunku umownego wiążącego upoważnionego z administratorem danych.</p>' .
                '<p></p>' .
                '<p>Ja niżej podpisana zostałam zapoznana z dokumentacją przetwarzania i ochrony danych osobowych obowiązujących w Sądzie Rejonowym w '.$miejscowosc.' w tym z procedurą zgłaszania naruszeń i incydentów oraz zobowiązuję się do bezterminowego zachowania w tajemnicy danych osobowych, wszelkich procedur, zabezpieczeń i innych informacji i danych pozyskanych podczas świadczenia pracy / współpracy w tym po ustaniu stosunku umownego. </p>' .
                '<p></p>' .
                '<p align="right">...................................................</p>' .
                '<p align="right"> podpis osoby otrzymującej upoważnienie</p>' .
                '</body></html>';
    }
    
     public final static function upowaznienie_mezczyzna_SR($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy, $szef) {
        return '<!DOCTYPE html><html lang="pl">' .
                '<head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>' .
                '<link rel="stylesheet" href="/resources/css/upowaznienie.css"/></head><body>' .
                '<p></p>' .
                '<p></p>' .
                '<p align="center"><b>UPOWAŻNIENIE ' . $nrupowaznienia . '</p>' .
                '<p align="center">do przetwarzania danych osobowych<br/>' .
                '<p align="center"><b> w Sądzie Rejonowym w '.$miejscowosc.'</b></p>' .
                '<p></p>' .
                '<p>Działając na podstawie art. 29 Rozporządzenia Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (ogólne rozporządzenie o ochronie danych) (Dz. U. UE. L. z 2016 r. Nr 119, str. 1), zwanego dalej "Rozporządzeniem", Administrator <b>informuje, że:</b></p>' .
                '<p></p>' .
                '<p style="font-size: larger;">z dniem ' . $datanadania . 'r.</p>' .
                '<p style="font-size: larger;">Pan ' . $imienaz . '</p>' .
                '<p style="font-size: larger;">zatrudniony na stanowisku: ' . $grupy . '</p>' .
                '<p>zostaje upoważniony do przetwarzania danych osobowych, których Administratorem w rozumieniu art. 4 pkt 7 Rozporządzenia jest '.$szef.' Sądu Rejonowego w '.$miejscowosc.'.</p>' .
                '<p align="justify">Upoważnienie dotyczy przetwarzania danych osobowych w ramach otrzymanego zakresu obowiązków, odpowiedzialności i uprawnień  oraz  w zakresie wynikającym z poleceń przełożonego.</p>' .
                '<p></p>' .
                '<p align="justify">Upoważnienie traci ważność z chwilą jego cofnięcia lub ustania stosunku umownego wiążącego upoważnionego z administratorem danych.</p>' .
                '<p></p>' .
                '<p>Ja niżej podpisany zostałem zapoznany z dokumentacją przetwarzania i ochrony danych osobowych obowiązujących w Sądzie Rejonowym w '.$miejscowosc.' w tym z procedurą zgłaszania naruszeń i incydentów oraz zobowiązuję się do bezterminowego zachowania w tajemnicy danych osobowych, wszelkich procedur, zabezpieczeń i innych informacji i danych pozyskanych podczas świadczenia pracy / współpracy w tym po ustaniu stosunku umownego. </p>' .
                '<p></p>' .
                '<p align="right">...................................................</p>' .
                '<p align="right"> podpis osoby otrzymującej upoważnienie</p>' .
                '</body></html>';
    }
    
    
    
    
}
?>