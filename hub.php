<html>
    <?php
        session_start();
        include 'config.php';
        $conn = mysqli_connect($server, $user, $pass,$db); 
        //newChatRooom
        if($_POST["newchat"]??""){
            $room_name=$_POST["room_name"]??"";

            if($_POST["private_room"]??""){
                $private_room=1;
                $room_code=(random_int(10000,99999));}

            else{$private_room=0;
                $room_code=NULL;}

            $query="INSERT INTO `chathubs`(`room_name`, `user_count`, `private_room`, `room_code`) 
            VALUES ('$room_name','0','$private_room','$room_code')";
            if($private_room)
                echo "CHAT SUCCESSFULLY CREATED, ChAT coDe:$room_code";
            else 
                echo "CHAT SUCCESSFULLY CREATED";
            mysqli_query($conn, $query);
            
        }

        if($_POST["joinchat"]??""){
            $code= $_POST["joinchat"]??"";
            echo $code;
            $query=mysqli_query($conn,"SELECT * FROM chathubs WHERE 'room_code'= $code  ");
            while($chat= mysqli_fetch_array($query)){
            echo "you are being directed to chat room:{$chat['room_name']}";}
        }
    ?>

    <body>
        <div style="margin-top: 10%; float:left">
            <h1>Currently active chat rooms</h1>
            <?php 
                $hubs = mysqli_query($conn, "SELECT * FROM chathubs");
                while ($row = mysqli_fetch_array($hubs)) {
                if(!$row['private_room'])
                    echo "<a href=''>{$row['room_name']} </a> -- {$row['user_count']}<br>";
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
