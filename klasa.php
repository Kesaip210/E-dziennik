<?php
session_start();
require_once('role.php');
require_once('funkcje/link.php');
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
if (isset($_SESSION['zalogowany'])
    AND $_SESSION['zalogowany'] == ROLA_NAUCZYCIEL){
    require_once('naglowek.php');
}else {
    require_once('naglowekpracownicy.php');
}
$Zapytanie =  "
    SELECT 
        klasy.klasa,
        klasy.wychowawca,
        uczniowie.Email,
        uczniowie.Imie,
        uczniowie.Nazwisko,
        uczniowie.uczenId,
        nauczyciele.Imie AS Imie2,
        nauczyciele.Nazwisko AS Nazwisko2
    FROM klasy
    LEFT JOIN nauczyciele ON nauczyciele.nauczycielId = klasy.wychowawca
    LEFT JOIN przydzial ON przydzial.klasa1 = klasy.klasaId
    LEFT JOIN uczniowie ON uczniowie.uczenId = przydzial.uczen
    WHERE klasy.klasaId ='" .$_GET["klasa"]."'
    ORDER BY uczniowie.Nazwisko";
$result2 = mysqli_query($conn, $Zapytanie);
$row2 = mysqli_fetch_assoc($result2)
?>
<div id="tresc_pracownicy">
    <br>
    <center>
        <?php
        link1($_GET);
        echo"<h1 style='color: rgb(0, 174, 255)' class='cien'>Klasa ".$row2["klasa"]."</h1>";
        echo"<h3 style='color: rgb(0, 174, 255)'>Wychowawca: ".$row2["Imie2"]." ".$row2["Nazwisko2"]."</h3>";
        if (isset($_SESSION['zalogowany']) AND $_SESSION['zalogowany'] == ROLA_PRACOWNIK) {
        echo'<br>';
        echo'<a href="dodajUcznia.php"><i class="fa fa-user-plus fa-3x" style="padding: 5px;color: rgb(0,200,0)"></i></a>';
        }
        ?>
        <table class="table" style="text-align: center">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Imie</th>
                <th scope="col">Nazwisko</th>
                <th scope="col">Email</th>
                <?php
                if (isset($_SESSION['zalogowany']) AND $_SESSION['zalogowany'] == ROLA_PRACOWNIK) {
                echo'<th scope="col">Edycja</th>';
                echo'<th scope="col">Usuwanie</th>';
                }
                ?>
            </tr>
            <?php
            $helena = 0;
            $result = mysqli_query($conn, $Zapytanie);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $helena++;
                    echo"<tr><td>".$helena."</td>";
                    echo"<td>" . $row["Imie"]. "</td>";
                    echo"<td>" . $row["Nazwisko"]. "</td>";
                    echo"<td><a href='profil.php?uczen=" . $row["uczenId"] ."'>" . $row["Email"] . "</a></td>";
                    if (isset($_SESSION['zalogowany']) AND $_SESSION['zalogowany'] == ROLA_PRACOWNIK) {
                        echo "<td> <a href='edytujUcznia.php?id=" . $row["uczenId"] . "'><i class='fa fa-pencil-square-o fa-2x' style='padding-right: 5px' aria-hidden='true'></i></a></td>";
                        echo "<td><a href='usunUcznia.php?id=" . $row["uczenId"] . "'><i class='fa fa-trash fa-2x' style='padding-left: 5px;color: rgb(255,30,30)' aria-hidden='true'></i></a></td></tr>";
                    }
                }
            } else {
                echo "0 results";
            }
            ?>
        </table>
    </center>
</div>
<?php
require_once('stopka.php');
?>
</body>
</html>

