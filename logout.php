<?php
session_start();
$_SESSION['zalogowany'] = 0;
session_destroy();
header("Location: ".$_SERVER['HTTP_REFERER']);
?>