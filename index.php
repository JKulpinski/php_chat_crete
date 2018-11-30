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
        <div id="user_details"</div>
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

        function make_chat_dialog_box(to_user_id, to_user_name)
        {
            var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
            modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
            modal_content += '</div>';
            modal_content += '<div class="form-group">';
            modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
            modal_content += '</div><div class="form-group" align="right">';
            modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
            $('#user_model_details').html(modal_content);
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

    });
</script>
