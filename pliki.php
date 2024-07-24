<?php 

  session_start();
  if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] != 5 {
      header("location: php.php?nie=1");
  }
  $conn = new mysqli ("127.0.0.1", "oskar", "zaq1@WSX", "domex");

  if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
  }

  $Zapytanie =  "SELECT Nazwisko,Imie,PracownikId
  FROM Pracownicy";

  $result = mysqli_query($conn, $Zapytanie);
  $row = mysqli_fetch_assoc($result);
  require_once('naglowek.php');
  if ($_GET["duzy"] != null) {
    print('<div class="alert alert-warning  alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>O nie!</strong> Twój plik jest za duży dozwolony rozmiar to 500KB.
      </div>');
  }
  if ($_GET["nieto"] != null) {
    print('<div class="alert alert-warning  alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>O nie!</strong> Dozwolone pliki to jpg, jpeg, png, gif.
      </div>');
  }
  if ($_GET["obraz"] != null) {
    print('<div class="alert alert-danger  alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Oj Oj!</strong> Nie wolno tak robić.
      </div>');
  }
  if ($_GET["udane"] != 0) {
    print('<div class="alert alert-success  alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Sukces!</strong> Pomyślnie dodałeś plik.
      </div>');
  }
?>
<center>
<form action="upload.php" method="post" enctype="multipart/form-data">
<label for="formFileMultiple" class="form-label">Wrzutka</label>
<input class="form-control form-control-lg" name="fileToUpload" type="file" id="fileToUpload"/>
  <input type="submit" class="btn btn-primary" style="margin: 10px" value="Udostępnij" name="submit">
</form>
</center>
<?php
        require_once('stopka.php');
      ?>
</body>
</html>
