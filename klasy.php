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
        <a href="dodajKlase.php"><i class="fa fa-user-plus fa-3x" style='padding: 5px;color: rgb(0,200,0)'></i></a>
        <table class="table" style="text-align: center">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Wychowawca</th>
                <th scope="col">Klasa</th>
                <th scope="col">Ilość uczniów</th>
                <th scope="col">Edycja</th>
                <th scope="col">Usuwanie</th>
            </tr>
            <?php
            $helena = 0;
            require_once('funkcje/bazadanych.php');
            $conn = polaczenieBaza();
            $Zapytanie =  "
            SELECT 
                klasy.klasaId as klasaId,
                klasy.klasa,
                klasy.wychowawca,
                nauczyciele.Email,
                (
                    SELECT COUNT(sub_przydzial.uczen)
                    FROM klasy sub_klasy
                    LEFT JOIN przydzial sub_przydzial ON sub_przydzial.klasa1 = sub_klasy.klasaId
                    WHERE sub_klasy.klasaId = klasy.klasaId
                    GROUP BY sub_klasy.klasaId 
                ) as liczbaUczniow
            FROM klasy
            LEFT JOIN nauczyciele ON nauczyciele.nauczycielId = klasy.wychowawca";
            $result = mysqli_query($conn, $Zapytanie);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $helena++;
                    echo"<tr><td>".$helena."</td>";
                    echo"<td>" . $row["Email"]. "</td>";
                    echo"<td><a href='klasa.php?klasa=" . $row["klasaId"] ."'>" . $row["klasa"] . "</a></td>";
                    echo"<td>" . $row["liczbaUczniow"] . "</td>";
                    echo"<td> <a href='edytujKlase.php?id=".$row["klasaId"]."'><i class='fa fa-pencil-square-o fa-2x' style='padding-right: 5px' aria-hidden='true'></i></a></td>";
                    echo"<td><a href='usunKlase.php?id=".$row["klasaId"]."'><i class='fa fa-trash fa-2x' style='padding-left: 5px;color: rgb(255,30,30)' aria-hidden='true'></i></a></td></tr>";
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

