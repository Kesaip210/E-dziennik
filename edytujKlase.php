<?php
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie =
    "SELECT 
        klasa,
        wychowawca
      FROM klasy
      WHERE klasaId=".$_GET['id'];
$result = mysqli_query($conn, $Zapytanie);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $klasa = $row["klasa"];
        $wychowawca = $row["wychowawca"];
    }
    print('');
} else {
    echo "0 results";
}
$Zapytanie2 =
    "SELECT Email
    FROM nauczyciele
    WHERE nauczycielId ='". $wychowawca. "'";
$result2 = mysqli_query($conn,$Zapytanie2);
$row2 = mysqli_fetch_assoc($result2);
?>
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
        <form action='edycjaKlasy.php' method="post" id="baza" style="color:white;">
            <label for='Klasa'><b>Klasa</b></label>
            <input type="text" placeholder="Wprowadź klase" class="form-control" name="klasa" value="<?php print($klasa) ?>" required/>
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
                WHERE nauczyciele.nauczycielId NOT IN (SELECT sub_klasy.wychowawca FROM klasy sub_klasy) 
                OR nauczyciele.nauczycielId ='".$wychowawca."'";
                $result = mysqli_query($conn, $Zapytanie);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $helena++;
                        echo "<option ";
                        if ($row["Email"] == $row2["Email"]){echo"selected";}
                        echo">" . $row["Email"] . "</option>";
                    }
                }else{
                    echo "0 results";
                }
                ?>
            </select>
            <center>
                <a href="klasy.php"><span class="btn btn-danger" style="margin: 10px;"  id="dodaj">Cofnij</span></a>
                <button class="btn btn-primary" style="margin: 10px;" id="dodaj">Edytuj</button>
            </center>
            <input type="hidden" name="id" value="<?php print($_GET['id']) ?>" />
        </form>
