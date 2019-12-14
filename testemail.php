<?php 
session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata'); 
if (session_status()!=2) {
    session_start();
}; 
set_time_limit(0);
ini_set('memory_limit','256M');
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Mail.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/SprawdzWprowadzanyWiersz.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');

try {
    R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
} catch (Exception $e) {}
$testemail = $_POST['testemail'];
Mail::mailautomattest($testemail);
?>