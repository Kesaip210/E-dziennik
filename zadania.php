<?php
session_start();
require_once('role.php');
if (isset($_SESSION['zalogowany'])
    AND $_SESSION['zalogowany'] == ROLA_NAUCZYCIEL){
    require_once('naglowek.php');
}else {
    require_once('naglowekpracownicy.php');
}
if ($_SESSION['Id'] != $_GET["nauczyciel"]){
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
    AND zadania.nauczyciel ='" .$_SESSION["Id"]."'";
?>
<div id="tresc_pracownicy">
    <br>
    <center>
        <?php
        link1($_GET);
        ?>
        <a href='dodajZadanie.php?nauczyciel=<?php echo $_GET["nauczyciel"]."&klasa=".$_GET["klasa"]."&przedmiot=".$_GET["przedmiot"] ?>'<i class="fa fa-user-plus fa-3x" style='padding: 5px;color: rgb(0,200,0)'></i></a>
        <table class="table" style="text-align: center">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Zadanie</th>
                <th scope="col">Zakończenie</th>
                <th scope="col">Widoczne</th>
                <th scope="col"> </th>
                <th scope="col">Edycja</th>
                <th scope="col">Usuwanie</th>
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
                    echo"<td>";
                    if ($row["widoczne"] == 0){
                        print("Nie");
                    }elseif ($row["widoczne"] == 1){
                        print("Tak");
                    }
                    echo"</td>";
                    echo"<td><a href='zadanie.php?zadanie=".$row["id"]."'>---></a></td>";
                    echo"<td> <a href='edytujZadanie.php?id=".$row["id"]."'><i class='fa fa-pencil-square-o fa-2x' style='padding-right: 5px' aria-hidden='true'></i></a></td>";
                    echo"<td><a href='usunZadanie.php?id=".$row["id"]."'><i class='fa fa-trash fa-2x' style='padding-left: 5px;color: rgb(255,30,30)' aria-hidden='true'></i></a></td></tr>";
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

