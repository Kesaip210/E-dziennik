<?php
session_start();
require_once('role.php');
require_once('funkcje/bazadanych.php');
if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK){
    $tresc = $_POST['tresc'];
    $tytul = $_POST['tytul'];
    $Zapytanie2 = "UPDATE `posty` SET `tresc`='$tresc',`tytul`='$tytul' WHERE `id` =". $_POST['id'];
$result2 = mysqli_query($conn,$Zapytanie2);
    mysqli_close($conn);
    header("location: posty.php");
} else {
    header("location: posty.php");
}