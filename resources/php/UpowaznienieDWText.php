<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UpowaznienieDWText {
       
    public final static function upowaznienie_kobieta_old($nrupowaznienia, $sqlfirma, $miejscowosc, $ulica, $datanadania, $imienaz, $grupy) {
        return '<!DOCTYPE html><html lang="pl">' .
                '<head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/>' .
                '<link rel="stylesheet" href="/resources/css/upowaznienie.css"/></head><body>' .
                '<p align="center"><b>UPOWAŻNIENIE nr ' . $nrupowaznienia . '</p>' .
                '<p align="center"><b>do przetwarzania danych osobowych<br/>' .
                '<p align="center"> w <span>' . $sqlfirma . ' z siedzibą w ' . $miejscowosc . ' ' . $ulica . ' (dalej "Administrator")</span></p>' .
                '<p></p>' .
                '<p>Działając na podstawie art. 29 Rozporządzenia Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (ogólne rozporządzenie o ochronie danych) (Dz. U. UE. L. z 2016 r. Nr 119, str. 1), zwanego dalej "Rozporządzeniem" oraz art. 22<sub>1b</sub> §3 Ustawy z dnia 26 czerwca 1974 r. Kodeks Pracy (Dz. U. z 2018 r. poz. 917 , z późń. zm.), Administrator informuje, że</p>' .
                '<p></p>' .
                '<p style="font-size: large;">z dniem ' . $datanadania . 'r.</p>' .
                '<p style="font-size: large;">Pani ' . $imienaz . '</p>' .
                '<p>zostaje upoważniona do przetwarzania danych osobowych szczególnej kategorii, których Administratorem w rozumieniu art. 4 pkt 7 Rozporządzenia jest '. $sqlfirma .'.</p>' .
                '<p>Upoważnienie dotyczy przetwarzania danych osobowych, o których mowa w art. 9 ust. 1 Rozporządzenia tj. danych osobowych ujawniających pochodzenie rasowe lub etniczne, poglądy polityczne, przekonania religijne lub światopoglądowe, przynależność do związków zawodowych oraz przetwarzania danych genetycznych, danych biometrycznych w celu jednoznacznego zidentyfikowania osoby fizycznej lub danych dotyczących zdrowia, seksualności lub orientacji seksualnej tej osoby.</p>' .
                '<p align="justify">Upoważnienie traci ważność z chwilą jego cofnięcia lub ustania stosunku umownego wiążącego upoważnionego z administratorem danych.</p>' .
                '<p></p>' .
                '<p>Ja niżej podpisana, zobowiązuję się do zachowania w tajemnicy danych osobowych, wszelkich procedur, zabezpieczeń i innych informacji i danych pozyskanych podczas świadczenia pracy (usług) również po ustaniu stosunku umownego.</p>' .
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
                '<p align="center"> w <span>' . $sqlfirma . ' z siedzibą w ' . $miejscowosc . ' ' . $ulica . ' (dalej "Administrator")</span></p>' .
                '<p></p>' .
                '<p>Działając na podstawie art. 29 Rozporządzenia Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (ogólne rozporządzenie o ochronie danych) (Dz. U. UE. L. z 2016 r. Nr 119, str. 1), zwanego dalej "Rozporządzeniem" oraz art. 22<sub>1b</sub> §3 Ustawy z dnia 26 czerwca 1974 r. Kodeks Pracy (Dz. U. z 2018 r. poz. 917 , z późń. zm.), Administrator informuje, że</p>' .
                '<p></p>' .
                '<p style="font-size: large;">z dniem ' . $datanadania . '</p>' .
                '<p style="font-size: large;">Pan ' . $imienaz . '</p>' .
                '<p>zostaje upoważniony do przetwarzania danych osobowych szczególnej kategorii, których Administratorem w rozumieniu art. 4 pkt 7 Rozporządzenia jest '. $sqlfirma .'.</p>' .
                '<p>Upoważnienie dotyczy przetwarzania danych osobowych, o których mowa w art. 9 ust. 1 Rozporządzenia tj. danych osobowych ujawniających pochodzenie rasowe lub etniczne, poglądy polityczne, przekonania religijne lub światopoglądowe, przynależność do związków zawodowych oraz przetwarzania danych genetycznych, danych biometrycznych w celu jednoznacznego zidentyfikowania osoby fizycznej lub danych dotyczących zdrowia, seksualności lub orientacji seksualnej tej osoby.</p>' .
                '<p align="justify">Upoważnienie traci ważność z chwilą jego cofnięcia lub ustania stosunku umownego wiążącego upoważnionego z administratorem danych.</p>' .
                '<p></p>' .
                '<p>Ja niżej podpisany, zobowiązuję się do zachowania w tajemnicy danych osobowych, wszelkich procedur, zabezpieczeń i innych informacji i danych pozyskanych podczas świadczenia pracy (usług) również po ustaniu stosunku umownego.</p>' .
                '<p></p>' .
                '<p>...................................................</p>' .
                '<p><i> podpis osoby otrzymującej upoważnienie</i></p>' .
                '</body></html>';
    }
    

    
}
?>