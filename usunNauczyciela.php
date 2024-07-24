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
$Zapytanie2 =
    "DELETE 
    FROM nauczyciele
    WHERE nauczycielId =" . $_GET['id'];
$Zapytanie3 =
    "DELETE 
    FROM zadania
    WHERE nauczyciel =" . $_GET['id'];
if ($conn->query($Zapytanie2) === TRUE
AND $conn->query($Zapytanie3) === TRUE) {
    $Zapytanie =
        "DELETE 
        FROM nauczyciele 
        WHERE nauczycielId=" . $_GET['id'];
    if ($conn->query($Zapytanie) === true) {
        echo "New record created successfully";
        header("location: nauczyciele.php?usunieto=1");
    } else {
        echo "Error: " . $conn->error;
    }
}else{
    echo "Error: " . $conn->error;
}
    $conn->close();
?>