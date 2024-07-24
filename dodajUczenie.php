<!DOCTYPE html>
<html>
<head>
    <title>ZSET - Nauczanie</title>
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
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie =
    "SELECT Email
    FROM nauczyciele";
$Zapytanie2 =
    "SELECT przedmiot
    FROM przedmioty";
$Zapytanie3 =
    "SELECT klasa
    FROM klasy"
?>
<div id="tresc_pracownicy">
    <?php
    link1($_GET);
    ?>
    <br>
    <br>
    <div class="container">
        <br>
        <form action='bazaUczenie.php' method="post" id="baza" style="color:white;">
            <select id="Email" name="Email">
                <?php
                $result = mysqli_query($conn, $Zapytanie);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option>" . $row["Email"] . "</option>";
                    }
                }else{
                    echo "0 results";
                }
                ?>
            </select>
            <br>
            <select id="klasa" name="klasa">
                <?php
                $result = mysqli_query($conn, $Zapytanie3);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option>" . $row["klasa"] . "</option>";
                    }
                }else{
                    echo "0 results";
                }
                ?>
            </select>
            <select id="przedmiot" name="przedmiot">
                <?php
                $result = mysqli_query($conn, $Zapytanie2);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option>" . $row["przedmiot"] . "</option>";
                    }
                }else{
                    echo "0 results";
                }
                ?>
            </select>
            <center>
                <a href="uczenie.php"><span class="btn btn-danger" style="margin: 10px;"  id="dodaj">Cofnij</span></a>
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
