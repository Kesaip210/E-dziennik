<?php 
session_start();
require_once('role.php');
$conn = polaczenieBaza();
if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != ROLA_PRACOWNIK) {
header("Location: /");
}

ini_set( 'display_errors', 'On' ); 
error_reporting( E_ALL );

$data=date("Y-m-d");

$log =
    "SELECT Login 
    FROM Pracownicy 
    WHERE Login = '".$_POST['login']."'";
$login = mysqli_query($conn, $log);
if (mysqli_num_rows($login) != 0) {
  header("location: dodaj.php?zajety=2");
} else {
  $Imie = str_replace(" ",'',$_POST['Imie']);
  $Login = str_replace(" ",'',$_POST['login']);

  if (strpos($_POST['haslo'], " ")) {
    header("location: dodaj.php?haslo=1");
  } else { 
      if (!preg_match("/^[a-zA-Z]+$/",$_POST['Nazwisko'])) {
        header("location: dodaj.php?zlenazwisko=1");
      } else {
      if (!preg_match("/^[a-zA-Z]+$/",$Imie)) {
        header("location: dodaj.php?zleimie=1");
      } else {
      if (!preg_match("/^[a-z0-9]*$/",$Login)) {
        header("location: dodaj.php?zlylogin=1");
      } else {
      if ($_POST["haslo"] == $_POST["haslo2"]) {
          $Zapytanie =
              "INSERT INTO Pracownicy (Imie,Nazwisko,Login,Haslo,RozpoczeciePracy) 
              VALUES ('".$Imie."','".$_POST["Nazwisko"]."','".$Login."','".$_POST["haslo"]."','".$data."')";


      if ($conn->query($Zapytanie) === TRUE) {
          echo "New record created successfully";
          header("location: pracownicy.php?dodano=2");
        } else {
          echo "Error: " . $conn->error;
        }
        
        $conn->close();
      } else {
          header("location: dodaj.php?zlehaslo=1");
    }
  }
  }
  }
  }
}
?>