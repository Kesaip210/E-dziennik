<?php
session_start();

if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != 1) {
    header("Location: /");
}
ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$nauczyciel =
    "SELECT nauczycielId,Imie,Nazwisko
    FROM nauczyciele
    WHERE Email ='".$_POST["Email"]."'";
$nauczy = mysqli_query($conn,$nauczyciel);
$naucz = mysqli_fetch_assoc($nauczy);
$log =
    "SELECT klasaId,klasa
    FROM klasy 
    WHERE klasa = '".$_POST['klasa']."'";
$login = mysqli_query($conn, $log);
$row2 = mysqli_fetch_assoc($login);
$Zapytanie3 =
    "SELECT przedmiotId,przedmiot
    FROM przedmioty
    WHERE przedmiot ='". $_POST["przedmiot"] ."'";
$result = mysqli_query($conn,$Zapytanie3);
$row = mysqli_fetch_assoc($result);
$Zapytanie4 =
    "SELECT uczonaKlasa,uczonyPrzedmiot
    FROM uczenie
    WHERE uczonaKlasa ='".$row2["klasaId"]."'
    AND uczonyPrzedmiot ='".$row["przedmiotId"]."'";
$result2 = mysqli_query($conn,$Zapytanie4);
$row3 = mysqli_fetch_assoc($result2);
if ($row3["uczonaKlasa"] != null AND $row3["uczonyPrzedmiot"] != null){
    header("location: uczenie.php?zajete=5");
    die;
}else {
    $Upload = "/var/www/domex/uploads/";
    mkdir($Upload.$naucz["Imie"]."_".$naucz["Nazwisko"]."/");
    $Upload = "/var/www/domex/uploads/";
    if (!is_dir($Upload.$naucz["Imie"]."_".$naucz["Nazwisko"]."/")){
        mkdir($Upload.$naucz["Imie"]."_".$naucz["Nazwisko"]."/");
    }
    if (!is_dir($Upload.$naucz["Imie"]."_".$naucz["Nazwisko"]."/".$row2["klasa"]."/")){
        mkdir($Upload.$naucz["Imie"]."_".$naucz["Nazwisko"]."/".$row2["klasa"]."/");
    }
    if (!is_dir($Upload.$naucz["Imie"]."_".$naucz["Nazwisko"]."/".$row2["klasa"]."/".$row["przedmiot"]."/")){
        mkdir($Upload.$naucz["Imie"]."_".$naucz["Nazwisko"]."/".$row2["klasa"]."/".$row["przedmiot"]."/");
    }
    $Zapytanie =
        "INSERT INTO uczenie (nauczyciel,uczonaKlasa,uczonyPrzedmiot) 
    VALUES ('" . $naucz["nauczycielId"] . "','" . $row2["klasaId"] . "','" . $row["przedmiotId"] . "')";


    if ($conn->query($Zapytanie) === true) {
        echo "New record created successfully";
        header("location: uczenie.php?dodano=2");
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>
