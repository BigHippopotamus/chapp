<?php
    session_start();
    include "config.php";

    $conn = mysqli_connect($server, $user, $pass, $db);

    if ($conn) {
        $uname = $_POST['uname-signin'];
        $pass = $_POST['password-signin'];
        $email = $_POST['email'];

        $sqlu = "SELECT * FROM $usertable WHERE uname='$uname'";
        $sqle = "SELECT * FROM $usertable WHERE email='$email'";
        $resu = mysqli_query($conn, $sqlu);// or die(mysqli_error($conn));
        $rese = mysqli_query($conn, $sqle);// or die(mysqli_error($conn));

        if(mysqli_num_rows($resu)){
            $uerror = "This username has already been taken. Please go for another one.";
            $_SESSION['utaken'] = $uerror;
        }else if(mysqli_num_rows($resu)){
            echo "HI";
            $eerror = "An user has already signed-in with this Email ID. Please use an other Email ID or try to Log in.";
            $_SESSION['etaken'] = $eerror;
        }else{
            echo "WELCOM";
            $sqlins = "INSERT INTO usertable (uname, pwd, email)
            VALUES ('$uname', '$pass', '$email')";
            if (mysqli_query($conn, $sqlins)) {
                $_SESSION['user'] = $uname;
                header("Location: hub.php");
            } else {
                echo "ERROR WHILE INSERTING INTO TABLE !  "."<br>".mysqli_error($conn);
            }
        }
    }

    mysqli_close($conn);
?>