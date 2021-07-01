<?php
session_start();

$message = "<p>" . $_SESSION['user'] . ": " . $_POST['message'] . "</p>\n";
file_put_contents("log.html", $message, FILE_APPEND);
?>