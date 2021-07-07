<?php
  session_start();

  if (isset($_SESSION['room'])) {
    $room = $_SESSION['room'];
  } else {
    $room = 18694;
    //header("Location: hub.php");
    //exit;
  }

  if (isset($_SESSION['user'])) {
    $uname = $_SESSION['user'];
  } else {
    $uname = "test";
  }

  if (!file_exists("chatlogs/$room.html")) {
    fopen("chatlogs/$room.html", "a+");
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Chat room</title>
    <!--link rel="stylesheet" href="style.css" /-->
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

      #chat-content {
        width: 50%;
        height: 85%;
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
    </style>
  </head>

  <body>
    <div id="chatpane">
      <div id="chat-content">
      </div>

      <div id="chat-input">
        <form id="input-form" onsubmit="preventSubmit(event)">
          <input type="text" id="input-text" />
          <input type="submit" id="submit-button" value="Send" />
        </form>
      </div>

      <div id="exit-button">
        <button type="button" onclick="location.href = 'hub.php';">Leave Chat</button>
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

      function preventSubmit(event) {
        event.preventDefault();
        return false;
      }
    </script>
  </body>
</html>