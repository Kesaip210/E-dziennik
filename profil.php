<?php
session_start();
if (!isset($_SESSION['zalogowany'])){
    header("Location: /");
    exit;
}
?>
<?php
require_once('naglowek.php');
require_once('funkcje/link.php');
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();

if (isset($_GET["uczen"])){
$Zapytanie =
    "SELECT Imie,Nazwisko,Email
    FROM uczniowie
    WHERE uczenId ='".$_GET["uczen"]."'";
$result = mysqli_query($conn,$Zapytanie);
$row = mysqli_fetch_assoc($result);
$imie = $row["Imie"];
$nazwisko = $row["Nazwisko"];
$email = $row["Email"];
} elseif (isset($_GET["nauczyciel"])){
    $Zapytanie =
        "SELECT Imie,Nazwisko,Email
    FROM nauczyciele
    WHERE nauczycielId ='".$_GET["nauczyciel"]."'";
    $result = mysqli_query($conn,$Zapytanie);
    $row = mysqli_fetch_assoc($result);
    $imie = $row["Imie"];
    $nazwisko = $row["Nazwisko"];
    $email = $row["Email"];
} elseif (isset($_GET["uzytkownik"])){
    $Zapytanie =
        "SELECT Imie,Nazwisko,Email
    FROM Uzytkownicy
    WHERE OsobaId ='".$_GET["uzytkownik"]."'";
    $result = mysqli_query($conn,$Zapytanie);
    $row = mysqli_fetch_assoc($result);
    $imie = $row["Imie"];
    $nazwisko = $row["Nazwisko"];
    $email = $row["Email"];
} elseif (isset($_GET["pracownik"])){
    $Zapytanie =
        "SELECT Imie,Nazwisko
    FROM Pracownicy
    WHERE PracownikId ='".$_GET["pracownik"]."'";
    $result = mysqli_query($conn,$Zapytanie);
    $row = mysqli_fetch_assoc($result);
    $imie = $row["Imie"];
    $nazwisko = $row["Nazwisko"];
} else {
    $imie = "null";
    $nazwisko = "null";
    $email = "null";
}
link1($_GET);
?>
<div class="profil">
    <br><br><br>
    <div class="profil2">
        <div id="tresc7">
            </br>
            </br>
            </br></br>

            <p style="font-size: 75px; margin-left: 36px"> Dane osobiste</p> <br><br>
            <br><br>
            <h1>Imię: <?php print($imie) ?></h1> <br><br>
            <h1>Nazwisko: <?php print($nazwisko) ?></h1> <br><br>
<?php if (!isset($_GET["pracownik"])){ ?>
            <h1>E-mail: <?php print($email) ?></h1> <br><br>
<?php } ?>
            <br><br><br><br>
        </div>
    </div>
    <br><br><br><br><br>
</div>
<?php
require_once('stopka.php');
?>
</body>
</html>