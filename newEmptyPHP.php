<?php
$txt='01-02-2018';

  $re1='((?:(?:[0-2]?\\d{1})|(?:[3][01]{1}))[-:\\/.](?:[0]?[1-9]|[1][012])[-:\\/.](?:(?:[1]{1}\\d{1}\\d{1}\\d{1})|(?:[2]{1}\\d{3})))(?![\\d])';	# DDMMYYYY 1

  if ($c=preg_match_all ("/".$re1."/is", $txt, $matches))
  {
      $ddmmyyyy1=$matches[1][0];
      print "($ddmmyyyy1) \n";
  }

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

