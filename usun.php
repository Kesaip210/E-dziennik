<?php 
session_start();
require_once('role.php');
if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != ROLA_PRACOWNIK) {
header("Location: /");
}

ini_set( 'display_errors', 'On' ); 
error_reporting( E_ALL );

require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();

if ($_SESSION['Id'] != $_GET['id']) {
  print($_GET["id"]);
$Zapytanie =
    "DELETE 
    FROM Pracownicy 
    WHERE PracownikId=".$_GET['id'];
if ($conn->query($Zapytanie) === TRUE) {
  echo "New record created successfully";
  header("location: pracownicy.php?usunieto=1");
} else {
  echo "Error: " . $conn->error;
}

$conn->close();
  } else{
    header("location: pracownicy.php?niewolno=1");

}


?>