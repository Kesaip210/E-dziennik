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
        Nazwisko,
        Imie,
        Email,
        haslo 
        FROM nauczyciele 
        WHERE nauczycielId='".$_POST['id']."'";
$result = mysqli_query($conn, $Zapytanie);
if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        $imie = $row["Imie"];
        $nazwisko = $row["Nazwisko"];
        $login = $row["Email"];
        $haslo = $row["haslo"];
    }
}


if ($_POST["haslo"] == $_POST["haslo2"]) {
    if ($imie != $_POST['Imie']) {$Zmiana=1;}
    if ($nazwisko != $_POST['Nazwisko']) {$Zmiana=1;}
    if ($haslo != $_POST['haslo']) {$Zmiana=1;}
    if ($login != $_POST['Email']) {$Zmiana=2;}
    $Imie = str_replace(" ",'',$_POST['Imie']);
    $Login = str_replace(" ",'',$_POST['Email']);

    if (strpos($_POST['haslo'], " ")) {
        header("location: nauczyciele.php?haslo=1");
    } else {
        if (!preg_match("/^[a-zA-Z]+$/", $_POST['Nazwisko'])) {
            header("location: nauczyciele.php?zlenazwisko=1");
        } else {
            if (!preg_match("/^[a-zA-Z]+$/", $Imie)) {
                header("location: nauczyciele.php?zleimie=1");
            } else {
                if ($Zmiana == 2) {

                    $log =
                        "SELECT Email 
                        FROM nauczyciele 
                        WHERE Email = '" . $_POST['Email'] . "'";
                    $login = mysqli_query($conn, $log);
                    if (mysqli_num_rows($login) != 0) {
                        header("location: nauczyciele.php?zajety=2");
                    } else {
                        $Zapytanie =
                            "UPDATE nauczyciele 
                            SET Imie='" . $Imie . "',Nazwisko='" . $_POST['Nazwisko'] . "',Email='" . $Login . "',haslo='" . $_POST['haslo'] . "' 
                            WHERE nauczycielId='" . $_POST['id'] . "'";
                        if ($conn->query($Zapytanie) === true) {
                            echo "New record created successfully";

                            header("location: nauczyciele.php?zedytowano=1");
                        } else {
                            echo "Error: " . $conn->error;
                        }
                    }
                } else {

                    if ($Zmiana == 1) {
                        $Zapytanie =
                            "UPDATE nauczyciele 
                            SET Imie='" . $_POST['Imie'] . "',Nazwisko='" . $_POST['Nazwisko'] . "',haslo='" . $_POST['haslo'] . "' 
                            WHERE nauczycielId='" . $_POST['id'] . "'";


                        if ($conn->query($Zapytanie) === true) {
                            echo "New record created successfully";
                            header("location: nauczyciele.php?zedytowano=1");
                        } else {
                            echo "Error: " . $conn->error;
                        }
                    } else {
                        header("location: nauczyciele.php?!zmiany=1");
                    }
                }
                $conn->close();
            }
        }
    }

} else {
    header("location: edytujNauczyciela.php?zlehaslo=1");
}
?>