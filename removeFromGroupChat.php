<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nati
 * Date: 18.12.2018
 * Time: 15:16
 */

include('DB.php');
session_start();
$data = array(
    ':login_id' => $_SESSION['user_id'],
    ':status'   => '1'
);

$query = "
 DELETE FROM groupchat WHERE :login_id=login_id AND chatName='chatName';

 INSERT INTO chat_message 
 (from_user_id, to_user_id, chat_message, status) 
 VALUES ('-1','0',(SELECT username FROM login WHERE :login_id = user_id ), :status);
 ";

$statement = $connect->prepare($query);
$statement->execute($data);