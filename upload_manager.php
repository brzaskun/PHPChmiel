<?php error_reporting(0);
if (session_status()!=2) {
    session_start();
    };
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Mail.php');
$tablicapobranychpracownikow = $_SESSION['tablicapobranychpracownikow'];
$firmabaza = $_SESSION['uczestnik']['firma'];
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
foreach ($tablicapobranychpracownikow  as $wierszbaza) {
  try {
  $imienazwisko = addslashes($wierszbaza[1]);
  $sql = "INSERT INTO  `uczestnicy` (`id`, `email` ,`imienazwisko` ,`plec` ,`firma` , `nazwaszkolenia`, `uprawnienia` ,`wyslanymailupr` ,`sessionstart` ,
    `sessionend` ,`wyniktestu` ,`wyslanycert`)
    VALUES (0, '$wierszbaza[0]',  '$imienazwisko', '$wierszbaza[2]', '$firmabaza', '$wierszbaza[3]', 'uzytkownik' , 0, NULL , NULL , 0 , 0);";
  R::exec($sql);
  Mail::mailautomat($imienazwisko, $wierszbaza[2], $wierszbaza[0], $wierszbaza[3]);
  } catch (Exception $e){
      header("Location: manager.php?error=Istnieje już taki email w bazie danych!");
      exit();
  }
   
}
 $url = "Location: manager.php?info=Wczytano rekordy z bazy danych";
 header($url);
 exit();
?>
