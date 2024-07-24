<?php
session_start();

if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != 1 AND ($_SESSION['zalogowany'] < 400 or $_SESSION['zalogowany'] > 500) AND $_SESSION['zalogowany'] != 40) {
    header("Location: /");
}
if ($_SESSION['Id'] != $_GET["nauczyciel"]){
    header("location:/?nie");
}
ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$log =
    "SELECT nazwa,opis
    FROM zadania 
    WHERE nazwa = '".$_POST['Nazwa']."'
    AND klasa = '".$_POST['klasa']."'
    AND nauczyciel= '".$_POST['nauczyciel']."'
    AND przedmiot = '".$_POST['przedmiot']."'";
$login = mysqli_query($conn, $log);
if (mysqli_num_rows($login) != 0) {
    header("location: dodajZadanie.php?nauczyciel=".$_POST["nauczyciel"]."&klasa=".$_POST["klasa"]."&przedmiot=".$_POST["przedmiot"]."&zajety=3");
}else {
    $row = mysqli_fetch_assoc($login);
    if ($_POST["Widoczne"] == "Tak"){
        $widoczne = 1;
    }else{
        $widoczne = 0;
    }

    $Zapytanie =
        "INSERT INTO zadania (nazwa,opis,widoczne,dataZakonczenia,nauczyciel,klasa,przedmiot) 
        VALUES ('".$_POST["Nazwa"]."','".$_POST["Opis"]."','".$widoczne."','".$_POST["Data"]."','".$_POST["nauczyciel"]."','".$_POST["klasa"]."','".$_POST["przedmiot"]."')";


    if ($conn->query($Zapytanie) === true) {
        $Zapytanie =
            "SELECT 
                Imie,
                Nazwisko,
                klasa,
                przedmiot
            FROM 
                nauczyciele,
                klasy,
                przedmioty
            WHERE nauczycielId ='".$_POST["nauczyciel"]."'
            AND klasaId ='".$_POST["klasa"]."'
            AND przedmiotId ='".$_POST["przedmiot"]."'";
        $result = mysqli_query($conn,$Zapytanie);
        $row = mysqli_fetch_assoc($result);
        $Upload = "/var/www/domex/uploads/";
        if (!is_dir($Upload.$row["Imie"]."_".$row["Nazwisko"]."/".$row["klasa"]."/".$row["przedmiot"]."/".$_POST["Nazwa"]."/")) {
            mkdir($Upload.$row["Imie"]."_".$row["Nazwisko"]."/".$row["klasa"]."/".$row["przedmiot"]."/".$_POST["Nazwa"]."/");
        }
        echo "New record created successfully";
        header("location: zadania.php?nauczyciel=".$_POST["nauczyciel"]."&klasa=".$_POST["klasa"]."&przedmiot=".$_POST["przedmiot"]."&dodano=3");
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>