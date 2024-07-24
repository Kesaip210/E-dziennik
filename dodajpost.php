<!DOCTYPE html>
<html>
<head>
    <title>ZSET - Posty</title>
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
        <form action='addpost.php' method="post" id="baza" style="color:white;">
            <label for='tytul'><b>Tytuł</b></label>
            <input type="text" class="form-control" placeholder="Wprowadź Tytuł" name="tytul" required/>
            <label for='tresc'><b>Treść</b></label>
            <textarea rows="20" cols="121" placeholder="Wprowadź Treść" name="tresc" required></textarea>
            <center>
                <a href="posty.php"><span class="btn btn-danger" style="margin: 10px;"  id="dodaj">Cofnij</span></a>
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

