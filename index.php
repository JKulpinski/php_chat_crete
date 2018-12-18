<?php
/**
 * Created by IntelliJ IDEA.
 * User: Konasz
 * Date: 29.11.2018
 * Time: 15:27
 */

include('DB.php');

session_start();
//$cos = password_hash("jonasz",PASSWORD_DEFAULT);

if (!isset($_SESSION['user_id'])) { // if user isn't login yet it redirect him to login page
    header("location:login.php");
}
?>

<!DOCTYPE HTML>
<html lang="en-EN" xmlns="http://www.w3.org/1999/html">
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
    <title>Heraklion Chat</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<div class="container">
    <br/>

    <h2 align="center">Heraklion Chat</h2><br/>
    <br/>

    <div class="table-responsive">
        <p align="right">Welcome, <?php echo $_SESSION['username']; ?> <!--<?php echo $cos ?> -->!

            <br><a href="logout.php" class="btn btn-danger">Logout</a></p>

        <input type="hidden" id="is_active_group_chat_window" value="no"/>
        <div name="group_chat" id="group_chat">Group Chat</div>
        <input type="hidden" id="is_active_create_chat_window" value="no"/>
        <button type="button" name="group_custom_chat" id="group_custom_chat" class="btn btn-success">Create new group
            Chat
        </button>
        <h4 align="center">Users:</h4>
        <div id="user_details"></div>
        <div id="user_model_details"></div>

    </div>
</div>

<div id="group_chat_dialog" title="Group Chat Window">
    <div id="group_chat_history" style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px;
    padding:16px;">
    </div>
    <div class="form-group">
        <textarea name="group_chat_message" id="group_chat_message" class="form-control"> </textarea>
    </div>
    <div class="form-group">
        <button type="button" name="leave_group_chat" id="leave_group_chat" class="btn btn-danger">Leave</button>
        <button type="button" style="float: right" name="send_group_chat" id="send_group_chat" class="btn
            btn-info">Send
        </button>
    </div>
</div>

