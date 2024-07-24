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

    print($_GET["id"]);
    $Zapytanie =
        "DELETE 
        FROM uczniowie 
        WHERE uczenId=".$_GET['id'];
    $Zapytanie2 =
        "DELETE 
        FROM przydzial 
        WHERE uczen = ".$_GET['id'];
    if ($conn->query($Zapytanie2) === TRUE AND $conn->query($Zapytanie) === TRUE) {
        echo "New record created successfully";
        header("location: uczniowie.php?usunieto=1");
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();

?>