<?php

// Sends output inline to browser
require_once("../MPDF57/mpdf.php");
require_once("../php/PL_EN.php");
$mpdf = new mPDF();
$i = PL_EN::wybierzjezyk("100");

$mpdf->WriteHTML(PL_EN::$pytanie[$i]);
$mpdf->WriteHTML(PL_EN::$pytanie[$i]);

$mpdf->Output();

?>

