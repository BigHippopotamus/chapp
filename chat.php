<?php
  session_start();

  if (!isset($_POST['user'])) {
    $uname = "test";
  } else {
    $uname = $_POST['user'];
  }

  $_SESSION['user'] = $uname;

  if (!file_exists("log.html")) {
    fopen("log.html", "a+");
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Chat room</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <div id="chatpane" style="width: 60vw; height: 90vh; margin: auto">
      <div id="chat-content" style="width: 50%; height: 70%; margin: auto; overflow-y: scroll; border-style: solid">
      </div>

      <div id="chat-input">
        <form id="input-form" onsubmit="preventSubmit(event)">
          <input type="text" id="input-text" />
          <input type="submit" id="submit-button" value="Send" />
        </form>
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
              message:  msg
            });

            $("#input-text").val("");
          }
          
          let chatPane = $("#chat-content");
          chatPane.scrollTop(chatPane[0].scrollHeight);
        }

        function updateChat() {
          $.ajax({
            url:  "log.html",
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