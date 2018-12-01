/**
 * Created by IntelliJ IDEA.
 * User: Nati
 * Date: 30.11.2018
 * Time: 15:58
 */
function takeUsers() { //take users' datails and show on webpage
    $.ajax({
        url:"takeUsers.php",
        method:"POST",
        success:function(data) {
            $('#user_details').html(data); //display user details in html div
        }
    })
}

function updateLastActivity(){
    $.ajax({
        url:"updateLastActivity.php",
        success:function(){

        }
    })
}

function makeChatDialogBox(to_user_id,to_user_name){
    let dialog = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="Chat with '+to_user_name+'">';
    dialog += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
    dialog += '</div>';
    dialog += '<div class="form-group">';
    dialog += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
    dialog += '</div><div class="form-group" align="right">';
    dialog+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
    $('#user_model_details').html(dialog);
}

function xyz(){
    let toUserId = $(this).data('touserid');
    let toUserName = $(this).data('tousername');
    makeChatDialogBox(toUserId,toUserName);
    $("#user_dialog_"+toUserId).dialog({
        autoOpen:false,
        width:400
    });
    $('#user_dialog_'+toUserId).dialog('open');
}

window.addEventListener("load", function(){
    takeUsers();
    setInterval(updateLastActivity, 5000);
    setInterval(takeUsers, 5000);

    document.getElementById('.start_chat').addEventListener("click", xyz);
});