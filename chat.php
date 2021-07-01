<?php
  session_start();

  if (!isset($_POST['user'])) {
    $uname = "test";
  } else {
    $uname = $_POST['user'];
  }

  $_SESSION['user'] = $uname;
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Chat room</title>
    <link rel="stylesheet" href="style.css" />
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
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#submit-button").click(sendMessage());
          
        $("#input-form").keypress((event) => {
          if (event.which === 13) {
            sendMessage();
          }
        });
          
        function sendMessage() {
          let msg = $("#input-text").val();
          $.post("post.php", 
          {
            message:  msg
          });

          $("#input-text").val("");
        }

        function updateChat() {
          $.ajax({
            url:  "log.html",
            success:  function(html) {
              $("#chat-content").html(html);
            }
          });
        }

        setInterval(updateChat, 200);
      });

      function preventSubmit(event) {
        event.preventDefault();
        return false();
      }
    </script>
  </body>
</html>