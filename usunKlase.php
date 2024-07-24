<?php
session_start();
require_once('role.php');
if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != ROLA_PRACOWNIK) {
    header("Location: /");
}
$data=date("Y-m-d");
ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );

require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();

if ($_SESSION['Id'] != $_GET['id']) {
    $Zapytanie2 =
        "SELECT *
        FROM uczniowie, klasy, przydzial
        WHERE klasy.klasaId=".$_GET['id']."
        AND przydzial.klasa1 =".$_GET['id']."
        AND przydzial.uczen = uczniowie.uczenId";
    $result2 = mysqli_query($conn,$Zapytanie2);
    $row2 = mysqli_fetch_assoc($result2);
    $klasa = $row2["klasa"];
    $Imie = $row2["Imie"];
    $Nazwisko = $row2["Nazwisko"];
    $Email = $row2["Email"];
    $Haslo = $row2["Haslo"];
    $uczen = $row2["uczen"];
    $Zapytanie5 =
        "DELETE 
        FROM przydzial
        WHERE przydzial.klasa1 =" . $_GET['id'];
    $Zapytanie7 =
        "DELETE 
                FROM uczenie
                WHERE uczonaKlasa =" . $_GET['id'];
    $Zapytanie8 =
        "DELETE 
                FROM zadania
                WHERE klasa =" . $_GET['id'];
    if ($conn->query($Zapytanie5) === true
    and $conn->query($Zapytanie8) === true
    and $conn->query($Zapytanie7) === true){
        $Zapytanie3 =
            "INSERT INTO usuniete (klasa,usuniecie)
        VALUES('" . $klasa . "','" . $data . "')";
        $Zapytanie4 =
            "INSERT INTO usuniete (Imie,Nazwisko,Email,Haslo,usuniecie)
        VALUES('" . $Imie . "','" . $Nazwisko . "','" . $Email . "','" . $Haslo . "','" . $data . "')";
        $Zapytanie =
            "DELETE 
        FROM klasy
        WHERE klasy.klasaId=" . $_GET['id'];
        if (isset($row2["Imie"])) {
            $Zapytanie6 =
                "DELETE 
                FROM uczniowie
                WHERE uczniowie.uczenId =" . $uczen;
            if ($conn->query($Zapytanie6) === true){
                echo "New record created successfully";
                if ($conn->query($Zapytanie) === true
                and $conn->query($Zapytanie3) === true
                and $conn->query($Zapytanie4) === true) {
                    echo "New record created successfully";
                    header("location: klasy.php?usunieto=1");
                } else {
                    echo "Error: " . $conn->error;
                }
            }else{
                echo "Error: " . $conn->error;
            }
        } else {
            if ($conn->query($Zapytanie) === true
                and $conn->query($Zapytanie3) === true
                and $conn->query($Zapytanie4) === true) {
                echo "New record created successfully";
                header("location: klasy.php?usunieto=1");
            } else {
                echo "Error: " . $conn->error;
            }
            $conn->close();
        }
    }
} else{
    header("location: klasy.php?niewolno=1");

}


?>
