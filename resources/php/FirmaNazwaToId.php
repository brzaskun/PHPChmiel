<?php

class FirmaNazwaToId {
    
    static $odnalezionaname;
    static $odnalezionaid;

    public static function wyszukaj($firma) {
        if ($firma !="") {
            self::$odnalezionaname = $firma;
            if ($_SERVER["HTTP_HOST"] != "localhost:8000") {
                $_SESSION['host'] = 'mysql:host=172.16.0.6;';
            } else {
                $_SESSION['host'] = 'mysql:host=localhost;';
            }
            try {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Rb.php');
                R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
            } catch (Exception $e) {

            };
            $sql = "SELECT zakladpracy.id FROM zakladpracy WHERE `zakladpracy`.`nazwazakladu` = '$firma'";
            self::$odnalezionaid = R::getCell($sql);
            return self::$odnalezionaid;
        }
    }
    
    public static function wyszukajNazwa($firma_id) {
        if ($firma_id !="") {
            self::$odnalezionaid = $firma_id;
            if ($_SERVER["HTTP_HOST"] != "localhost:8000") {
                $_SESSION['host'] = 'mysql:host=172.16.0.6;';
            } else {
                $_SESSION['host'] = 'mysql:host=localhost;';
            }
            try {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Rb.php');
                R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
            } catch (Exception $e) {

            };
            $sql = "SELECT zakladpracy.nazwazakladu FROM zakladpracy WHERE `zakladpracy`.`id` = '$firma_id'";
            self::$odnalezionaname = R::getCell($sql);
            return self::$odnalezionaname;
        }
    }
    
    public static function wyszukajTablica($firma_nazwa, $firmywykaz) {
        if ($firma_nazwa !="") {
            self::$odnalezionaname = $firma;
            foreach ($firmywykaz as $value) {
                if ($value[nazwazakladu]==$firma_nazwa) {
                    self::$odnalezionaid = $value[id];
                    break;
                }
            }
            return self::$odnalezionaid;
        }
    }
        
        
}
?>
