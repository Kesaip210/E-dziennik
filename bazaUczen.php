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
$log =
    "SELECT Email 
    FROM uczniowie 
    WHERE Email = '".$_POST['Email']."'";
$login = mysqli_query($conn, $log);
if (mysqli_num_rows($login) != 0) {
    header("location: dodajUcznia.php?zajety=2");
} else {
    $Imie = str_replace(" ", '', $_POST['Imie']);
    $Email = str_replace(" ", '', $_POST['Email']);
    if (strpos($_POST['haslo'], " ")) {
        header("location: dodajUcznia.php?haslo=1");
    } else {
        if (!preg_match("/^[a-zA-Z]+$/", $_POST['Nazwisko'])) {
            header("location: dodajUcznia.php?zlenazwisko=1");
        } else {
            if (!preg_match("/^[a-zA-Z]+$/", $Imie)) {
                header("location: dodajUcznia.php?zleimie=1");
            } else {
                if ($_POST["haslo"] == $_POST["haslo2"]) {
                    $Zapytanie =
                        "INSERT INTO uczniowie (Imie,Nazwisko,Email,Haslo) 
                        VALUES ('" . $Imie . "','" . $_POST["Nazwisko"] . "','" . $Email . "','" . $_POST["haslo"] . "')";
                    if ($conn->query($Zapytanie) === true) {
                        $Zapytanie2 =
                            "SELECT 
                                uczenId,
                                Email 
                            FROM uczniowie 
                            WHERE Email = ('" . $_POST["Email"] . "')";
                        $result = mysqli_query($conn, $Zapytanie2);
                        $row = mysqli_fetch_assoc($result);
                        $kl =
                            "SELECT klasaId 
                            FROM klasy 
                            WHERE klasa = '" . $_POST['klasa'] . "'";
                        $klasa = mysqli_query($conn, $kl);
                        $row2 = mysqli_fetch_assoc($klasa);
                        $Zapytanie3 =
                            "INSERT INTO przydzial (uczen,klasa1) 
                            VALUES ('" . $row["uczenId"] . "','" . $row2["klasaId"] . "')";

                        if ($conn->query($Zapytanie3) === true) {
                            echo "New record created successfully";
                            header("location: uczniowie.php?dodano=2");
                        } else {
                            echo "Error: " . $conn->error;
                        }

                        $conn->close();
                    } else {
                        header("location: dodajUcznia.php?zlehaslo=1");
                    }
                }
            }
        }
    }
}
?>