<?php
  session_start();
  include "config.php";

  if (isset($_SESSION['room'])) {
    $room = $_SESSION['room'];
  } else {
    echo "An error has occured";
    exit;
  }

  if (isset($_SESSION['user'])) {
    $uname = $_SESSION['user'];
  } else {
    echo "An error has occured";
    exit;
  }

  $conn = mysqliconnect($server, $user, $pass, $db);
  if (!$conn) {
    echo "An error has occured";
    exit;
  } else {
    $query1 = "DELETE FROM chat$room WHERE uname=$uname";
    $res1 = mysqli_query($conn, $query1);

    $query2 = "SELECT * FROM chat$room";
    $res2 = mysqli_query($conn, $query2);
    if (mysqli_num_rows($res2) <= 0 && file_exists("chatlogs/$room.html")) {
      unlink("chatlogs/$room.html", "a+");
    }

    header("Location: hub.php");
  }
?>