<div id="create_chat_dialog" title="Creating Group Chat">
    <div id="create_group_window">
        Select group members:
        <div id="custom_chat_users"></div>
    </div>
    <div class="form-group" align="right">
        <form>
            Chat name:
            <input type="text" name="chatName">
        </form>
        <br>
        <button type="button" name="accept_group_chat" id="accept_group_chat" class="btn btn-info">Create group</button>
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function () {

        takeUsers();
        checkUsersforGroupChat();
        showGroupChat();
        var flag = 0;

        //every 2 seconds run these functions
        setInterval(function () {
            updateActivity();
            takeUsers();
            showGroupChat();
            updateChat();
            fetchGroupChatHistory();
            //$('#kicia').css("background-color", "yellow");
        }, 2000);

        setInterval(function () {
            checkUsersforGroupChat();
        }, 120000);

        //$('#'+toUserName).css("background-color", "blue");

        //open dialog box and start chat with person
        $(document).on('click', '.start_chat', function () {
            let toUserId = $(this).data('touserid');
            let toUserName = $(this).data('tousername');
            makeChatDialogBox(toUserId, toUserName);
            $("#user_dialog_" + toUserId).dialog({
                autoOpen: false,
                width: 400
            });
            $('#user_dialog_' + toUserId).dialog('open');
        });

        function takeUsers() {
            $.ajax({
                url: "takeUsers.php",
                method: "POST",
                success: function (data) {
                    $('#user_details').html(data);
                }
            })
        }

        function checkUsersforGroupChat() {
            $.ajax({
                url: "checkUsersforGroupChat.php",
                method: "POST",
                success: function (data) {
                    $('#custom_chat_users').html(data);
                }
            })
        }

        function updateActivity() {
            $.ajax({
                url: "updateLastActivity.php",
                success: function () {
                }
            })
        }

        function makeChatDialogBox(toUserId, toUserName) {
            let dialog = '<div id="user_dialog_' + toUserId + '" class="user_dialog" title="Chat with ' + toUserName + '">';
            dialog += '<div style="height:450px; border:1px solid #91e2ff; overflow-y: scroll; margin-bottom:22px; padding:18px;" class="chat_history" data-touserid="' + toUserId + '" id="chat_history_' + toUserId + '">';
            dialog += fetchUserChatHistory(toUserId);
            dialog += '</div> <div class="form-group"> <textarea name="chat_message_' + toUserId + '" id="chat_message_' + toUserId + '" class="form-control chat_message"></textarea>';
            dialog += '</div> <div class="form-group" align="right"> <button type="button" name="send_chat" id="' + toUserId + '" class="btn btn-info send_chat">Send</button></div></div>';
            $('#user_model_details').html(dialog);
        }

        function fetchUserChatHistory(toUserId) {
            $.ajax({
                url: "fetchUserChatHistory.php",
                method: "POST",
                data: {to_user_id: toUserId},
                success: function (data) {
                    $('#chat_history_' + toUserId).html(data);
                }
            })
        }

        function updateChat() {
            $('.chat_history').each(function () {
                let toUserId = $(this).data('touserid');
                fetchUserChatHistory(toUserId);
            });
        }

        //sending message to person
        $(document).on('click', '.send_chat', function () {
            let toUserId = $(this).attr('id');
            let chatMessage = $('#chat_message_' + toUserId).val();
            $.ajax({
                url: "insertChat.php",
                method: "POST",
                data: {to_user_id: toUserId, chat_message: chatMessage},
                success: function (data) {
                    $('#chat_message_' + toUserId).val('');
                    $('#chat_history_' + toUserId).html(data);
                }
            })
        });

        $(document).on('click', '#leave_group_chat', function () {
            let login_id = $(this).attr('id');
            $('#create_chat_dialog').hide();
            $('#group_chat_dialog').dialog('close');
            $('#is_active_group_chat_window').val('no');
            $.ajax({
                url: "removeFromGroupChat.php",
                method: "POST",
                data: {login_id: login_id},
                success: function (data) {
                    showGroupChat();
                }
            })
        });

        $(document).on('click', '#accept_group_chat', function () {
            let login_id = $(this).attr('id');
            $('#create_chat_dialog').hide();
            let chatName = $("input:text").val();
            $("input:text").val("");
            let action = "current_user";

            $.ajax({
                url: "addGroupChat.php",
                method: "POST",
                data: {chatName: chatName, login_id: login_id, action: action},
                success: function (data) {
                    showGroupChat();
                }
            })

            $('input:checkbox').each(function () {
                if ($(this).is(':checked') == true) {
                    let login_id = $(this).val();
                    let action = "add_user";
                    $.ajax({
                        url: "addGroupChat.php",
                        method: "POST",
                        data: {chatName: chatName, login_id: login_id, action: action},
                        success: function (data) {
                            showGroupChat();
                        }
                    })
                }
            });
        });

        //remove message window
        $(document).on('click', '.ui-button-icon', function () {
            $('.user_dialog').dialog('destroy').remove();
        });

        //show info if someone is typing now
        $(document).on('focus', '.chat_message', function () {
            let typing = 'y';
            $.ajax({
                url: "updateTypeStatus.php",
                method: "POST",
                data: {is_type: typing},
                success: function () {
                }
            })
        });

        //when someone stop typing
        $(document).on('blur', '.chat_message', function () {
            let typing = 'n';
            $.ajax({
                url: "updateTypeStatus.php",
                method: "POST",
                data: {is_type: typing},
                success: function () {
                }
            })
        });

        //it will not pop up dialog box on page load
        $('#group_chat_dialog').dialog({
            autoOpen: false,
            width: 400
        });

        //it create custom group chat    //////
        $('#accept_group_chat').click(function () {
            $('#group_chat').show();
            $('#create_chat_dialog').dialog('close');
            $('#is_active_create_chat_window').val('no');
        });

        //open group chat when we click button
        $('#group_chat').click(function () {
            $('#group_chat_dialog').dialog('open');
            $('#is_active_group_chat_window').val('yes');
            fetchGroupChatHistory();
        });

        $('#create_chat_dialog').dialog({
            autoOpen: false,
            width: 600
        });

        $('#group_custom_chat').click(function () {
            $('#create_chat_dialog').dialog('open');
            $('#is_active_create_chat_window').val('yes');
            //fetchGroupChatHistory();
        });

        //sending message to group
        $('#send_group_chat').click(function () {
            let chatMessage = $('#group_chat_message').val();
            let action = 'insert_data';
            if (chatMessage != '') {
                $.ajax({
                    url: "groupChat.php",
                    method: "POST",
                    data: {chat_message: chatMessage, action: action},
                    success: function (data) {
                        $('#group_chat_message').val('');
                        $('#group_chat_history').html(data);
                    }
                })
            }
        });

        function fetchGroupChatHistory() {
            let groupChatDialogActive = $('#is_active_group_chat_window').val();
            let action = "fetch_data";
            if (groupChatDialogActive == 'yes') {
                $.ajax({
                    url: "groupChat.php",
                    method: "POST",
                    data: {action: action},
                    success: function (data) {
                        $('#group_chat_history').html(data);
                    }
                })
            }
        }

        function showGroupChat1(toUserId) {
            $.ajax({
                url: "showGroupChat.php",
                method: "POST",
                data: {to_user_id: toUserId},
                success: function (data) {
                    if (data != '') {
                        $('#group_chat').val('');
                        $('#group_chat').show();
                        $('#group_chat').html(data);
                    }
                    else {
                        $('#group_chat').hide();
                    }
                }
            })
        }

        function showGroupChat() {
            let toUserId = $(this).data('touserid');
            showGroupChat1(toUserId);
        }
    });

</script>

