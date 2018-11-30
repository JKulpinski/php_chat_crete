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
    let modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
    modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
    modal_content += '</div>';
    modal_content += '<div class="form-group">';
    modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
    modal_content += '</div><div class="form-group" align="right">';
    modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
    $('#user_model_details').html(modal_content);
}

function xyz(){
    let to_user_id = $(this).data('touserid');
    let to_user_name = $(this).data('tousername');
    makeChatDialogBox(to_user_id,to_user_name);
    $("#user_dialog_"+to_user_id).dialog({
        autoOpen:false,
        width:400
    });
    $('#user_dialog_'+to_user_id).dialog('open');
}

window.addEventListener("load", function(){
    takeUsers();
    setInterval(updateLastActivity, 5000);
    setInterval(takeUsers, 5000);

    document.getElementById('.start_chat').addEventListener("click", xyz);
});