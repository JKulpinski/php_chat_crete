<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nati
 * Date: 09.12.2018
 * Time: 12:03
 */

include("DB.php");

session_start();

if($_POST["action"] == "insert_data")
{
    $data = array(
        ':from_user_id'  => $_SESSION["user_id"],
        ':to_user_id'  => $_POST["to_user_id"],
        ':chat_message'  => $_POST['chat_message'],
        ':status'   => '1'
    );

    $query = "
 INSERT INTO chat_message 
 (from_user_id, to_user_id, chat_message, status) 
 VALUES (:from_user_id,:to_user_id, :chat_message, :status)
 ";

    $statement = $connect->prepare($query);

    if($statement->execute($data))
    {
        echo fetchGroupChatHistory($connect);
    }

}

if($_POST["action"] == "fetch_data")
{
    echo fetchGroupChatHistory($connect);
}
