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

        fetchUser();

        //every 5 seconds run these functions
        setInterval(function(){
            updateActivity();
            fetchUser();
            updateChat();
        }, 5000);

        function fetchUser()
        {
            $.ajax({
                url:"takeUsers.php",
                method:"POST",
                success:function(data){
                    $('#user_details').html(data);
                }
            })
        }

        function updateActivity()
        {
            $.ajax({
                url:"updateLastActivity.php",
                success:function()
                {

                }
            })
        }

        function makeChatDialogBox(toUserId, toUserName)
        {
            let dialog = '<div id="user_dialog_'+toUserId+'" class="user_dialog" title="You have chat with '+toUserName+'">';
            dialog += '<div style="height:450px; border:1px solid #91e2ff; overflow-y: scroll; margin-bottom:22px; padding:18px;" class="chat_history" data-touserid="'+toUserId+'" id="chat_history_'+toUserId+'">';
            dialog += fetchUserChatHistory(toUserId);
            dialog += '</div> <div class="form-group"> <textarea name="chat_message_' + toUserId + '" id="chat_message_' + toUserId + '" class="form-control chat_message"></textarea>';
            dialog += '</div> <div class="form-group" align="right"> <button type="button" name="send_chat" id="'+toUserId+'" class="btn btn-info send_chat">Send</button></div></div>';
            $('#user_model_details').html(dialog);
        }

        $(document).on('click', '.start_chat', function(){
            let toUserId = $(this).data('touserid');
            let toUserName = $(this).data('tousername');
            makeChatDialogBox(toUserId, toUserName);
            $("#user_dialog_"+toUserId).dialog({
                autoOpen:false,
                width:400
            });
            $('#user_dialog_'+toUserId).dialog('open');
        });

        $(document).on('click', '.send_chat', function(){
            let toUserId = $(this).attr('id');
            let chatMessage = $('#chat_message_' + toUserId).val();
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

        function fetchUserChatHistory(toUserId){
            $.ajax({
                url:"fetchUserChatHistory.php",
                method:"POST",
                data:{to_user_id:toUserId},
                success:function(data){
                    $('#chat_history_'+toUserId).html(data);
                }
            })
        }

        function updateChat(){
            $('.chat_history').each(function(){
               let toUserId = $(this).data('touserid');
               fetchUserChatHistory(toUserId);
            });
        }

        //usuwa okno wiadomosci
        $(document).on('click', '.ui-button-icon', function(){
            $('.user_dialog').dialog('destroy').remove();
        });
        //informacja o tym ze rozmowca pisze cos
        $(document).on('focus', '.chat_message', function(){
            let typing = 'yes';
           $.ajax({
               url:"updateTypeStatus.php",
               method:"POST",
               data:{is_type:typing},
               success:function(){

               }
           })
        });
        //jesli przestanie pisac
        $(document).on('blur', '.chat_message', function(){
            let typing = 'no';
            $.ajax({
                url:"updateTypeStatus.php",
                method:"POST",
                data:{is_type:typing},
                success:function(){

                }
            })
        });

    });
</script>

