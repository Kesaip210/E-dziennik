<!DOCTYPE html>
<html>
<head>
    <title>ZSET - Klasy</title>
    <script>
        var check = function() {
            if (document.getElementById('haslo').value ==
                document.getElementById('haslo2').value) {
                document.getElementById('potwierdzenie').style.color = 'green';
                document.getElementById('potwierdzenie').innerHTML = 'zgodne';
                document.getElementById('dodaj').disabled = false;
            } else {
                document.getElementById('potwierdzenie').style.color = 'red';
                document.getElementById('potwierdzenie').innerHTML = 'nie zgodne';
                document.getElementById('dodaj').disabled = true;
            }
        }
    </script>
</head>
<body>
<?php
require_once('naglowekpracownicy.php');
require_once('funkcje/link.php');
?>
<div id="tresc_pracownicy">
    <?php
    link1($_GET);
    ?>
    <br>
    <br>
    <div class="container">
        <br>
        <form action='bazaKlasa.php' method="post" id="baza" style="color:white;">
            <label for='klasa'><b>Klasa</b></label>
            <input type="text" class="form-control" placeholder="Wprowadź klasę" name="klasa" required/>
            <br>
            <select id="Email" name="Email">
                <?php
                $helena = 0;
                require_once('funkcje/bazadanych.php');
                $conn = polaczenieBaza();
                $Zapytanie =
                "SELECT 
                    nauczyciele.Email,
                    nauczyciele.nauczycielId
                FROM nauczyciele
                WHERE nauczyciele.nauczycielId NOT IN (SELECT sub_klasy.wychowawca FROM klasy sub_klasy)";
                $result = mysqli_query($conn, $Zapytanie);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $helena++;
                        echo "<option>" . $row["Email"] . "</option>";
                    }
                }else{
                    echo "0 results";
                }
                ?>
            </select>
            <center>
                <a href="klasy.php"><span class="btn btn-danger" style="margin: 10px;"  id="dodaj">Cofnij</span></a>
                <button class="btn btn-primary"  style="margin: 10px;" id="dodaj">Dodaj</button>
            </center>
        </form>
    </div>
</div>
<?php
require_once('stopka.php');
?>
</body>
</html>
