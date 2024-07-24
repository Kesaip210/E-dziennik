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
    "SELECT klasa 
    FROM klasy 
    WHERE klasa = '".$_POST['klasa']."'";
$login = mysqli_query($conn, $log);
if (mysqli_num_rows($login) != 0) {
    header("location: dodajKlase.php?zajety=2");
}else {
    $wychowawca =
        "SELECT nauczycielId
        FROM nauczyciele
        WHERE Email ='". $_POST["Email"] ."'";
    $result = mysqli_query($conn,$wychowawca);
    $row = mysqli_fetch_assoc($result);
    $Zapytanie =
        "INSERT INTO klasy (klasa,wychowawca) 
              VALUES ('" . $_POST["klasa"] . "','" . $row["nauczycielId"] . "')";


    if ($conn->query($Zapytanie) === true) {
        echo "New record created successfully";
        header("location: klasy.php?dodano=2");
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>