<?php
session_start();
require_once('funkcje/bazadanych.php');
require_once('role.php');
$conn = polaczenieBaza();
$Zapytanie =
    "SELECT 
        nazwa,
        opis,
        widoczne,
        dataZakonczenia,
        nauczyciel,
        klasa,
        przedmiot
      FROM zadania 
      WHERE id=".$_GET['id'];
$result = mysqli_query($conn, $Zapytanie);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $nazwa = $row["nazwa"];
        $opis = $row["opis"];
        $widoczne = $row["widoczne"];
        $data = $row["dataZakonczenia"];
        $nauczyciel = $row["nauczyciel"];
        $klasa = $row["klasa"];
        $przedmiot = $row["przedmiot"];
    }
    print('');
} else {
    echo "0 results";
}
if ($_SESSION['Id'] != $nauczyciel){
    header("location:/?nie");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ZSET - Zadania</title>
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
if (isset($_SESSION['zalogowany'])
    AND $_SESSION['zalogowany'] == ROLA_NAUCZYCIEL){
    require_once('naglowek.php');
}else {
    require_once('naglowekpracownicy.php');
}
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
        <form action='edycjaZadanie.php' method="post" id="baza" style="color:white;">
            <label for='nazwa'><b>Nazwa</b></label>
            <input type="text" placeholder="Wprowadź Nazwę" class="form-control" name="nazwa" value="<?php print($nazwa) ?>" required/>
            <label for='opis'><b>Opis</b></label>
            <input type="text" placeholder="Wprowadź Opis" class="form-control" name="opis" value="<?php print($opis) ?>" />
            <label for='widoczne'><b>Widoczne</b></label>
            <br>
            <select id="widoczne" name="widoczne">
                <option selected>Nie</option>
                <option>Tak</option>
            </select>
            <br>
            <label for='data'><b>Data Zakończenia</b></label>
            <input type="datetime-local" class="form-control" placeholder="Wprowadź date" name="data" value="<?php print($data) ?>" required/>
            <center>
                <a href="zadania.php?nauczyciel=<?php echo $nauczyciel."&klasa=".$klasa."&przedmiot=".$przedmiot ?>">
                    <span class="btn btn-danger" style="margin: 10px;"  id="dodaj">Cofnij</span>
                </a>
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
