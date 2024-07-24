
<?php
session_start();
ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
require_once('role.php');
if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != ROLA_PRACOWNIK AND ($_SESSION['zalogowany'] != ROLA_UCZEN)) {
  header("Location: /?nie=1");
}
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie =
    "SELECT *
    FROM zadania
    WHERE id ='".$_POST["zadanie"]."'";
$result = mysqli_query($conn,$Zapytanie);
$row = mysqli_fetch_assoc($result);
if ($_SESSION['zalogowany'] != 30 .$row["klasa"]){
  header("location:/?nie");
}
$Zapytanie2 =
    "SELECT 
        uczniowie.Email,
        nauczyciele.Imie,
        nauczyciele.Nazwisko,
        klasa,
        przedmiot
    FROM
        nauczyciele,
        klasy,
        przedmioty,
        uczniowie,
        przydzial
    WHERE nauczycielId ='".$row["nauczyciel"]."'
    AND klasaId ='".$row["klasa"]."'
    AND przedmiotId ='".$row["przedmiot"]."'
    AND przydzial.klasa1 ='".$row["klasa"]."'
    AND przydzial.uczen ='".$_SESSION['Id']."'
    AND uczniowie.uczenId ='".$_SESSION['Id']."'";
$result2 = mysqli_query($conn,$Zapytanie2);
$row2 = mysqli_fetch_assoc($result2);
$target_dir = "/var/www/domex/uploads/".$row2["Imie"]."_".$row2["Nazwisko"]."/".$row2["klasa"]."/".$row2["przedmiot"]."/".$row["nazwa"]."/";//"/var/www/domex/uploads/";
$plik = $row2["Email"]."_".$_FILES["fileToUpload"]["name"];
$target_file = $target_dir . basename($plik);
$uploadOk = 1;
if (file_exists($target_file)) {
  header("location: zadanieUczen.php?zadanie=".$_POST["zadanie"]."&istnieje=1");
  $uploadOk = 0;
}
if ($uploadOk == 0) {
  echo "nie udało się";
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $plik)). " has been uploaded.";
    header("location: zadanieUczen.php?zadanie=".$_POST["zadanie"]."&udane=1");
  } else {
    header("location: zadanieUczen.php?zadanie=".$_POST["zadanie"]);
    print_r($_FILES);
  }
}
?>
