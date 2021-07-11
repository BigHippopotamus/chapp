<?php
  session_start();
  include "config.php";

  $_SESSION['room'] = 91474;
  if (isset($_SESSION['room'])) {
    $room = $_SESSION['room'];
    $conn = mysqli_connect($server, $user, $pass, $db);

    $topic_query = "SELECT room_name FROM $chattable WHERE room_code=$room";
    $topic_result = mysqli_fetch_array(mysqli_query($conn, $topic_query));
    $topic = $topic_result[0];

    $add_count = "UPDATE $chattable SET user_count=user_count+1 WHERE room_code=$room";
    $add_result = mysqli_query($conn, $add_count);

    mysqli_close($conn);
  } else {
    $room = 91474;
    $topic = "TEST";
    //header("Location: hub.php");
    //exit;
  }

  if (isset($_SESSION['user'])) {
    $uname = $_SESSION['user'];
  } else {
    $_SESSION['user'] = "test";
    $uname = $_SESSION['user'];
  }

  if (!file_exists("chatlogs/$room.html")) {
    fopen("chatlogs/$room.html", "a+");
  }


?>

<!DOCTYPE html>
<html>
  <head>
    <title>Chat room</title>
    <style>
      body{
        background-image: url("chapp_bg3.jpg");
        background-repeat: no-repeat; 
        background-size: cover; 
        background-attachment: fixed;
      }

      p {
        color: white;
        margin: 0;
        padding: 5px;
      }

      #chatpane {
        width: 60vw;
        height: 90vh;
        margin: auto;
      }

      #room-data {
        height: 10%;
        margin: auto;
        text-align: center;
        font-weight: bold;
      }

      #chat-content {
        width: 50%;
        height: 80%;
        margin: auto;
        padding: 5px;
        overflow-y: scroll;
        border-style: solid;
        background-color: rgb(0, 0, 10);
        background-color: rgba(0, 0, 10, 0.7);
      }

      #input-form {
        padding: 5px;
        display: flex;
        justify-content: center;
        column-gap: 5px;
      }

      #exit-button {
        margin: auto;
        display: flex;
        justify-content: center;
      }

      #uname {
        color: darkviolet;
        font-weight: bold;
      }

      #topic {
        font-size: x-large;
        padding: 0px;
      }

      #code {
        font-size: small;
      }
    </style>
  </head>

  <body>
    <div id="chatpane">
      <div id="room-data">
        <p id="topic"><?php echo $topic; ?></p>
        <p id="code">Room Code: <?php echo $room; ?></p>
      </div>

      <div id="chat-content">
      </div>

      <div id="chat-input">
        <form id="input-form" onsubmit="preventSubmit(event)">
          <input type="text" id="input-text" />
          <input type="submit" id="submit-button" value="Send" />
        </form>
      </div>

      <div id="exit-button">
        <button type="button" onclick="location.href = 'exitchat.php';">Leave Chat</button>
      </div>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#submit-button").click(function() {
          sendMessage();
        });
          
        $("#input-form").keypress((event) => {
          if (event.which === 13) {
            sendMessage();
          }
        });
          
        function sendMessage() {
          let msg = $("#input-text").val();
          if (msg !== "") {
            $.post("post.php", 
            {
              message:  msg,
              link: <?php echo "\"chatlogs/$room.html\""; ?>
            });

            $("#input-text").val("");
          }
          
          let chatPane = $("#chat-content");
          chatPane.scrollTop(chatPane[0].scrollHeight);
        }

        function updateChat() {
          $.ajax({
            url:  <?php echo "\"chatlogs/$room.html\""; ?>,
            cache: false,
            success:  function(html) {
              let chatPane = $("#chat-content");
              let scrollDown = Math.abs(chatPane[0].scrollHeight - chatPane.scrollTop() - chatPane.innerHeight()) <= 1;

              $("#chat-content").html(html);

              if (scrollDown) chatPane.scrollTop(chatPane[0].scrollHeight);
            }
          });
        }

        setInterval(updateChat, 500);
      });

      $(window).on("beforeunload", function() {
        $.post("exitchat.php");
      });

      function preventSubmit(event) {
        event.preventDefault();
        return false;
      }
    </script>
  </body>
</html>