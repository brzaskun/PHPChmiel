<?php
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
if (session_status() != 2) {
    session_start();
};
error_reporting(0);
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Excelwygeneruj.php');
$naglowki = $_POST['naglowek'];
$wiersze = $_POST['tablica'];
$nazwafirmy = $_POST['nazwafirmy'];
echo Excelwygeneruj::excel_uzytkownik_grupy($naglowki,$wiersze,$nazwafirmy); 
?> 