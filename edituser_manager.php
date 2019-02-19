<?php error_reporting(0);
use R;
  if(session_status()!=2){     session_start(); };
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
  R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  $id = $_POST['iduser'];
  $email = $_POST['email'];
  $imienazwisko = $_POST['imienazwisko'];
  $imienazwisko = addslashes($imienazwisko);
  $sessionstart = NULL;
  if ($_POST['datazalogowania']==""){
   $sessionstart = NULL;   
  } else {
    $sessionstart = $_POST['datazalogowania'];
  }
  $nazwaszkolenia = $_POST['szkolenieuser'];
  $uprawnienia = $_POST['uprawnieniauser'];
  $firma = $_POST['firmausernazwa'];
  $plec = $_POST['plecuser'];
  if(isset($_POST['edytujuser'])){
    //musza byc dwa bo wpisywal 0 a nie null jak bylo nic w stringu a musi byc null bo tylko wtedy generuje rozpoczecie sesji
    $sql = "UPDATE  `uczestnicy` SET  `imienazwisko` =  '$imienazwisko', `plec` = '$plec', `firma` = '$firma', `nazwaszkolenia` = '$nazwaszkolenia', `sessionstart` = '$sessionstart' , `uprawnienia`='$uprawnienia' WHERE  `uczestnicy`.`id` = $id;";
    $sqlnull = "UPDATE  `uczestnicy` SET  `imienazwisko` =  '$imienazwisko', `plec` = '$plec', `firma` = '$firma', `nazwaszkolenia` = '$nazwaszkolenia', `sessionstart` = null, `uprawnienia`='$uprawnienia' WHERE  `uczestnicy`.`id` = $id;";
    R::exec($sessionstart == null ? $sqlnull : $sql);
    //header("Location: admin.php?info=Dane pracownika zaktualizowane");  
  } else if (!isset ($sessionstart)){
    $sql = "DELETE FROM `uczestnicy` WHERE `id`=$id";
    $wynikusuwania = R::exec($sql);
    $_SESSION['liczbapracownikow'] = $_SESSION['liczbapracownikow'] - 1;
    $url = "Location: manager.php?info=Pracownik '$imienazwisko' usunięty z listy";
    header($url);
    exit();
  }
?>
