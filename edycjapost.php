<!DOCTYPE html>
<html>
<head>
    <title>ZSET - Posty</title>
</head>
<body>
<?php
require_once('naglowekpracownicy.php');
require_once('funkcje/link.php');
require_once('funkcje/bazadanych.php');
$Zapytanie = "SELECT * FROM posty WHERE id =". $_GET['id'];
$result = mysqli_query($conn,$Zapytanie);
$row = mysqli_fetch_assoc($result);
?>
<div id="tresc_pracownicy">
    <?php
    link1($_GET);
    ?>
    <br>
    <br>
    <div class="container">
        <br>
        <form action='editpost.php' method="post" id="baza" style="color:white;">
            <label for='tytul'><b>Tytuł</b></label>
            <input type="text" class="form-control" value="<?php print($row['tytul']) ?>" name="tytul" required/>
            <label for='tresc'><b>Treść</b></label>
            <textarea rows="20" cols="121" placeholder="Wprowadź Treść" name="tresc" required><?php print($row['tresc']) ?></textarea>
            <input type="hidden" name="id" value="<?php print($_GET['id']) ?>">
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

