<?php
session_start();
require_once('role.php');
require_once('funkcje/bazadanych.php');
if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK){
    $tresc = $_POST['tresc'];
    $tytul = $_POST['tytul'];
    $data = date("Y-m-d H:i:s");
    $Zapytanie2 = "INSERT INTO `posty`(`tresc`, `tytul`, `data`) VALUES ('$tresc','$tytul','$data')";
$result2 = mysqli_query($conn,$Zapytanie2);
    mysqli_close($conn);
    header("location: posty.php");
} else {
    header("location: posty.php");
}