<?php 
session_start();
ini_set( 'display_errors', 'On' ); 
      error_reporting( E_ALL );
$conn = new mysqli ("127.0.0.1", "oskar", "zaq1@WSX", "domex");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

echo "Connected successfully";


$Zapytanie =  "SELECT Email,Haslo,LoginId,hash
FROM loginy WHERE Email='".$_POST["email"]."' AND Haslo='".$_POST["kod"]."'";

$Update = "UPDATE loginy SET potwierdzone='T' WHERE Email='".$_POST["email"]."' AND Haslo='".$_POST["kod"]."'";
if ($conn->query($Update) === TRUE) {
    echo "New record created successfully";
} else {
    echo "error";
}
// $result2 = mysqli_query($conn, $Zapytanie2);
$result = mysqli_query($conn, $Zapytanie);
$row = mysqli_fetch_assoc($result);
$hash = md5( rand(0,1000) );

if ($row == null) {
    $_SESSION['zalogowany'] = 0;
    header("HTTP/1.1 301 Moved Permanently");
header("Location: weryfikacja.php?zledane");
exit;
} 
else {
//     setcookie("Ciastko","10");
//     setcookie('oddano_glos', '1');
// setcookie('oddano_glos', '1', time()+3600);
$_SESSION['Id'] = $row['LoginId'];
$_SESSION['zalogowany'] = 3;
$_SESSION['time']     = time()+600;
header("Location: rejestracja.php?hash='".$row['hash']."'");
}
// ."&hash=".$hash)
?>