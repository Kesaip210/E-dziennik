<?php
require_once('funkcje/bazadanych.php');
$conn = polaczenieBaza();
if (isset($_SESSION['Id'])) {
    $role = "
    SELECT 
	    klasaId,
	    klasa1
    FROM
	    domex.przydzial,
	    domex.klasy
    WHERE wychowawca ='" . $_SESSION['Id'] . "'
    OR uczen ='" . $_SESSION['Id'] . "'";
    $resultrole = mysqli_query($conn, $role);
    if (mysqli_num_rows($resultrole) != 0) {
        $rola = mysqli_fetch_assoc($resultrole);
        if ($rola["klasaId"] != null) {
            $klasa = $rola["klasaId"];
        } else {
            $klasa = 0;
        }
        define('ROLA_UCZEN', 30 . $rola["klasa1"]);
        define('ROLA_NAUCZYCIEL', 40 . $klasa);
        define('ROLA_PRACOWNIK', 1);
        define('ROLA_OSOBA', 2);
    }else {
        define('ROLA_NAUCZYCIEL', 400);
        define('ROLA_UCZEN', 300);
        define('ROLA_PRACOWNIK', 1);
        define('ROLA_OSOBA', 2);
    }
}



