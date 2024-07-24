<?php
ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
$Zapytanie3 =
    "SELECT 
        Email,
        Haslo,
        LoginId,
        hash
    FROM loginytmp 
    WHERE Email='".$_POST["email"]."' 
    AND Haslo='".$_POST["kod"]."'";
$odp = mysqli_query($conn,$Zapytanie3);
if ($foundRows = mysqli_num_rows($odp)!=0) {
    $Zapytanie2 =
        "SELECT 
            Email,
            Haslo,
            LoginId,
            hash
        FROM loginytmp 
        WHERE potwierdzone = 'T'";
    $odp2 = mysqli_query($conn,$Zapytanie2);
    if ($foundRows2 = mysqli_num_rows($odp2)!=0) {
header("Location: /?nie");
    }
    $Update =
        "UPDATE loginytmp 
        SET potwierdzone='T' 
        WHERE Email='" . $_POST["email"] . "' 
        AND Haslo='" . $_POST["kod"] . "'";

    if ($conn->query($Update) === true) {
        echo "New record created successfully";
    } else {
        header("Location: /?zlykod=1");
    }
} else {
    header("Location: /?zlykod=1");
    die;
}
$mail =
    "SELECT Email 
    FROM loginytmp 
    WHERE potwierdzone = 'T' 
    AND Email = '".$_POST['email']."'";
$email = mysqli_query($conn, $mail);
if (mysqli_num_rows($email) == 0) {
    header("Location: /?nie");
} else {
    $log =
        "SELECT Email 
        FROM Uzytkownicy 
        WHERE Email = '".$_POST['email']."'";
    $login = mysqli_query($conn, $log);
    if (mysqli_num_rows($login) != 1) {
        $log2 =
            "SELECT Email 
            FROM uczniowie 
            WHERE Email = '" . $_POST['email'] . "'";
        $login2 = mysqli_query($conn, $log2);
        if (mysqli_num_rows($login2) != 1) {
            $log3 =
                "SELECT Email 
                FROM nauczyciele 
                WHERE Email = '" . $_POST['email'] . "'";
            $login3 = mysqli_query($conn, $log3);
            if (mysqli_num_rows($login3) != 1) {
                header('location: /?nie=1');
            } else {
                $Login = str_replace(" ", '', $_POST['email']);
                $password = $_POST['haslo'];
                if (strpos($_POST['haslo'], " ")) {
                    header("Location: /?haslo=1");
                } else {
                    if (!filter_var($Login, FILTER_VALIDATE_EMAIL)) {
                        header("Location: /?zlyemail=1");
                    } else {
                        if ($_POST["haslo"] == $_POST["haslo2"]) {
                            $Zapytanie =
                                "UPDATE nauczyciele 
                                SET Haslo='" . $password . "' 
                                WHERE Email = '" . $_POST['email'] . "'";
                            if ($conn->query($Zapytanie) === true) {
                                echo "New record created successfully";
                                header("Location: /?dodano=4");
                            } else {
                                echo "Error: " . $conn->error;
                            }

                            $conn->close();
                        } else {
                            header('location: /?haslo=1');
                        }
                    }
                }
            }
        } else {
            $Login = str_replace(" ", '', $_POST['email']);
            $password = $_POST['haslo'];
            if (strpos($_POST['haslo'], " ")) {
                header("Location: /?haslo=1");
            } else {
                if (!filter_var($Login, FILTER_VALIDATE_EMAIL)) {
                    header("Location: /?zlyemail=1");
                } else {
                    if ($_POST["haslo"] == $_POST["haslo2"]) {
                        $Zapytanie =
                            "UPDATE uczniowie 
                            SET Haslo='" . $password . "' 
                            WHERE Email = '" . $_POST['email'] . "'";
                        if ($conn->query($Zapytanie) === true) {
                            echo "New record created successfully";
                            header("Location: /?dodano=4");
                        } else {
                            echo "Error: " . $conn->error;
                        }

                        $conn->close();
                    } else {
                        header('location: /?haslo=1');
                    }
                }
            }
        }
    }else{
        $Login = str_replace(" ",'',$_POST['email']);
        $password = $_POST['haslo'];
        if (strpos($_POST['haslo'], " ")) {
            header("Location: /?haslo=1");
                } else {
                    if (!filter_var($Login, FILTER_VALIDATE_EMAIL)) {
                        header("Location: /?zlyemail=1");
                    } else {
                        if ($_POST["haslo"] == $_POST["haslo2"]) {
                            $Zapytanie =
                                "UPDATE Uzytkownicy 
                                SET Haslo='".$password."' 
                                WHERE Email = '".$_POST['email']."'";
                            if ($conn->query($Zapytanie) === TRUE) {
                                echo "New record created successfully";
                                header("Location: /?dodano=4");
                            } else {
                                echo "Error: " . $conn->error;
                            }

                            $conn->close();
                        } else {
                            header('location: /?haslo=1');
                        }
                    }
                }
            }
}
ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
?>