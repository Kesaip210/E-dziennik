<?php
session_start();
require_once('role.php');
require_once('funkcje/bazadanych.php');
if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK){
    $Zapytanie2 = "DELETE FROM posty WHERE id =". $_GET['id'];
$result2 = mysqli_query($conn,$Zapytanie2);
    mysqli_close($conn);
    header("location: posty.php");
} else {
    header("location: posty.php");
}