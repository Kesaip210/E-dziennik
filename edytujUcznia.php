<?php
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie3 =
    "SELECT klasa1
    FROM przydzial
    WHERE uczen =".$_GET['id'];
$result3 = mysqli_query($conn,$Zapytanie3);
$row3 = mysqli_fetch_assoc($result3);
$Zapytanie =
    "SELECT 
        Nazwisko,
        Imie,
        Email,
        uczenId,
        Haslo
    FROM uczniowie 
    WHERE uczenId=".$_GET['id'];
$result = mysqli_query($conn, $Zapytanie);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $imie = $row["Imie"];
        $nazwisko = $row["Nazwisko"];
        $login = $row["Email"];
        $haslo = $row["Haslo"];
    }
    print('');
} else {
    echo "0 results";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ZSET - Uczniowie</title>
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
?>
<div id="tresc_pracownicy">
    <br>
    <br>
    <?php
    if (isset($_GET["zlehaslo"])) {
        print("<span style='color: red'>Hasła nie zgadzają się</span><br />");
    }
    ?>
    <div class="container">
        <br>
        <form action='edycjaUcznia.php' method="post" id="baza" style="color:white;">
            <label for='Imie'><b>Imie</b></label>
            <input type="text" placeholder="Wprowadź Imię" class="form-control" name="Imie" value="<?php print($imie) ?>" required/>
            <label for='Nazwisko'><b>Nazwisko</b></label>
            <input type="text" placeholder="Wprowadź nazwisko" class="form-control" name="Nazwisko" value="<?php print($nazwisko) ?>" required/>
            <label for="klasa">Klasa:</label>
            <br>
            <select id="klasa" name="klasa">
                <?php
                $Zapytanie2 =
                    "SELECT klasa,klasaId
                    FROM klasy";
                $result2 = mysqli_query($conn, $Zapytanie2);
                if ($result2->num_rows > 0) {
                    while($row2 = $result2->fetch_assoc()) {
                        echo"<option ";
                        if ($row2["klasaId"] == $row3["klasa1"]){echo"selected";}
                        echo">" . $row2["klasa"] . "</option>";
                    }
                }else{
                    echo "0 results";
                }
                ?>
            </select>
            <br>
            <label for='Email'><b>Email</b></label>
            <input type="text" placeholder="Wprowadź login" class="form-control" name="Email" value="<?php print($login) ?>" required/>
            <label for='Login'><b>hasło</b></label>
            <input name="haslo" id="haslo" type="password" class="form-control" onkeyup='check();' value="<?php print($haslo) ?>" required/>
            </label>
            <br>
            <label for='Login'><b>Powtórz hasło</b></label>
            <input type="password" name="haslo2" id="haslo2" class="form-control"  onkeyup='check();' value="<?php print($haslo) ?>" required/>
            <span  id='potwierdzenie'></span>
            </label>
            <center>
                <a href="uczniowie.php"><span class="btn btn-danger" style="margin: 10px;"  id="dodaj">Cofnij</span></a>
                <button class="btn btn-primary" style="margin: 10px;" id="dodaj">Edytuj</button>
            </center>
            <input type="hidden" name="id" value="<?php print($_GET['id']) ?>" />
        </form>
    </div>
</div>
<?php
require_once('stopka.php');
?>
</body>
</html>
