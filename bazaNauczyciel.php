<?php
session_start();
require_once('role.php');
if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != ROLA_PRACOWNIK) {
    header("Location: /");
}
ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
$conn = polaczenieBaza();
$log =
    "SELECT Email 
    FROM nauczyciele 
    WHERE Email = '".$_POST['Email']."'";
$login = mysqli_query($conn, $log);
if (mysqli_num_rows($login) != 0) {
    header("location: dodajNauczyciela.php?zajety=2");
} else {
    $Imie = str_replace(" ",'',$_POST['Imie']);
    $Login = str_replace(" ",'',$_POST['Email']);

    if (strpos($_POST['haslo'], " ")) {
        header("location: dodajNauczyciela.php?haslo=1");
    } else {
        if (!preg_match("/^[a-zA-Z]+$/", $_POST['Nazwisko'])) {
            header("location: dodajNauczyciela.php?zlenazwisko=1");
        } else {
            if (!preg_match("/^[a-zA-Z]+$/", $Imie)) {
                header("location: dodajNauczyciela.php?zleimie=1");
            } else {
                if ($_POST["haslo"] == $_POST["haslo2"]) {
                    $Zapytanie =
                        "INSERT INTO nauczyciele (Imie,Nazwisko,Email,haslo) 
                        VALUES ('" . $Imie . "','" . $_POST["Nazwisko"] . "','" . $Login . "','" . $_POST["haslo"] . "')";


                    if ($conn->query($Zapytanie) === true) {
                        echo "New record created successfully";
                        header("location: nauczyciele.php?dodano=2");
                    } else {
                        echo "Error: " . $conn->error;
                    }

                    $conn->close();
                } else {
                    header("location: dodajNauczyciela.php?zlehaslo=1");
                }
            }
        }
    }
}
?>