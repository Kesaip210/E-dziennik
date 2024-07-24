<?php
    $strona = $_SERVER['PHP_SELF'];
    require_once('role.php');
    $conn = polaczenieBaza();
    if (isset($_SESSION['Id'])) {
        $Zapytanie =
            "SELECT klasaId
    FROM klasy
    WHERE wychowawca ='" . $_SESSION['Id'] . "'";
        $result = mysqli_query($conn, $Zapytanie);
        $row = mysqli_fetch_assoc($result);
    }
    if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_UCZEN){
        $profil = "uczen=".$_SESSION['Id'];
    } elseif (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_NAUCZYCIEL){
    $profil = "nauczyciel=".$_SESSION['Id'];
    } elseif (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_OSOBA){
        $profil = "uzytkownik=".$_SESSION['Id'];
    } elseif (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK){
        $profil = "pracownik=".$_SESSION['Id'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>ZSET</title>
<!-- <link rel="stylesheet" href="styl.css"> -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="styl2.css">

<script>
$(document).on("click", ".action-buttons .dropdown-menu", function(e){
	e.stopPropagation();
});
</script>
</head> 
<body>
    <div id="naglowek">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a href="index.php" class="navbar-brand" style="margin-left:10px;"><img src="obrazy/Lzset.png" alt="zset" width="65" height="65"></a>
	<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
		<div class="navbar-nav">
        <a class="nav-item nav-link"
        
        href="index.php"
        <?php
            if ($strona == "/"){
                print('class="active"');
            }
        ?>        
        >Strona Główna
    </a>

   <a class="nav-item nav-link"
        href="onas.php"
        <?php
            if ($strona == "onas.php"){
                print('class="active"');
            }
        ?>        
        >O szkole
    </a>

    <a class="nav-item nav-link"
        href="posty.php"
        <?php
            if ($strona == "posty.php"){
                print('class="active"');
            }
        ?>        
        >Szkolne nowości
    </a>

<?php
  if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_PRACOWNIK) {
      print('<div class="dropdown show">');
      print('<a class="nav-item nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administrator</a>');
      print('<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">');
      print('<a class="nav-item nav-link dropdown-item" href="pracownicy.php">Pracownicy</a>');
      print('<a class="nav-item nav-link dropdown-item" href="nauczyciele.php">Nauczyciele</a>');
      print('<a class="nav-item nav-link dropdown-item" href="uczniowie.php">Uczniowie</a>');
      print('<a class="nav-item nav-link dropdown-item" href="klasy.php">Klasy</a>');
      print('<a class="nav-item nav-link dropdown-item" href="uczenie.php">Nauczanie</a>');
      print('</div>');
      print('</div>');
  }
?>
<?php
  if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_UCZEN) {
    print('<a class="nav-item nav-link" href="dlaUczniow.php">Zadania</a>');
  }
?>
<?php
  if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_NAUCZYCIEL) {
    print('<a class="nav-item nav-link" href="odNauczycieli.php">Zadania</a>');
  }
?>
    <a class="nav-item nav-link"
        href="kontakt.php"
        <?php
            if ($strona == "kontakt.php"){
                print('class="active"');
            }
        ?>
        >Kontakt
    </a>
      <?php if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == ROLA_NAUCZYCIEL AND $_SESSION['zalogowany'] != 400) {
          echo '<a class="nav-item nav-link"';
          print("href='klasa.php?klasa=" . $row["klasaId"] . "'");
          if ($strona == "klasa.php") {
              print('class="active"');
          }
          echo ">Moja Klasa </a>";
      }
            ?>
		</div>
        <?php
     
     if (isset($_SESSION['zalogowany'])) {
         print('
         <div class="navbar-nav ml-auto action-buttons">
			<div class="nav-item dropdown" style="padding: 5px;">
            <a href="profil.php?'. $profil .'" class="btn btn-primary dropdown-toggle sign-up-btn">Mój Profil</a>
            <a href="logout.php"  class="btn btn-primary dropdown-toggle sign-up-btn">Wyloguj</a>
        </div>
        </div>');
     } else {
         
         print('
     
 
		<div class="navbar-nav ml-auto action-buttons">
			<div class="nav-item dropdown" style="padding: 5px;">
				<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle sign-up-btn">Zaloguj</a>
                <div class="dropdown-menu action-form">
					<form action="loginprocess.php" method="post">
						
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Email"  name="login" required="required">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" placeholder="Hasło" name="haslo"  required="required">
						</div>
						<input type="submit" class="btn btn-primary btn-block" value="Zaloguj">
						<div class="text-center mt-2">
							<a data-toggle="modal" data-target="#exampleModal" href="#">Zapomniałeś hasła?</a>
						</div>
					</form>
                </div>
			</div>
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Odzyskiwanie hasła</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                             </button>
                        </div>
                        <div class="modal-body">
                            <form action="passwordchange.php" method="post">
                                <label><h6>Podaj email</h6></label>
                                <input type="text" class="form-control" name="email" placeholder="example@mail.com" required="required">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            <input type="submit" class="btn btn-primary" value="Wyślij">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
			<div class="nav-item dropdown" style="padding: 5px;">
				<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle sign-up-btn">Zarejestruj</a>
                <div class="dropdown-menu action-form">
					<form action="registerprocess1.php" method="post">
						<p class="hint-text">Wypełnij formularz aby założyć konto!</p>
						<div class="form-group">
							<input type="text" class="form-control" name="email" placeholder="Email" required="required">
						</div>
						<div class="form-group">
							<label class="form-check-label"><input type="checkbox" required="required"> Akceptuje <a href="warunki.php">Zasady i Warunki</a></label>
						</div>
						<input type="submit" class="btn btn-primary btn-block" value="Zarejestruj">
					</form>
				</div>
			</div>
        </div>');
     }
        ?>
	</div>
</nav>
    </div>