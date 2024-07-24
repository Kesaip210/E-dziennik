<?php
session_start();
require_once('role.php');
require_once('funkcje/bazadanych.php');
require_once('funkcje/link.php');
require_once ('funkcje/imiona.php');
$conn = polaczenieBaza();
if (isset($_SESSION['Id'])) {
    $Zapytanie =
        "SELECT 
            Nazwisko,
            Imie,
            PracownikId
        FROM Pracownicy
        WHERE PracownikId = '" . $_SESSION['Id'] . "'";

    $result = mysqli_query($conn, $Zapytanie);
    $row = mysqli_fetch_assoc($result);
    $Zapytanie2 =
        "SELECT 
            Nazwisko,
            Imie,
            OsobaId
        FROM Uzytkownicy
        WHERE OsobaId = '" . $_SESSION['Id'] . "'";
    $result2 = mysqli_query($conn, $Zapytanie2);
    $row2 = mysqli_fetch_assoc($result2);
    $Zapytanie3 =
        "SELECT 
            Nazwisko,
            Imie,
            uczenId
        FROM uczniowie 
        WHERE uczenId = '". $_SESSION['Id'] . "'";
    $result3 = mysqli_query($conn, $Zapytanie3);
    $row3 = mysqli_fetch_assoc($result3);
    $Zapytanie4 =
        "SELECT 
            nazwisko,
            Imie,
            nauczycielId
        FROM nauczyciele 
        WHERE nauczycielId = '". $_SESSION['Id'] . "'";
    $result4 = mysqli_query($conn, $Zapytanie4);
    $row4 = mysqli_fetch_assoc($result4);
    if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK) {
        $imie = $row['Imie'];
    } elseif (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_OSOBA) {
        $imie = $row2['Imie'];
    } elseif (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_UCZEN){
        $imie = $row3['Imie'];
    } elseif (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_NAUCZYCIEL){
        $imie = $row4['Imie'];
    }
}
?>
<?php
require_once('naglowek.php');
?>
<div id="tresc">
    <?php
    link1($_GET);
    ?>
    <br>
    <p><p style="font-size:50px;" class="cien" style="centre">Witaj w ZSET</p>
    <p style="font-size:50px;" class="cien" style="centre"><?php if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']==ROLA_PRACOWNIK) {print (imie($imie));}
        elseif (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']==ROLA_OSOBA) {print (imie($imie));}
        elseif (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_UCZEN){print (imie($imie));}
        elseif (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_NAUCZYCIEL){print (imie($imie));}?></p>
    <div id="demo" class="carousel slide" data-ride="carousel">
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
        </ul>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="obrazy/szkola1.jpg" class="img-fluid rounded" style='padding: 2px' alt="Szkola1" width="600" height="500"> </br> </br> </br> </br> </br> </br> </br>
                <div class="carousel-caption">
                    <h3 style="color: white;">Budynek Szkoły</h3>
                    <p style="color: white"> wraz z boiskiem </p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="obrazy/parking.jpg" class="img-fluid rounded" alt="parking" width="800" height="700"> </br> </br> </br> </br> </br> </br> </br>
                <div class="carousel-caption">
                    <h3> Parking</h3>
                    <p> z nowo powstałym muralem </p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
require_once('stopka.php');
?>
</body>
</html>

