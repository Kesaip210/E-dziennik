<?php
session_start();
ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();

define('ROLA_UCZEN', 30);
define('ROLA_NAUCZYCIEL', 40);
define('ROLA_PRACOWNIK', 1);
define('ROLA_OSOBA', 2);

$Zapytanie =
    "SELECT 
        Nazwisko,
        Imie,
        OsobaId
    FROM Uzytkownicy 
    WHERE Email='".$_POST["login"]."' 
    AND Haslo='".$_POST["haslo"]."'";
$result = mysqli_query($conn, $Zapytanie);
$row = mysqli_fetch_assoc($result);
if ($row == null) {
    $_SESSION['zalogowany'] = 0;
    $Zapytanie =
        "SELECT 
            Nazwisko,
            Imie,
            uczenId
        FROM uczniowie 
        WHERE Email='" . $_POST["login"] . "' 
        AND Haslo='" . $_POST["haslo"] . "'";
    $result = mysqli_query($conn, $Zapytanie);
    $row = mysqli_fetch_assoc($result);
    $Zapytanie2 =
        "SELECT klasa1
        FROM przydzial
        WHERE uczen ='".$row["uczenId"]."'";
    $result2 = mysqli_query($conn, $Zapytanie2);
    $row2 = mysqli_fetch_assoc($result2);
    $klasa = $row2['klasa1'];
    if ($row == null) {
        $_SESSION['zalogowany'] = 0;
        $Zapytanie =
            "SELECT 
                Nazwisko,
                Imie,
                nauczycielId
        FROM nauczyciele 
        WHERE Email='" . $_POST["login"] . "' 
        AND Haslo='" . $_POST["haslo"] . "'";
        $result = mysqli_query($conn, $Zapytanie);
        $row = mysqli_fetch_assoc($result);
        $Zapytanie2 =
            "SELECT klasaId
            FROM klasy 
            WHERE wychowawca ='" .$row["nauczycielId"]. "'";
        $result2 = mysqli_query($conn, $Zapytanie2);
        $row2 = mysqli_fetch_assoc($result2);
        $klasa = $row2['klasaId'];
        if ($row == null) {
            $_SESSION['zalogowany'] = 0;
            $Zapytanie =
                "SELECT 
                    Nazwisko,
                    Imie,
                    PracownikId
                FROM Pracownicy 
                WHERE Login='" . $_POST["login"] . "' 
                AND Haslo='" . $_POST["haslo"] . "'";
            $result = mysqli_query($conn, $Zapytanie);
            $row = mysqli_fetch_assoc($result);
            if ($row == null) {
                session_destroy();
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: index.php?Nieudany=1");
                exit;
            } else{

                $_SESSION['Id'] = $row['PracownikId'];
                $_SESSION['zalogowany'] = ROLA_PRACOWNIK;
                $_SESSION['session_time'] = time() + 600;
                header("Location: pracownicy.php?udanie");
                exit;
            }
        }else{
            $_SESSION['Id'] = $row['nauczycielId'];
            if ($klasa != null) {
                $_SESSION['zalogowany'] = ROLA_NAUCZYCIEL . $klasa;
            }else {
                $_SESSION['zalogowany'] = ROLA_NAUCZYCIEL . 0;
            }
            $_SESSION['time'] = time() + 600;
            header("Location: index.php?udanie");
            exit;
        }
    } else {
        $_SESSION['Id'] = $row['uczenId'];
        $_SESSION['zalogowany'] = ROLA_UCZEN . $klasa;
        $_SESSION['time'] = time() + 600;
        header("Location: index.php?udanie");
        exit;
    }
}else {
    $_SESSION['Id'] = $row['OsobaId'];
    $_SESSION['zalogowany'] = ROLA_OSOBA;
    $_SESSION['time']     = time()+600;
    header("Location: index.php?udanie");
}
?>