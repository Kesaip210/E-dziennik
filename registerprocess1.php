<?php
session_start();
$strona = $_SERVER['HTTP_HOST'];
$adres = str_replace("registerprocess1.php", "rejestracja.php", $_SERVER['PHP_SELF']);
ini_set( 'display_errors', 'On' ); 
error_reporting( E_ALL );

require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$data=date("Y-m-d");
$duzo =
    "SELECT Email 
    FROM loginy 
    WHERE Email = '".$_POST['email']."'";
$konta = mysqli_query($conn, $duzo);
if (mysqli_num_rows($konta) > 3){
    header("Location: /?duzo=2");
    die;
}
$log =
    "SELECT Email 
    FROM Uzytkownicy 
    WHERE Email = '".$_POST['email']."'";
$login = mysqli_query($conn, $log);
$log2 =
    "SELECT Email 
    FROM uczniowie 
    WHERE Email = '".$_POST['email']."'";
$login2 = mysqli_query($conn, $log2);
$log3 =
    "SELECT Email 
    FROM nauczyciele 
    WHERE Email = '".$_POST['email']."'";
$login3 = mysqli_query($conn, $log3);
$Login = str_replace(" ",'',$_POST['email']);
$hash = md5( rand(0,1000) );
if (mysqli_num_rows($login) != 0 or mysqli_num_rows($login2) != 0 or mysqli_num_rows($login3) != 0) {
  header("Location: /?zajety=1");
} else {
  if (!filter_var($Login, FILTER_VALIDATE_EMAIL)) {
    header("Location: /?zlyemail=1");
} else {
  
$password = rand(1000,99999999);
          $Zapytanie =
              "INSERT INTO loginy (Email,Haslo,DataDolaczenia,hash) 
              VALUES ('".$Login."','".$password."','".$data."','".$hash."')";

          require_once('phpmailer/PHPMailerAutoload.php'); # patch where is PHPMailer / ścieżka do PHPMailera

          $mail = new PHPMailer;
          $mail->CharSet = "UTF-8";
          
          $mail->IsSMTP();
          $mail->Host = 'smtp.gmail.com'; # Gmail SMTP host
          $mail->Port = 465; # Gmail SMTP port
          $mail->SMTPAuth = true; # Enable SMTP authentication / Autoryzacja SMTP
          $mail->Username = "tanieogorki@gmail.com"; # Gmail username (e-mail) / Nazwa użytkownika
          $mail->Password = "bohtppzgpqiqxhbo"; # Gmail password / Hasło użytkownika
          $mail->SMTPSecure = 'ssl';
          
          #$mail->From = ''; # REM: Gmail put Your e-mail here
          $mail->FromName = 'Tanie Ogórki'; # Sender name
          $mail->AddAddress($Login, 'Name'); # # Recipient (e-mail address + name) / Odbiorca (adres e-mail i nazwa)
          
          $mail->IsHTML(true); # Email @ HTML
          
          $mail->Subject = 'Rejestracja';
          //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
          
          $wiadomosc =  '
          
  
                          Dziękujemy za zarejestrowaniu konta na naszej stronie! <br>
          Twoje konto zostało stworzone, za pomocą poniższych danych możesz zweryfikować konto. <br>
<br>
          ------------------------------------------------------------------------------------- <br>
                                          Email: '.$Login.' <br>
                                          Kod: '.$password.' <br>
          ------------------------------------------------------------------------------------- <br>
  <br>
                            Kliknij w link aby przejść na naszą stronę: <br>
                http://'.$strona.$adres.'?hash='.$hash.'<br>
  
';
                      
$mail->Body = $wiadomosc;
          $mail->AltBody = $wiadomosc;
          
          if(!$mail->Send()) {
          echo 'Some error... / Jakiś błąd...';
          echo 'Mailer Error: ' . $mail->ErrorInfo;
          exit;
          }

      if ($conn->query($Zapytanie) === TRUE) {
          echo "New record created successfully";
          header("Location: /?dodano=1");
        } else {
          echo "Error: " . $conn->error;
        }
        
        $conn->close();
      }
    }
?>