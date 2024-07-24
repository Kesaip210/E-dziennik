<?php

function polaczenieBaza() {
    $conn = new mysqli ("127.0.0.1", "root", "", "domex");
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }
    return $conn;
}
