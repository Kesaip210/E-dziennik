<?php
session_start();
require_once('role.php');
require_once('funkcje/bazadanych.php');
if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK){
    $Zapytanie2 = "UPDATE `komentarze` SET `akceptacja`= 1 WHERE id =". $_GET['id'];
    $result2 = mysqli_query($conn,$Zapytanie2);
    $Zapytanie3 = "SELECT * FROM komentarze WHERE id=".$_GET['id'];
    $result3 = mysqli_query($conn,$Zapytanie3);
    $row3 = mysqli_fetch_assoc($result3);
    $id = $row3['id_postu'];
    mysqli_close($conn);
    header("location: post.php?id=". $id);
} else {
    header("location: post.php?id=". $id);
}