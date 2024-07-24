<?php
session_start();
require_once('role.php');
if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != ROLA_PRACOWNIK) {
    header("Location: /");
}

ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
$Zmiana=0;

require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie =
    "SELECT 
        klasa,
        wychowawca
    FROM klasy
    WHERE klasaId='".$_POST['id']."'";
$result = mysqli_query($conn, $Zapytanie);
if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        $klasa = $row["klasa"];
        $wychowawca = $row["wychowawca"];
    }
}
$nauczyciel =
    "SELECT nauczycielId
        FROM nauczyciele
        WHERE Email ='". $_POST["Email"] ."'";
$result2 = mysqli_query($conn,$nauczyciel);
$row2 = mysqli_fetch_assoc($result2);
    if ($klasa != $_POST['klasa']) {$Zmiana=1;}
    if ($wychowawca != $row2["nauczycielId"]) {$Zmiana=1;}

    if ($Zmiana == 1) {
        $Zapytanie =
            "UPDATE klasy 
            SET klasa='" . $_POST["klasa"] . "',wychowawca='" . $row2["nauczycielId"] . "' 
            WHERE klasaId='" . $_POST['id'] . "'";


        if ($conn->query($Zapytanie) === true) {
            echo "New record created successfully";
            header("location: klasy.php?zedytowano=1");
        } else {
            echo "Error: " . $conn->error;
        }
    }else {
        header("location: klasy.php?!zmiany=1");
    }
    $conn->close();
?>