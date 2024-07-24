<?php
session_start();
$strona = $_SERVER['HTTP_HOST'];
$adres = str_replace("passwordchange.php", "zmianahasla.php", $_SERVER['PHP_SELF']);
ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );

require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$data=date("Y-m-d");
$duzo =
    "SELECT Email 
    FROM loginytmp 
    WHERE Email = '".$_POST['email']."'";
$konta = mysqli_query($conn, $duzo);
if (mysqli_num_rows($konta) > 3){
    header("Location: /?duzo=1");
    die;
}
$log =
    "SELECT Email 
    FROM Uzytkownicy 
    WHERE Email = '".$_POST['email']."'";
$login = mysqli_query($conn, $log);
$Login = str_replace(" ",'',$_POST['email']);
$hash = md5(rand(0,1000));
    $log2 =
        "SELECT Email 
        FROM uczniowie 
        WHERE Email = '" . $_POST['email'] . "'";
    $login2 = mysqli_query($conn, $log2);
        $log3 =
            "SELECT Email 
            FROM nauczyciele 
            WHERE Email = '" . $_POST['email'] . "'";
        $login3 = mysqli_query($conn, $log3);
        if (mysqli_num_rows($login3) == 0 AND mysqli_num_rows($login2) == 0 AND mysqli_num_rows($login) == 0) {
            header("Location: /?niema");
        } else {
            if (!filter_var($Login, FILTER_VALIDATE_EMAIL)) {
                header("Location: /?zlyemail=1");
            } else {

                $password = rand(1000, 99999999);
                $Zapytanie =
                    "INSERT INTO loginytmp (Email,Haslo,hash,dataProsby) 
                    VALUES ('" . $Login . "','" . $password . "','" . $hash . "','" . $data . "')";

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
                $mail->AddAddress($Login,
                    'Name'); # # Recipient (e-mail address + name) / Odbiorca (adres e-mail i nazwa)

                $mail->IsHTML(true); # Email @ HTML

                $mail->Subject = 'Zmiana hasła';
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

                $wiadomosc = '
          
  
         Poprosiłeś o zmianę hasła na naszej stronie, jeśli to nie byłeś ty zignoruj tego maila.  <br>
           Lecz jeśli to jest twoja prośba to wejdź w podany link i wpisz poniższe informacje. <br>
<br>
          ------------------------------------------------------------------------------------- <br>
                                          Email: ' . $Login . ' <br>
                                          Kod: ' . $password . ' <br>
          ------------------------------------------------------------------------------------- <br>
  <br>
                            Kliknij w link aby przejść na naszą stronę: <br>
                http://' . $strona . $adres . '?hash=' . $hash . '<br>
  
';

                $mail->Body = $wiadomosc;
                $mail->AltBody = $wiadomosc;

                if (!$mail->Send()) {
                    echo 'Some error... / Jakiś błąd...';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                    exit;
                }

                if ($conn->query($Zapytanie) === true) {
                    echo "New record created successfully";
                    header("Location: /?dodano=3");
                } else {
                    echo "Error: " . $conn->error;
                }

                $conn->close();
            }
}
?>