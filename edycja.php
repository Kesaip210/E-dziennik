<?php 
session_start();
require_once('role.php');
if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != ROLA_PRACOWNIK) {
header("Location: /");
}

ini_set( 'display_errors', 'On' ); 
error_reporting( E_ALL );
$data=date("Y-m-d");
$Zmiana=0;
// PRINT($data);

require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie =
    "SELECT 
        Nazwisko,
        Imie,
        Login,
        Haslo 
    FROM Pracownicy 
    WHERE PracownikId='".$_POST['id']."'";
    $result = mysqli_query($conn, $Zapytanie);
      if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
            $imie = $row["Imie"];
            $nazwisko = $row["Nazwisko"];
            $login = $row["Login"];
            $haslo = $row["Haslo"];
        }
    }

    
if ($_POST["haslo"] == $_POST["haslo2"]) {
    if ($imie != $_POST['Imie']) {$Zmiana=1;}
    if ($nazwisko != $_POST['Nazwisko']) {$Zmiana=1;}
    if ($haslo != $_POST['haslo']) {$Zmiana=1;}
    if ($login != $_POST['Login']) {$Zmiana=2;}
    $Imie = str_replace(" ",'',$_POST['Imie']);
    $Login = str_replace(" ",'',$_POST['Login']);
  
    // $a = strpos($_POST['haslo'], " ");
    // print($a);
    if (strpos($_POST['haslo'], " ")) {
      header("location: pracownicy.php?haslo=1");
    } else { 
        if (!preg_match("/^[a-zA-Z]+$/",$_POST['Nazwisko'])) {
          header("location: pracownicy.php?zlenazwisko=1");
        } else {
        if (!preg_match("/^[a-zA-Z]+$/",$Imie)) {
          header("location: pracownicy.php?zleimie=1");
        } else {
        if (!preg_match("/^[a-z0-9]*$/",$Login)) {
          header("location: pracownicy.php?zlylogin=1");
        } else {
    if ($Zmiana == 2) {

        $log =
            "SELECT Login 
            FROM Pracownicy 
            WHERE Login = '".$_POST['Login']."'";
        $login = mysqli_query($conn, $log);
        if (mysqli_num_rows($login) != 0) {
            header("location: pracownicy.php?zajety=2");
        } else {
            $Zapytanie =
                "UPDATE Pracownicy 
                SET Imie='".$Imie."',Nazwisko='".$_POST['Nazwisko']."',Login='".$Login."',Haslo='".$_POST['haslo']."' 
                WHERE PracownikId='".$_POST['id']."'";
            if ($conn->query($Zapytanie) === TRUE) {
                echo "New record created successfully";
                
                header("location: pracownicy.php?zedytowano=1");
            } else {
                echo "Error: " . $conn->error;
            }
    }
    } else {
    
        if ($Zmiana == 1) {
    $Zapytanie =
        "UPDATE Pracownicy 
        SET Imie='".$_POST['Imie']."',Nazwisko='".$_POST['Nazwisko']."',Haslo='".$_POST['haslo']."' 
        WHERE PracownikId='".$_POST['id']."'";
    

if ($conn->query($Zapytanie) === TRUE) {
    echo "New record created successfully";
    header("location: pracownicy.php?zedytowano=1");
  } else {
    echo "Error: " . $conn->error;
  }
  }else{
      header("location: pracownicy.php?!zmiany=1");
  }
}
  $conn->close();
}
}
}
}
} else {
    header("location: edytuj.php?zlehaslo=1");
}
?>