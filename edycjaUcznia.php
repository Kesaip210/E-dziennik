<?php
session_start();
require_once('role.php');
if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != ROLA_PRACOWNIK) {
    header("Location: /?nie");
}

ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
$Zmiana=0;

require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie2 =
    "SELECT klasaId 
    FROM klasy 
    WHERE klasa = '".$_POST['klasa']."'";
$result2 = mysqli_query($conn,$Zapytanie2);
$row2 = mysqli_fetch_assoc($result2);
$klasaId = $row2["klasaId"];
$Zapytanie =
    "SELECT 
        uczniowie.Nazwisko,
        uczniowie.Imie,
        uczniowie.Email,
        uczniowie.Haslo,
        klasy.klasa,
        klasy.klasaId,
        przydzial.klasa1,
        przydzial.uczen
    FROM 
        uczniowie, 
        klasy, 
        przydzial 
        WHERE uczniowie.uczenId='".$_POST['id']."'";
$result = mysqli_query($conn, $Zapytanie);
if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        $imie = $row["Imie"];
        $nazwisko = $row["Nazwisko"];
        $login = $row["Email"];
        $haslo = $row["Haslo"];
        $klasa = $row["klasa"];
    }
}


if ($_POST["haslo"] == $_POST["haslo2"]) {
    if ($imie != $_POST['Imie']) {$Zmiana=1;}
    if ($nazwisko != $_POST['Nazwisko']) {$Zmiana=1;}
    if ($haslo != $_POST['haslo']) {$Zmiana=1;}
    if ($klasa != $_POST['klasa']) {$Zmiana=1;}
    if ($login != $_POST['Email']) {$Zmiana=2;}
    $Imie = str_replace(" ",'',$_POST['Imie']);
    $Login = str_replace(" ",'',$_POST['Email']);

    if (strpos($_POST['haslo'], " ")) {
        header("location: uczniowie.php?haslo=1");
    } else {
        if (!preg_match("/^[a-zA-Z]+$/",$_POST['Nazwisko'])) {
            header("location: uczniowie.php?zlenazwisko=1");
        } else {
            if (!preg_match("/^[a-zA-Z]+$/",$Imie)) {
                header("location: uczniowie.php?zleimie=1");
            } else {
                    if ($Zmiana == 2) {

                        $log =
                            "SELECT Email 
                            FROM uczniowie 
                            WHERE Email = '".$_POST['Email']."'";
                        $login = mysqli_query($conn, $log);
                        if (mysqli_num_rows($login) != 0) {
                            header("location: uczniowie.php?zajety=2");
                        } else {
                            $Zapytanie =
                                "UPDATE uczniowie 
                                SET Imie='".$Imie."',Nazwisko='".$_POST['Nazwisko']."',Email='".$Login."',Haslo='".$_POST['haslo']."' 
                                WHERE uczenId='".$_POST['id']."'";
                            $Zapytanie2 =
                                "UPDATE przydzial 
                                SET klasa1 = $klasaId 
                                WHERE uczen = '".$_POST['id']."'";
                            if ($conn->query($Zapytanie) === TRUE AND $conn->query($Zapytanie2) === TRUE) {
                                echo "New record created successfully";

                                header("location: uczniowie.php?zedytowano=1");
                            } else {
                                echo "Error: " . $conn->error;
                            }
                        }
                    } else {

                        if ($Zmiana == 1) {
                            $Zapytanie =
                                "UPDATE uczniowie 
                                SET Imie='".$_POST['Imie']."',Nazwisko='".$_POST['Nazwisko']/*."',Login='".$_POST['Login']*/."',Haslo='".$_POST['haslo']."' 
                                WHERE uczenId='".$_POST['id']."'";
                            $Zapytanie2 =
                                "UPDATE przydzial 
                                SET klasa1 = $klasaId 
                                WHERE uczen = '".$_POST['id']."'";

                            if ($conn->query($Zapytanie) === TRUE AND $conn->query($Zapytanie2) === TRUE) {
                                echo "New record created successfully";
                                header("location: uczniowie.php?zedytowano=1");
                            } else {
                                echo "Error: " . $conn->error;
                            }
                        }else{
                            header("location: uczniowie.php?!zmiany=1");
                        }
                    }
                    $conn->close();
                }
            }
        }
} else {
    header("location: edytujUcznia.php?zlehaslo=1");
}
?>