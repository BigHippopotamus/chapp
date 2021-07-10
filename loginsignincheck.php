<?php
session_start();
include("config.php");

#CREATING DATABASE:-

$conn = mysqli_connect($server, $user, $pass);
  if (!$conn){ 
   echo "NO CONNECTION ";
  }
  else{
	echo "<p><i>Connection Established Successfully<\i><\p>"."<br>";
	}


$sqldb = "CREATE DATABASE IF NOT EXISTS db";

if( mysqli_query($conn, $sqldb)){
	echo "<p><i>Connection Established Successfully<\i><\p>"."<br>";
	}
else {
	echo "ERROR WHILE CREATING DATABASE !  ".mysqli_error($conn);
	}
	
$conn = mysqli_connect($server, $user, $password, $db);

$sqltab = "CREATE TABLE IF NOT EXISTS usertable(

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

            $sqlu = "SELECT * FROM usertable WHERE uname='$_SESSION[uname-signin]'";
            $sqle = "SELECT * FROM usertable WHERE uname='$_SESSION[email]'";
            $resu = mysqli_query($conn, $sqlu) or die(mysqli_error($conn));
            $rese = mysqli_query($conn, $sqle) or die(mysqli_error($conn));

            if(mysqli_num_rows($resu) > 0){
                $_SESSION[$utaken] = "This username has already been taken. Please go for another one."
            }else if(mysqli_num_rows($rese) > 0){
                $_SESSION[$etaken] = "An user has already signed-in with this Email ID. Please use an other Email ID or try to Log in."
            }else{
                $sqlins = "INSERT INTO usertable (uname, pwd, email)
                VALUES ( $_SESSION[uname],$_SESSION[password-signin],$_SESSION[email]";
                if (mysqli_query($conn, $sqlins)) {
                    header(location: "hub.php");
                    die();
                } else {
                    echo "ERROR WHILE INSERTING INTO TABLE !  "."<br>".mysqli_error($conn);
                }
            }
        }
    
        $_SESSION[uname-login] = $_POST['uname-login'];
        $_SESSION[password-login] = $_POST['password-login'];

        $row="";
        $sqll = "SELECT * FROM usertable WHERE uname='$_SESSION[uname-login]'";
        $resl = mysqli_query($conn, $sqll);
        if($resl){
            $row = mysqli_fetch_assoc($resl);
            if( $row['pwd'] == $_SESSION[password-login])
                {
                    header(location: "hub.php");
                    die();
                }
            else{
                $_SESSION[pincorrect] = "Incorrect Password";
            }
        }
        else{
            $_SESSION[pincorrect] = "User Not Found. Please Sign-in";
        }


mysqli_close($conn);
?>
