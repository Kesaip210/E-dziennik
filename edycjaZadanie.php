<?php
session_start();
require_once('role.php');
if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != ROLA_PRACOWNIK AND ($_SESSION['zalogowany'] != ROLA_NAUCZYCIEL)) {
    header("Location: /");
}

ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
$Zmiana=0;

require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie =
    "SELECT 
        nazwa,
        opis,
        widoczne,
        dataZakonczenia,
        nauczyciel,
        klasa,
        przedmiot
    FROM zadania
    WHERE id='".$_POST['id']."'";
$result = mysqli_query($conn, $Zapytanie);
if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        if ($_POST["widoczne"]=="Tak"){
            $wid = 1;
        }else{
            $wid = 0;
        }
        $nazwa = $row["nazwa"];
        $opis = $row["opis"];
        $widoczne = $row["widoczne"];
        $data = $row["dataZakonczenia"];
        $nauczyciel = $row["nauczyciel"];
        $klasa = $row["klasa"];
        $przedmiot = $row["przedmiot"];
        if ($_SESSION['Id'] != $nauczyciel){
            header("location:/?nie");
        }
    }
}
if ($nazwa != $_POST['nazwa']) {$Zmiana=1;}
if ($opis != $row["opis"]) {$Zmiana=1;}
if ($widoczne != $wid) {$Zmiana=1;}
if ($Zmiana == 1) {
    $Zapytanie =
        "UPDATE zadania
            SET nazwa='".$_POST["nazwa"]."',opis='".$_POST["opis"]."',widoczne='".$wid."',dataZakonczenia='".$_POST["data"]."'
            WHERE id='".$_POST['id']."'";


    if ($conn->query($Zapytanie) === true) {
        echo "New record created successfully";
        header("location: zadania.php?nauczyciel=".$nauczyciel."&klasa=".$klasa."&przedmiot=".$przedmiot."&zedytowano=1");
    } else {
        echo "Error: " . $conn->error;
    }
}else {
    header("location: zadania.php?nauczyciel=".$nauczyciel."&klasa=".$klasa."&przedmiot=".$przedmiot."&!zmiany=1");
}
$conn->close();
?>