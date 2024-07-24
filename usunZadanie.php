<?php
session_start();
require_once('role.php');
if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != ROLA_PRACOWNIK AND ($_SESSION['zalogowany'] != ROLA_NAUCZYCIEL)) {
    header("Location: /");
}
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
$Zapytanie2 =
    "SELECT 
            nazwa,
            nauczyciel,
            klasa,
            przedmiot
        FROM zadania
        WHERE id ='" .$_GET['id']."'";
$result = mysqli_query($conn,$Zapytanie2);
$row = mysqli_fetch_assoc($result);
if ($_SESSION['Id'] != $row["nauczyciel"]){
    header("location:/?nie");
}
$Zapytanie =
    "DELETE 
    FROM zadania
    WHERE id ='" .$_GET['id']."'";
if ($conn->query($Zapytanie) === TRUE) {
    echo "New record created successfully";
    $Zapytanie3 =
        "SELECT 
                Imie,
                Nazwisko,
                klasa,
                przedmiot
            FROM 
                nauczyciele,
                klasy,
                przedmioty
            WHERE nauczycielId ='".$row["nauczyciel"]."'
            AND klasaId ='".$row["klasa"]."'
            AND przedmiotId ='".$row["przedmiot"]."'";
    $result2 = mysqli_query($conn,$Zapytanie3);
    $row2 = mysqli_fetch_assoc($result2);
    $Upload = "/var/www/domex/uploads/";
    if (is_dir($Upload.$row2["Imie"]."_".$row2["Nazwisko"]."/".$row2["klasa"]."/".$row2["przedmiot"]."/".$row["nazwa"]."/")) {
        rmdir($Upload.$row2["Imie"]."_".$row2["Nazwisko"]."/".$row2["klasa"]."/".$row2["przedmiot"]."/".$row["nazwa"]."/");
    }
    header("location: zadania.php?nauczyciel=".$row["nauczyciel"]."&klasa=".$row["klasa"]."&przedmiot=".$row["przedmiot"]."&usunieto=1");
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>