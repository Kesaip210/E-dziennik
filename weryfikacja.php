<?php 
session_start();

$conn = new mysqli ("127.0.0.1", "oskar", "zaq1@WSX", "domex");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
if ($_GET["zledane"] != null) {
    print("<span style='color: red'>Niepoprawne dane</span><br />");
   }
// echo "Connected successfully";

$email = "SELECT Email FROM loginy WHERE hash ='" .$_GET['hash']."'";
$result = mysqli_query($conn, $email);
$row = mysqli_fetch_assoc($result);
// $Zapytanie =  "SELECT Nazwisko,Imie,PracownikId
// FROM Pracownicy";

// // $result2 = mysqli_query($conn, $Zapytanie2);
// $result = mysqli_query($conn, $Zapytanie);
// $row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
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
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 30%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
</head>
<body>

<form action="weryfikowanie.php" method="post">
  <div class="imgcontainer">
    <img src="obrazy/Awatar.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="uname"><b>Email</b></label>
    <input type="text" placeholder="Wprowadź email" name="email" value=<?php print("'".$row['Email']."'")?> readonly required>
    <label for="psw"><b>kod</b></label>
    <input type="password" placeholder="Wprowadź kod weryfikacyjny" name="kod" required>
        
    <button type="submit">Weryfikuj</button>
    <label>
    </label>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <a href='php.php'><button type="button" class="cancelbtn">Anuluj</button>
  </div>
</form>

</body>
</html>