<?php
session_start();
include("config.php");

#CREATING DATABASE:-

$conn = mysqli_connect($server, $user, $password);
  if (!$conn){ 
   echo "NO CONNECTION ";
  }
  else{
	echo "<p><i>Connection Established Successfully<\i><\p>"."<br>";
	}

$dbname "signedinusers";
$sqldb = "CREATE DATABASE IF NOT EXISTS signedinusers";

if( mysqli_query($conn, $sqldb)){
	echo "<p><i>Connection Established Successfully<\i><\p>"."<br>";
	}
else {
	echo "ERROR WHILE CREATING DATABASE !  ".mysqli_error($conn);
	}
	
$conn = mysqli_connect($server, $user, $password, $dbname);

$sqltab = "CREATE TABLE IF NOT EXISTS userinfo(
    id INT(3) UNSIGNED AUTO-INCREMENT PRIMARY KEY,
    uname VARCHAR(20) NOT NULL,
    pwd VARCHAR(20) NOT NULL,
    email VARCHAR(20) NOT NULL,
    )";
    
    if( mysqli_query($conn, $sqltab)){
        echo "<p><i>Table Created Successfully<\i><\p>"."<br>";
        }
    else {
        echo "ERROR WHILE CREATING TABLE !  "."<br>".mysqli_error($conn);
        }
    
        $_SESSION[uname-signin] = $_POST['uname-signin'];
        $_SESSION[password-signin] = $_POST['password-signin'];
        $_SESSION[email] = $_POST['email'];

        $sqlins = "INSERT INTO userinfo (uname, pwd, email)
        VALUES ( $_SESSION[uname],$_SESSION[password-signin],$_SESSION[email]";

if (mysqli_query($conn, $sqlins)) {
    echo "<p><i>Data Inserted Successfully<\i><\p>"."<br>";
} else {
    echo "ERROR WHILE INSERTING INTO TABLE !  "."<br>".mysqli_error($conn);
}

mysqli_close($conn);
?>
