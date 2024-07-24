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
    FROM klasy,uczenie,przedmioty
    WHERE uczenie.nauczyciel ='" .$_SESSION['Id']."'
    AND klasy.klasaId = uczenie.uczonaKlasa
    AND przedmioty.przedmiotId = uczonyPrzedmiot";
?>
<div id="tresc_pracownicy">
    <br>
    <center>
        <?php
        link1($_GET);
        ?>
        <table class="table" style="text-align: center">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Klasa</th>
                <th scope="col">Przedmiot</th>
                <th scope="col"> </th>
            </tr>
            <?php
            $helena = 0;
            $result = mysqli_query($conn, $Zapytanie);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $helena++;
                    echo"<tr><td>".$helena."</td>";
                    echo"<td>" . $row["klasa"]. "</td>";
                    echo"<td>" . $row["przedmiot"]. "</td>";
                    echo"<td><a href='zadania.php?nauczyciel=";
                    echo $row["nauczyciel"]."&klasa=".$row["klasaId"]."&przedmiot=".$row["przedmiotId"]."'>---></a></td>";
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

