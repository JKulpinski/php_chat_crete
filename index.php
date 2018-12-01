<?php
/**
 * Created by IntelliJ IDEA.
 * User: Konasz
 * Date: 29.11.2018
 * Time: 15:27
 */

include ('DB.php');

session_start();
//$cos = password_hash("jonasz",PASSWORD_DEFAULT);

if(!isset($_SESSION['user_id'])){ // if user isn't login yet it redirect him to login page
    header("location:login.php");
}
?>

<!DOCTYPE HTML>
<html lang="en-EN">
<head>
    <meta name="Author" content="Natalia Pasturczak & Jonasz Kulpinski"/>
    <meta name="keywords" content="jquery, html, js"/>
    <meta name="description" content="Chat"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!--show on mobile devices-->
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
    <!--    <link rel="stylesheet" type="text/css" href="style.css"/>-->
    <link rel="icon" href="favicon.ico"/>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    <title>Chat Application using Jquery</title>
    <script src="script.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<div class="container">
    <br/>

    <h3 align="center">Heraklion Chat</a></h3><br/>
    <br/>

    <div class="table-responsive">
        <p align="right">Welcome,  <?php echo $_SESSION['username']; ?> <!--<?php echo $cos ?> -->!
            <br><a href="logout.php" class="btn btn-danger">Logout</a></p>
        <h4 align="center">Users:</h4>
        <div id="user_details"></div>
    <div id="user_model_details"></div>
</div>
</div>
</body>
</html>

<script>
    $(document).ready(function(){

        fetch_user();

        setInterval(function(){
            update_last_activity();
            fetch_user();
        }, 5000);

        function fetch_user()
        {
            $.ajax({
                url:"takeUsers.php",
                method:"POST",
                success:function(data){
                    $('#user_details').html(data);
                }
            })
        }

        function update_last_activity()
        {
            $.ajax({
                url:"updateLastActivity.php",
                success:function()
                {

                }
            })
        }

        function make_chat_dialog_box(toUserId, toUserName)
        {
            var dialog = '<div id="user_dialog_'+toUserId+'" class="user_dialog" title="You have chat with '+toUserName+'">';
            dialog += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+toUserId+'" id="chat_history_'+toUserId+'">';
            dialog += '</div>';
            dialog += '<div class="form-group">';
            dialog += '<textarea name="chat_message_'+toUserId+'" id="chat_message_'+toUserId+'" class="form-control"></textarea>';
            dialog += '</div><div class="form-group" align="right">';
            dialog += '<button type="button" name="send_chat" id="'+toUserId+'" class="btn btn-info send_chat">Send</button></div></div>';
            $('#user_model_details').html(dialog);
        }

        $(document).on('click', '.start_chat', function(){
            var to_user_id = $(this).data('touserid');
            var to_user_name = $(this).data('tousername');
            make_chat_dialog_box(to_user_id, to_user_name);
            $("#user_dialog_"+to_user_id).dialog({
                autoOpen:false,
                width:400
            });
            $('#user_dialog_'+to_user_id).dialog('open');
        });

        $(document).on('click', '.send_chat', function(){
            var toUserId = $(this).attr('id');
            var chatMessage = $('#chat_message_' + toUserId).val();
            $.ajax({
                url:"insertChat.php",
                method: "POST",
                data:{to_user_id:toUserId,chat_message:chatMessage},
                success:function(data){
                    $('#chat_message_'+toUserId).val('');
                    $('#chat_history_'+toUserId).html(data);
                }
            })
        })

    });
</script>

