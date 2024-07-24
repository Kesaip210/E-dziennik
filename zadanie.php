<?php
session_start();
ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
require_once('role.php');
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie =
    "SELECT *
    FROM zadania
    WHERE id ='".$_GET["zadanie"]."'";
$result = mysqli_query($conn,$Zapytanie);
$row = mysqli_fetch_assoc($result);
$klasa = $row["klasa"];
$przedmiot = $row["przedmiot"];
$nauczyciel = $row["nauczyciel"];
$nazwa = $row["nazwa"];
$opis = $row["opis"];
if (!isset($_SESSION['zalogowany']) or $_SESSION['zalogowany'] != ROLA_PRACOWNIK AND ($_SESSION['zalogowany'] != ROLA_NAUCZYCIEL)) {
    header("Location: /?nie=1");
}
require_once('naglowek.php');
require_once('funkcje/link.php');
link1($_GET);
$Zapytanie2 =
    "SELECT 
        Imie,
        Nazwisko,
        klasa,
        przedmiot
    FROM
        nauczyciele,
        klasy,
        przedmioty
    WHERE nauczycielId ='".$nauczyciel."'
    AND klasaId ='".$klasa."'
    AND przedmiotId ='".$przedmiot."'";
$result2 = mysqli_query($conn,$Zapytanie2);
$row2 = mysqli_fetch_assoc($result2);
?>
<center>
    <?php if (isset($_SESSION['zalogowany']) AND $_SESSION['zalogowany']  == ROLA_NAUCZYCIEL AND $_SESSION['Id'] == $nauczyciel){ ?>
    <form action="uploadadm.php" method="post" enctype="multipart/form-data">
        <label for="formFileMultiple" class="form-label">Wrzutka</label>
        <input class="form-control form-control-lg" name="fileToUpload" type="file" id="fileToUpload"/>
        <input type="submit" class="btn btn-primary" style="margin: 10px" value="Udostępnij" name="submit">
        <input type="hidden" name="zadanie" value="<?php print($_GET['zadanie']) ?>" />
    </form>
    <?php }?>
    <p style="padding: 5px"><h1><?php echo $nazwa ?></h1></p>
    <p style="padding: 5px"><h3><?php echo $opis ?></h3></p>
</center>
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Nazwa</th>
        <th scope="col">Plik</th>
        <?php if ($_SESSION['Id'] == $nauczyciel AND ($_SESSION['zalogowany'] == ROLA_NAUCZYCIEL)) { ?>
            <th scope="col">Usuń</th>
        <?php } ?>
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
            $helena++;
            echo '<tr><td>'.$helena.'</td><td>'.$file.'</td>
        <td>
        <a href="../uploads/'.$row2["Imie"]."_".$row2["Nazwisko"]."/".$row2["klasa"]."/".$row2["przedmiot"]."/".$nazwa."/".$file.'" download>
        <p>POBIERZ</p>
        <!-- <img src="../uploads/-->'./*.$file.*/'<!--" style="width: 50px;">-->
        </a>
        </td>';
            if ($_SESSION['Id'] == $nauczyciel AND (($_SESSION['zalogowany'] > 400 AND $_SESSION['zalogowany'] < 500) OR $_SESSION['zalogowany'] == 40)) {
            echo '<td> 
            <a href="usunplik.php?nazwa=' . $file . '&zadanie=' . $_GET["zadanie"] . '">
            <i class="fa fa-trash fa-2x" style="color: rgb(255,30,30)" aria-hidden="true"></i>
            </a>
            </td>';
        }
        echo'</tr>';
        }
    }
    ?>
</table>
<?php
require_once('stopka.php');
?>
</body>
</html>
