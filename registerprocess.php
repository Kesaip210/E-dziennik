<?php
ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
$data=date("Y-m-d");
require_once('role.php');
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie3 =
    "SELECT Email,Haslo,LoginId,hash
    FROM loginy 
    WHERE Email='".$_POST["email"]."' 
    AND Haslo='".$_POST["kod"]."'";
$odp = mysqli_query($conn,$Zapytanie3);
if ($foundRows = mysqli_num_rows($odp)!=0) {

    $Update =
        "UPDATE loginy 
        SET potwierdzone='T' 
        WHERE Email='" . $_POST["email"] . "' 
        AND Haslo='" . $_POST["kod"] . "'";

    if ($conn->query($Update) === true) {
        echo "New record created successfully";
    } else {
        header("Location: /?zlykod=1");
    }
} else {
    header("Location: /?zlykod=1");
    die;
}
$mail =
    "SELECT Email 
    FROM loginy 
    WHERE potwierdzone = 'T' 
    AND Email = '".$_POST['email']."'";
$email = mysqli_query($conn, $mail);
if (mysqli_num_rows($email) == 0) {
  header("Location: /?nie");
} else {
$log =
    "SELECT Email 
    FROM Uzytkownicy 
    WHERE Email = '".$_POST['email']."'";
$login = mysqli_query($conn, $log);
if (mysqli_num_rows($login) != 0) {
  header("Location: /?zajety=1");
} else {
  $Imie = str_replace(" ",'',$_POST['imie']);
  $Login = str_replace(" ",'',$_POST['email']);
$password = $_POST['haslo'];
  if (strpos($_POST['haslo'], " ")) {
    header("Location: /?haslo=1");
  } else { 
      if (!preg_match("/^[a-zA-Z]+$/",$_POST['nazwisko'])) {
        header("Location: /?zlenazwisko=1");
      } else {
      if (!preg_match("/^[a-zA-Z]+$/",$Imie)) {
        header("Location: /?zleimie=1");
      } else {
        if (!filter_var($Login, FILTER_VALIDATE_EMAIL)) {
            header("Location: /?zlyemail=1");
        } else {      
      if ($_POST["haslo"] == $_POST["haslo2"]) {
          $Zapytanie =
              "INSERT INTO Uzytkownicy (Imie,Nazwisko,Email,Haslo,DataDolaczenia) 
              VALUES ('".$Imie."','".$_POST["nazwisko"]."','".$Login."','".$password."','".$data."')";
          

          $Zapytanie2 =
              "SELECT Nazwisko,Imie,OsobaId
                FROM Uzytkownicy 
                WHERE Email='".$_POST["login"]."' 
                AND Haslo='".$_POST["haslo"]."'";
          $result = mysqli_query($conn, $Zapytanie2);
          $row = mysqli_fetch_assoc($result);
          $_SESSION['Id'] = $row['OsobaId'];
          $_SESSION['zalogowany'] = ROLA_OSOBA;
          $_SESSION['time']     = time()+600;
      if ($conn->query($Zapytanie) === TRUE) {
          echo "New record created successfully";
          header("Location: /?dodano=2");
        } else {
          echo "Error: " . $conn->error;
        }
        
        $conn->close();
      } else {
        header('location: /?haslo=1');
    }
  }
  }
  }
  }
} 
}
?>