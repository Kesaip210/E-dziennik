<?php 
  session_start();
?>
      <?php
      $id = $_GET['id'];
        require_once('naglowek.php');
        require_once('funkcje/link.php');
        require_once('funkcje/bazadanych.php');
        $id = $_GET['id'];
    $Zapytanie =
    "SELECT 
        id,
        tytul,
        tresc,
        data
    FROM posty
    WHERE id=".$_GET['id'];
$result = mysqli_query($conn, $Zapytanie);
$row= mysqli_fetch_assoc($result);
if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK){
    $Zapytanie3 =
    "SELECT 
        id,
        Email,
        tresc,
        data
    FROM komentarze
    WHERE id_postu = $id AND akceptacja = 0
    ORDER BY data";
    $result3 = mysqli_query($conn, $Zapytanie3);
}
        $Zapytanie2 =
    "SELECT 
        id,
        Email,
        tresc,
        data
    FROM komentarze
    WHERE akceptacja = 1 AND id_postu = $id
    ORDER BY data DESC";
$result2 = mysqli_query($conn, $Zapytanie2);
      ?>
      <!DOCTYPE html>
      <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="styl2.css">
      </head>
      <body>
          <div id="tres">
          </div>
            <div id="tytul">
                <center>
                <h1><?php echo $row['tytul']; ?></h1>
                </center>
            </div>
            <div id="data">
                <h3 style="display:flex; justify-content:flex-end;"><?php echo $row['data']; ?></h3>
            </div>
            <hr>
            <div>
                <h5><?php echo $row['tresc']; ?></h5>
                <br>
                <br>
                <br>
            </div>
            <hr>
            <div id="komentarze">
                <?php
                    if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] > 0){
                ?>
                <center>
              <h2>Dodaj komentarz</h2>
              <form action="addcomment.php" method="post">
                <textarea rows="4" cols="50" name="tresc" required></textarea>
                <input type="hidden" name="post" value="<?php print($id); ?>">
                <br>
                <input type="submit" value="Dodaj">
              </form>
                </center>
              <br>
              <hr>
                <?php
                if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK){
                while($row3 = mysqli_fetch_assoc($result3)){
                  echo '<div id="gora" style="display:flex;justify-content:space-between;"><div id="nick"><h5>';
                  echo $row3['Email'];
                  echo '</h5></div><div id="data">';
                  echo $row3['data'];
                  echo '</div>';
                  echo '</div><br>';
                  echo '<div id="dol">';
                  echo $row3['tresc'];
                  echo "<center>";
                  echo "<br><br><a href='deletecom.php?id=".$row3["id"]."'><i class='fa fa-trash fa-2x' style='padding-left: 5px;color: rgb(255,30,30)' aria-hidden='true'></i></a>";
                  echo "<a href='acceptcom.php?id=".$row3["id"]."'><i class='fa fa-user-plus fa-3x' style='padding: 5px;color: rgb(0,200,0)'></i></a>";
                  echo "</center>";
                  echo "</div><br><hr>";
                  
               }
              }
                    }
                 while($row2 = mysqli_fetch_assoc($result2)){
                    echo '<div id="gora" style="display:flex;justify-content:space-between;"><div id="nick"><h5>';
                    echo $row2['Email'];
                    echo '</h5></div><div id="data">';
                    echo $row2['data'];
                    echo '</div>';
                    echo '</div><br>';
                    echo '<div id="dol">';
                    echo $row2['tresc'];
                    if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK){
                      echo "<center>";
                      echo "<br><br><a href='deletecom.php?id=".$row2["id"]."'><i class='fa fa-trash fa-2x' style='padding-left: 5px;color: rgb(255,30,30)' aria-hidden='true'></i></a>";
                      echo "</center>";
                    }
                    echo "</div><br><hr>";
                 }
                ?>
            </div>
      <?php
        require_once('stopka.php');
      ?>
    </body>
  </html>