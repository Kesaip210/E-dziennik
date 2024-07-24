<?php
session_start();
ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie =
    "SELECT *
    FROM zadania
    WHERE id ='".$_GET["zadanie"]."'";
$result = mysqli_query($conn,$Zapytanie);
$row = mysqli_fetch_assoc($result);
$klasa = $row["klasa"];
$klasa1 = $row["klasa"];
$przedmiot = $row["przedmiot"];
$nauczyciel = $row["nauczyciel"];
$nazwa = $row["nazwa"];
$opis = $row["opis"];
if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != 1 AND ($_SESSION['zalogowany'] != 30 .$klasa)) {
    header("Location: /?nie=1");
}
require_once('naglowek.php');
require_once('funkcje/link.php');
link1($_GET);
$Zapytanie2 =
    "SELECT 
        uczniowie.Email as Email2,
        uczniowie.Imie as Imie2,
        uczniowie.Nazwisko as Nazwisko2,
        nauczyciele.Imie,
        nauczyciele.Nazwisko,
        nauczyciele.Email,
        klasy.klasa,
        przedmiot
    FROM
        uczniowie,
        nauczyciele,
        klasy,
        przedmioty
    WHERE nauczycielId ='".$nauczyciel."'
    AND klasaId ='".$klasa1."'
    AND przedmiotId ='".$przedmiot."'
    AND uczenId ='".$_SESSION['Id']."'";
$result2 = mysqli_query($conn,$Zapytanie2);
$row2 = mysqli_fetch_assoc($result2);
?>
<center>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="formFileMultiple" class="form-label">Wrzutka</label>
            <input class="form-control form-control-lg" name="fileToUpload" type="file" id="fileToUpload"/>
            <input type="submit" class="btn btn-primary" style="margin: 10px" value="Udostępnij" name="submit">
            <input type="hidden" name="zadanie" value="<?php print($_GET['zadanie']) ?>" />
        </form>
    <p style="padding: 5px"><h1><?php echo $nazwa ?></h1></p>
    <p style="padding: 5px"><h3><?php echo $opis ?></h3></p>
</center>
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Nazwa</th>
        <th scope="col">Plik</th>
    </tr>
    <?php
    $katalog="/var/www/domex/uploads/".$row2["Imie"]."_".$row2["Nazwisko"]."/".$row2["klasa"]."/".$row2["przedmiot"]."/".$nazwa;//"/var/www/domex/uploads";
    $helena = 0;


    if ($handle = opendir($katalog)) {
        $files = array();
        while ($files[] = readdir($handle));
        sort($files);
        closedir($handle);
    }
    $blacklist = array('.','..','somedir','somefile.php','');
    foreach ($files as $file) {
        // var_dump($file);
        if (!in_array($file, $blacklist)) {
            if (strpos($file, $row2["Email2"]) !== false or strpos($file, $row2["Email"]) !== false){
            $helena++;
            echo '<tr><td>'.$helena.'</td><td>'.$file.'</td>
        <td>
        <a href="../uploads/'.$row2["Imie"]."_".$row2["Nazwisko"]."/".$row2["klasa"]."/".$row2["przedmiot"]."/".$nazwa."/".$file.'" download>
        <p>POBIERZ</p>
        <!-- <img src="../uploads/-->'./*.$file.*/'<!--" style="width: 50px;">-->
        </a>
        </td>
        </tr>';
        }
        }
    }
    ?>
</table>
<?php
require_once('stopka.php');
?>
</body>
</html>
