<?php
require_once('naglowekpracownicy.php');
require_once('funkcje/link.php');
?>
<div id="tresc_pracownicy">
    <br>
    <center>
        <?php
        link1($_GET);
        ?>
        <a href="dodajNauczyciela.php"><i class="fa fa-user-plus fa-3x" style='padding: 5px;color: rgb(0,200,0)'></i></a>
        <table class="table" style="text-align: center">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Imię</th>
                <th scope="col">Nazwisko</th>
                <th scope="col">Email</th>
                <th scope="col">Wychowawstwo</th>
                <th scope="col">Edycja</th>
                <th scope="col">Usuwanie</th>
            </tr>
            <?php
            $helena = 0;
            require_once('funkcje/bazadanych.php');
            $conn = polaczenieBaza();
            $Zapytanie =
                "SELECT 
                    nauczyciele.Imie,
                    nauczyciele.Nazwisko,
                    nauczyciele.Email,
                    nauczyciele.nauczycielId,
                    klasy.wychowawca
                FROM nauczyciele
                LEFT JOIN klasy ON nauczyciele.nauczycielId = klasy.wychowawca
                ORDER BY nauczyciele.Nazwisko";
            $result = mysqli_query($conn, $Zapytanie);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $helena++;
                    echo"<tr><td>".$helena."</td><td>" . $row["Imie"]. "</td>";
                    echo"<td>" . $row["Nazwisko"] . "</td>";
                    echo"<td><a href='profil.php?nauczyciel=" . $row["nauczycielId"] ."'>" . $row["Email"] . "</a></td><td><input type='checkbox' disabled ";
                    if ($row['wychowawca']==$row['nauczycielId']){print('checked');}
                    echo"></td>";
                    echo"<td><a href='edytujNauczyciela.php?id=".$row["nauczycielId"]."'><i class='fa fa-pencil-square-o fa-2x' style='padding-right: 5px' aria-hidden='true'></i></a></td>";
                    echo"<td><a href='usunNauczyciela.php?id=".$row["nauczycielId"]."'><i class='fa fa-trash fa-2x' style='padding-left: 5px;color: rgb(255,30,30)' aria-hidden='true'></i></a></td></tr>";
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

