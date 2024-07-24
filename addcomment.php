<?php
session_start();
require_once('role.php');
require_once('funkcje/bazadanych.php');
if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_UCZEN){
    $Zapytanie2 = "SELECT Email FROM uczniowie WHERE uczenId =". $_SESSION['Id'];
} elseif (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_NAUCZYCIEL){
    $Zapytanie2 = "SELECT Email FROM nauczyciele WHERE nauczycielId =". $_SESSION['Id'];
} elseif (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_OSOBA){
    $Zapytanie2 = "SELECT Email FROM uzytkownicy WHERE OsobaId =". $_SESSION['Id'];
} elseif (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK){
    $Zapytanie2 = "SELECT Email FROM pracownicy WHERE PracownikId =". $_SESSION['Id'];
}
$result2 = mysqli_query($conn,$Zapytanie2);
$row2 = mysqli_fetch_assoc($result2);
    $email = $row2['Email'];
    $tresc = $_POST['tresc'];
    $id = $_POST['post'];
    $data = date("Y-m-d H:i:s");
    $Zapytanie =
    "INSERT INTO `komentarze`(`Email`, `tresc`, `data`, `id_postu`, `akceptacja`) VALUES ('$email','$tresc','$data','$id',0)";
    mysqli_query($conn,$Zapytanie);
    mysqli_close($conn);
    header("location: post.php?id=".$id."");