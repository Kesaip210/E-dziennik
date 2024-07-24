<?php 
  session_start();
?>
      <?php
        require_once('naglowek.php');
        require_once('funkcje/link.php');
        require_once('funkcje/bazadanych.php');
        if (isset($_GET['rozwin']) && $_GET['rozwin']==1){
          $Zapytanie =
          "SELECT
              id,
              tytul,
              tresc,
              data
          FROM posty
          ORDER BY data DESC";
        } else {
        $Zapytanie =
    "SELECT
        id,
        tytul,
        tresc,
        data
    FROM posty
    ORDER BY data DESC LIMIT 5";
        }
$result = mysqli_query($conn, $Zapytanie);
      ?>
      <!DOCTYPE html>
      <html lang="pl">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Szkolne nowości</title>
        <link rel="stylesheet" href="styl2.css">
      </head>
      <body>
      <div id="tres">
        <center>
          <?php
            if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK){
          ?>
      <a href="dodajpost.php"><i class="fa fa-user-plus fa-3x" style='padding: 5px;color: rgb(0,200,0)'></i></a>
      <hr>
        <?php
            }
            while($row = mysqli_fetch_assoc($result)){
                echo "<div id='tabela'><table>";
                echo "<tr><div id='tytul'>";
                echo "<br><a href='post.php?id=".$row["id"]."'><h3>".$row['tytul']."</h3></a><br>";
                echo "</div>";
                echo "<div id='data'>";
                echo $row['data'];
                echo "</div>";
                echo "</table></div>";
                if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK){
                  echo "<a href='edycjapost.php?id=".$row["id"]."'><i class='fa fa-pencil-square-o fa-2x' style='padding-right: 5px' aria-hidden='true'></i></a></td>";
                  echo "<a href='deletepost.php?id=".$row["id"]."'><i class='fa fa-trash fa-2x' style='padding-left: 5px;color: rgb(255,30,30)' aria-hidden='true'></i></a>";
                }
                echo "<hr>";
            }
            if (!isset($_GET['rozwin'])){
              echo "<button style='border-radius: 50%; padding: 10px;'><a href='posty.php?rozwin=1'>Rozwiń</a></button>";
            }
        ?>
        </center>
  </div>
      <?php
        require_once('stopka.php');
      ?>
    </body>
  </html>