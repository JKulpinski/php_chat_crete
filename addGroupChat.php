<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nati
 * Date: 16.12.2018
 * Time: 16:23
 */

include ('DB.php');
session_start();

$data = array(
    ':login_id' => $_SESSION['user_id'],
    ':chatName' => $_POST['chatName']
);

$query = "
 INSERT INTO groupchat(chatName, login_id, chat_message_id) 
 VALUES (:chatName,:login_id, '0')
 ";

$statement = $connect->prepare($query);
$statement->execute($data);