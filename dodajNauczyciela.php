<!DOCTYPE html>
<html>
<head>
    <title>ZSET - Nauczyciele</title>
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
        <form action='bazaNauczyciel.php' method="post" id="baza" style="color:white;">
            <label for='Imie'><b>Imie</b></label>
            <input type="text" class="form-control" placeholder="Wprowadź Imię" name="Imie" required/>
            <label for='Nazwisko'><b>Nazwisko</b></label>
            <input type="text" class="form-control" placeholder="Wprowadź nazwisko" name="Nazwisko" required/>
            <label for='Email'><b>Email</b></label>
            <input type="text" class="form-control" placeholder="Wprowadź Email" name="Email" required/>
            <label for='Haslo'><b>hasło</b></label>
            <input name="haslo" class="form-control" id="haslo" placeholder="Wprowadź hasło" type="password" onkeyup='check();'required/>
            </label>
            <br>
            <label for='Haslo'><b>Powtórz hasło</b></label>
            <input type="password" class="form-control" name="haslo2" placeholder="Wprowadź hasło" id="haslo2"  onkeyup='check();'required/>
            <span id='potwierdzenie'></span>
            </label>
            <center>
                <a href="nauczyciele.php"><span class="btn btn-danger" style="margin: 10px;"  id="dodaj">Cofnij</span></a>
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

