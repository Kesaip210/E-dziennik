<?php
session_start();
require_once('role.php');
require_once('funkcje/bazadanych.php');
if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK){
    $id = $_GET['id'];
    $Zapytanie3 = "SELECT * FROM komentarze WHERE id = $id";
    $result3 = mysqli_query($conn,$Zapytanie3);
    $row3 = mysqli_fetch_assoc($result3);
    $id2=$row3['id_postu'];
    $Zapytanie2 = "DELETE FROM komentarze WHERE id = $id";
$result2 = mysqli_query($conn,$Zapytanie2);
mysqli_close($conn);
header("location: post.php?id=$id2");
} else {
header("location: post.php?id=$id2");
}