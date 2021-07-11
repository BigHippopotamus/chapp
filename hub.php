<html>
    <?php
        session_start();
        include 'config.php';
        $conn = mysqli_connect($server, $user, $pass,$db); 
        //newChatRooom
        if($_POST["newchat"]??""){
            $hubs = mysqli_query($conn, "SELECT * FROM chathubs");
            //prevents duplicate or empty chat-room names 
            $i=1;
                while ($row = mysqli_fetch_array($hubs)) 
                    if($row['room_name']==$_POST["room_name"]??""){
                        $i=0;break;
                    }
                
            if($i && $room_name!=""){
                $room_name=$_POST["room_name"]??"";

                if($_POST["private_room"]??""){
                    $private_room=1;}

                else {$private_room=0;}
                $c=1;
                $code=random_int(10000,99999);;
                while($c){
                    $c=0;
                while ($row = mysqli_fetch_array($hubs)) {
                    $code=random_int(10000,99999);
                    if($row['room_code']==$code){
                        $c=1; break;}
                    }   
                }
                $room_code=($code);
                $_SESSION['room']=$code;
                $query="INSERT INTO `chathubs`(`room_name`, `user_count`, `private_room`, `room_code`) 
                VALUES ('$room_name','0','$private_room','$room_code')";
                //echo '<script>alert( "CHAT SUCCESSFULLY CREATED, ChAT coDe:$room_code")</script>';
                //echo "CHAT SUCCESSFULLY CREATED, ChAT coDe:$room_code";
                mysqli_query($conn, $query);
                header('Location: chat.php');
                
            }
            else if(!$i)
                echo "chat-room name exists, enter another";
            else
                echo "invalid chat-name";
        }
        //join private chat
        if($_POST["joinchat"]??""){
            $code= $_POST["join_room"]??"";
            $query=mysqli_fetch_array(mysqli_query($conn,"SELECT `room_name`, `user_count`, `private_room`, `room_code` FROM `chathubs` WHERE room_code=$code"));
            //chatcode validation
            if($query)
                {echo "<h3>you are being directed to chat room: {$query['room_name']} ...</h3>";
                $_SESSION['room']=$query['room_code'];
                header('Location: chat.php');}
            else
                echo "invalid chat-code ";
        }
    ?>
    <style>
      body{
        background-image: url("chapp_bg3.jpg");
        background-size: cover; 
        background-attachment: fixed;
        color: white;;
        }
    </style>

    <body>
        <div style="margin-top: 10%; float:left">
            <h1>Currently active chat rooms</h1>
            <?php 
                $hubs = mysqli_query($conn, "SELECT * FROM chathubs");
                while ($row = mysqli_fetch_array($hubs)) {
                if(!$row['private_room'])
                    echo "<a href='chat.php'>{$row['room_name']} </a> -- {$row['user_count']}<br>";
                }
                
            ?>
        </div>
        
        <div style="float: right; margin-right:20%; margin-top:10%">
        
            <h1> Create new chat</h1>
            <form method="POST", action="">
                enter chat name
                <input type="text" name="room_name" ><br>
                <label> <input type="checkbox"  name="private_room"> private chat</label><br>            
                <input type="submit" name="newchat" value="create chatroom"><br>
                <h1> Join existing chat</h1>
                <input type="text" name="join_room" ><br>
                <input type="submit" name="joinchat" value="join chatroom"><br>
            </form>

        </div>
        
    <?php mysqli_close($conn); ?>

    </body>
</html>
