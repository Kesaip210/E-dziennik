<?php

  session_start();
  ini_set( 'display_errors', 'On' ); 
error_reporting( E_ALL );

  if (!isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] != 1) {
      header("location: php.php?nie=1");
  }
  require_once('naglowek.php');

  if (isset($_GET["duzy"]) && $_GET["duzy"] != null) {
    print('<div class="alert alert-warning  alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>O nie!</strong> Twój plik jest za duży dozwolony rozmiar to 500KB.
      </div>');
  }
  if (isset($_GET["nieto"]) && $_GET["nieto"] != null) {
    print('<div class="alert alert-warning  alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>O nie!</strong> Dozwolone pliki to jpg, jpeg, png, gif.
      </div>');
  }
  if (isset($_GET["obraz"]) && $_GET["obraz"] != null) {
    print('<div class="alert alert-danger  alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Oj Oj!</strong> Nie wolno tak robić.
      </div>');
  }
  if (isset($_GET["udane"]) && $_GET["udane"] != 0) {
    print('<div class="alert alert-success  alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Sukces!</strong> Pomyślnie dodałeś plik.
      </div>');
  }
  if (isset($_GET["istnieje"]) && $_GET["istnieje"] != null) {
    print('<div class="alert alert-warning  alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>O nie!</strong> Plik o danej nazwie już istnieje.
      </div>');
  }
  if (isset($_GET["usunieto"]) && $_GET["usunieto"] != 0) {
    print('<div class="alert alert-success  alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Sukces!</strong> Pomyślnie usunąłeś plik.
      </div>');
  }
?>
<center>
<form action="uploadadm.php" method="post" enctype="multipart/form-data">
<label for="formFileMultiple" class="form-label">Wrzutka</label>
<input class="form-control form-control-lg" name="fileToUpload" type="file" id="fileToUpload"/>
  <input type="submit" class="btn btn-primary" style="margin: 10px" value="Udostępnij" name="submit">
</form>
      <p style="padding: 5px">Pliki do pobrania</p>
</center>
<table class="table">
        <thead class="thead-dark">
          <tr>
          <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Plik</th>
            <th scope="col">Akcja</th>
          </tr>
<?php
$katalog="/var/www/domex/uploads";
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
        <a href="../uploads/'.$file.'" download>
        <img src="../uploads/'.$file.'" style="width: 50px;">
        </a>
        </td>
        <td> 
        <a href="usunplik.php?nazwa='.$file.'">
        <i class="fa fa-trash fa-2x" style="color: rgb(255,30,30)" aria-hidden="true"></i>
        </a>
        </td>
        </tr>';
    }
}
    ?>
    </table>
<?php
        require_once('stopka.php');
      ?>
      </body>
      </html>