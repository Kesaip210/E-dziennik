<?php
session_start();
require_once('role.php');
if (isset($_SESSION['zalogowany'])
    AND $_SESSION['zalogowany'] == ROLA_NAUCZYCIEL){
    require_once('naglowek.php');
}else {
    require_once('naglowekpracownicy.php');
}
require_once('funkcje/link.php');
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie =  "
    SELECT *
    FROM nauczyciele,klasy,uczenie,przedmioty
    WHERE uczenie.nauczyciel = nauczyciele.nauczycielId
    AND klasy.klasaId = uczenie.uczonaKlasa
    AND przedmioty.przedmiotId = uczonyPrzedmiot
    ORDER BY nauczyciele.Nazwisko";
?>
<div id="tresc_pracownicy">
    <br>
    <center>
        <?php
        link1($_GET);
        ?>
        <a href="dodajUczenie.php"><i class="fa fa-user-plus fa-3x" style='padding: 5px;color: rgb(0,200,0)'></i></a>
        <table class="table" style="text-align: center">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nauczyciel</th>
                <th scope="col">Klasa</th>
                <th scope="col">Przedmiot</th>
                <th scope="col">Usuwanie</th>
            </tr>
            <?php
            $helena = 0;
            $result = mysqli_query($conn, $Zapytanie);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $helena++;
                    echo"<tr><td>".$helena."</td>";
                    echo"<td>" . $row["Imie"]." ". $row["Nazwisko"] ."</td>";
                    echo"<td><a href='klasa.php?klasa=" . $row["klasaId"] ."'>" . $row["klasa"] . "</a></td>";
                    echo"<td>" . $row["przedmiot"]. "</td>";
                    echo"<td><a href='usunUczenie.php?nauczyciel=".$row["nauczyciel"]."&klasa=".$row["uczonaKlasa"]."&przedmiot=".$row["uczonyPrzedmiot"]."'>";
                    echo"<i class='fa fa-trash fa-2x' style='padding-left: 5px;color: rgb(255,30,30)' aria-hidden='true'></i></a></td></tr>";
                }
            } else {
                echo "brak klas";
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

