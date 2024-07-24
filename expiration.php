<?php

ini_set( 'display_errors', 'On' ); 
error_reporting( E_ALL );
date_default_timezone_set('Europe/Warsaw');
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$data=date("Y-m-d");
$usuwanie =
    "DELETE 
    FROM loginy 
    WHERE DataDolaczenia <'" . $data."'";
if ($conn->query($usuwanie) === TRUE) {
echo '';
  } else {
    echo "";
  }
$usuwanie2 =
    "DELETE 
    FROM loginytmp 
    WHERE dataProsby <'" . $data."'";
if ($conn->query($usuwanie2) === TRUE) {
  echo '';
} else {
  echo "";
}
$data2 = strtotime("+1 month");
$data3 = (date("Y-m-d",$data2));
$usuwanie3 =
    "DELETE 
    FROM usuniete 
    WHERE usuniecie >'" . $data3."'";
if ($conn->query($usuwanie3) === TRUE) {
  echo '';
} else {
  echo "";
}
$data4 = date("Y-m-d G:i:s");
$usuwanie4 =
    "UPDATE zadania
    SET widoczne = false
    WHERE dataZakonczenia <'" . $data4."'";
if ($conn->query($usuwanie4) === TRUE) {
  echo '';
} else {
  echo "";
}
$conn->close();

