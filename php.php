<?php 

  session_start();

  $conn = new mysqli ("127.0.0.1", "oskar", "zaq1@WSX", "domex");

  if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
  }

  $Zapytanie =  "SELECT Nazwisko,Imie,PracownikId
  FROM Pracownicy";

  $result = mysqli_query($conn, $Zapytanie);
  $row = mysqli_fetch_assoc($result);

?>
      <?php
        require_once('naglowek.php');
      ?>
      <div id="tresc">
        <?php
          if ($_GET["dodano"] == 1) {
            print('<div class="alert alert-primary  alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Sukces!</strong> Sprawdź swój email w celu weryfikacji.
              </div>');
          }
          if ($_GET["dodano"] == 2) {
            print('<div class="alert alert-success  alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Sukces!</strong> Pomyślnie założyłeś konto.
              </div>');
          }
          if ($_GET["nie"] != null) {
            print('<div class="alert alert-danger  alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Oj Oj!</strong> Nie wolno tak robić.
              </div>');
          }
          if ($_GET["zajety"] != null) {
            print('<div class="alert alert-warning  alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>O nie!</strong> Ten email jest już zajęty.
              </div>');
          }
          if ($_GET["haslo"] != null) {
            print('<div class="alert alert-warning  alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Oj!</strong> Nie umieszczaj spacji w haśle.
              </div>'); 
          }
          if ($_GET["zlenazwisko"] != null) {         
            print('<div class="alert alert-warning  alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>O nie!</strong> Nie używaj znaków specjalnych oraz liczb w nazwisku.
              </div>');
          }
          if ($_GET["zleimie"] != null) {
            print('<div class="alert alert-warning  alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>O nie!</strong> Nie używaj znaków specjalnych oraz liczb w imieniu.
              </div>');
          }
          if ($_GET["zlyemail"] != null) {
            print('<div class="alert alert-warning  alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>O nie!</strong> Źle wpisałeś email.
              </div>');
          }
          if ($_GET["Nieudany"] != null) {
        ?>
            <style>
              #id01 { display: block; }
            </style>
        <?php 
            print('<div class="alert alert-warning  alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>O nie!</strong> niepoprawny login lub hasło.
              </div>');
          }
        ?>
        <br>
        <p style="font-size:50px;" class="cien" style="centre" ><?php print ($row["Imie"]." ".$row["Nazwisko"]);?></p>
        <div id="demo" class="carousel slide" data-ride="carousel">
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
  </ul>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="obrazy/zdjecie.jpg" class="img-fluid rounded" style='padding: 4px' alt="Zdjecie" width="500" height="700">
      <div class="carousel-caption">
        <h3><strong style="color: black"> To ja</strong></h3>
        <p><strong style="color: black"> super koks </strong></p>
      </div>   
    </div>
    <div class="carousel-item">
      <img src="obrazy/giga.png" class="img-fluid rounded" alt="Giga" width="500" height="700">
      <div class="carousel-caption">
        <h3> To też ja</h3>
        <p> ale z innego profilu </p>
      </div>   
    </div>  
    </div>
  </div>
</div>
      </div>
      <?php
        require_once('stopka.php');
      ?>
    </body>
  </html>

