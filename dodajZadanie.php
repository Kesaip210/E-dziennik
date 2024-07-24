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
?>
<div id="tresc_pracownicy">
    <?php
    link1($_GET);
    ?>
    <br>
    <br>
    <div class="container">
        <br>
        <form action='bazaZadanie.php' method="post" id="baza" style="color:white;">
            <label for='Nazwa'><b>Nazwa</b></label>
            <input type="text" class="form-control" placeholder="Wprowadź Nazwę" name="Nazwa" required/>
            <label for='Opis'><b>Opis</b></label>
            <input height="" type="text" class="form-control" placeholder="(Opcjonalne) Wprowadź opis" name="Opis"/>
            <label for='Widoczne'><b>Widoczne</b></label>
            <br>
            <select id="Widoczne" name="Widoczne">
                <option selected>Nie</option>
                <option>Tak</option>
            </select>
            <br>
            <label for='Data'><b>Data Zakończenia</b></label>
            <input type="datetime-local" class="form-control" placeholder="Wprowadź date" name="Data" required/>
            <input type="hidden" name="nauczyciel" value="<?php print($_GET['nauczyciel']) ?>" />
            <input type="hidden" name="klasa" value="<?php print($_GET['klasa']) ?>" />
            <input type="hidden" name="przedmiot" value="<?php print($_GET['przedmiot']) ?>" />
            <center>
                <a href="Zadania.php?nauczyciel=<?php echo $_GET["nauczyciel"]."&klasa=".$_GET["klasa"]."&przedmiot=".$_GET["przedmiot"] ?>"><span class="btn btn-danger" style="margin: 10px;"  id="dodaj">Cofnij</span></a>
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
