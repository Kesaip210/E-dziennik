<?php
session_start();
if (isset($_SESSION['zalogowany'])
    AND $_SESSION['zalogowany']>300
    AND $_SESSION['zalogowany']<400){
    require_once('naglowek.php');
}else {
    require_once('naglowekpracownicy.php');
}
if ($_SESSION['zalogowany'] != 30 .$_GET["klasa"]){
    header("location:/?nie");
}
require_once('funkcje/link.php');
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie =  "
    SELECT *
    FROM zadania
    WHERE zadania.nauczyciel ='" .$_GET["nauczyciel"]."'
    AND zadania.klasa ='" .$_GET["klasa"]."'
    AND zadania.przedmiot ='" .$_GET["przedmiot"]."'
    AND zadania.widoczne = TRUE";
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
                <th scope="col">Zadanie</th>
                <th scope="col">Zakończenie</th>
                <th scope="col"> </th>
            </tr>
            <?php
            $helena = 0;
            $result = mysqli_query($conn, $Zapytanie);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $helena++;
                    echo"<tr><td>".$helena."</td>";
                    echo"<td>" . $row["nazwa"]. "</td>";
                    echo"<td>" . $row["dataZakonczenia"]. "</td>";
                    echo"<td><a href='zadanieUczen.php?zadanie=".$row["id"]."'>---></a></td>";
                }
            } else {
                echo "brak zadań";
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

