<?php
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
if (isset($_GET["zledane"])) {
    print("<span style='color: red'>Niepoprawne dane</span><br />");
   }
$email =
    "SELECT Email 
    FROM loginytmp 
    WHERE hash ='" .$_GET['hash']."'";
$result = mysqli_query($conn, $email);
$row = mysqli_fetch_assoc($result);
$Email = $row['Email'];
?>
<!DOCTYPE html>
<html>
<head>
<script>
  var check = function() {
  if (document.getElementById('haslo').value ==
    document.getElementById('haslo2').value) {
    document.getElementById('potwierdzenie').style.color = 'green';
    document.getElementById('potwierdzenie').innerHTML = 'zgodne';
    document.getElementById('reg').disabled = false;
  } else {
    document.getElementById('potwierdzenie').style.color = 'red';
    document.getElementById('potwierdzenie').innerHTML = 'nie zgodne';
    document.getElementById('reg').disabled = true;
  }
}
</script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  /* width: auto; */
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 20%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  /* .cancelbtn {
     width: 100%;
  } */
}
</style>
</head>
<body>

<form action="passwordchange2.php" method="post">
  <div class="imgcontainer">
    <img src="obrazy/Awatar.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">

    <label for="uname"><b>Email</b></label>
    <input type="text" placeholder="Wprowadź email" name="email" value='<?php print($Email) ?>' readonly required>

    <label for="psw"><b>kod</b></label>
    <input type="password" placeholder="Wprowadź kod weryfikacyjny" name="kod" required>

    <label for="psw"><b>Hasło</b></label>
    <input type="password" placeholder="Wprowadź hasło" onkeyup='check();' id='haslo' name="haslo" required>

    <label for="psw"><b>Powtórz hasło</b></label>
    <input type="password" placeholder="Wprowadź hasło" onkeyup='check();' id='haslo2' name="haslo2" required>

    <span id='potwierdzenie'></span>
    </label>

    <button id='reg' type="submit">Zmień hasło</button>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <a href='/'><button type="button" class="cancelbtn">Anuluj</button>
  </div>
</form>
<div>
<p><?php ini_set( 'display_errors', 'On' );
      error_reporting( E_ALL );?>
      </div>
</body>
</html>