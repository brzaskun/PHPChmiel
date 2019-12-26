<?php error_reporting(0);
  session_save_path($_SERVER['DOCUMENT_ROOT'].'/resources/sessiondata');   
  if(session_status()!=2){     
      session_start(); 
  };
  try {
    require_once($_SERVER['DOCUMENT_ROOT'].'/resources/php/Rb.php');
    R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
  } catch (Exception $e) {}
  $firmanazwa = $_POST['firma'];
  require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/FirmaNazwaToId.php');
  $firma_id = FirmaNazwaToId::wyszukaj($firmanazwa);
  $stara = $_POST['stara'];
  $nowa = $_POST['nowa'];
  $sql = "SELECT * FROM p6273_odomg.uczestnicy INNER JOIN uczestnikgrupy ON uczestnicy.id = uczestnikgrupy.id_uczestnik WHERE uczestnicy.firma_id='$firma_id' AND uczestnikgrupy.grupa='$stara'";
  $doprzesuniecia = R::getAll($sql);
  $sukces = array();
  $sukces2 = array();
  $iledoprzesuniecia = 0;
  if (isset($doprzesuniecia) && !empty($doprzesuniecia)) {
    $iledoprzesuniecia = sizeof($doprzesuniecia)*2;
    foreach ($doprzesuniecia as $val) {
        try {
            $sqli = "INSERT INTO `p6273_odomg`.`uczestnikgrupy` (`email`, `nazwiskoiimie`, `grupa`, `id_uczestnik`) VALUES ('".$val["email"]."', '".$val["imienazwisko"]."', '".$nowa."', '".$val["id"]."')";
            R::exec($sqli);
            array_push($sukces, $val);
            try {
              $sqlj = "DELETE FROM `p6273_odomg`.`uczestnikgrupy` WHERE `id`='".$val["id"]."'";
              R::exec($sqlj);
              array_push($sukces2, $val);
            } catch (Exception $ex) {

            }
        } catch (Exception $ex) {
            try {
              $sqlj = "DELETE FROM `p6273_odomg`.`uczestnikgrupy` WHERE `id`='".$val["id"]."'";
              R::exec($sqlj);
              array_push($sukces2, $val);
            } catch (Exception $ex) {

            }
        }

    }
  }
  $ileprzesunieto = sizeof($sukces);
  $ileusunieto = sizeof($sukces2);
  //teraz usuwamy pusta grupe
  $sql = "SELECT * FROM p6273_odomg.uczestnicy INNER JOIN uczestnikgrupy ON uczestnicy.id = uczestnikgrupy.id_uczestnik WHERE uczestnicy.firma_id='$firma_id' AND uczestnikgrupy.grupa='$stara'";
  $doprzesunieciaspr = R::getAll($sql);
  if (!isset($doprzesunieciaspr)|| empty($doprzesunieciaspr)) {
      $sqla = "DELETE FROM `p6273_odomg`.`grupyupowaznien` WHERE `firma_id`='".$firma_id."' AND `nazwagrupy`='".$stara."'";
      R::exec($sqla);
      $sql = "SELECT * FROM p6273_odomg.uczestnicy INNER JOIN uczestnikgrupy ON uczestnicy.id = uczestnikgrupy.id_uczestnik WHERE uczestnicy.firma_id='$firma_id' AND uczestnikgrupy.grupa='$stara'";
      $doprzesunieciaspr = R::getAll($sql);
  }
  if ($iledoprzesuniecia==($ileprzesunieto+$ileusunieto)) {
      echo 0;
  } else if (empty($doprzesunieciaspr)) {
      echo 0;
  } else {
      echo ($iledoprzesuniecia-$ileprzesunieto-$ileusunieto);
  }

?>

