<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nati
 * Date: 30.11.2018
 * Time: 20:22
 */

include('DB.php');

session_start();

$data = array(
    ':to_user_id' => $_POST['to_user_id'],
    ':from_user_id' => $_SESSION['user_id'],
    ':chat_message' => $_POST['chat_message'],
    ':status' => '1',
);

$query = " INSERT INTO chat_message(to_user_id, from_user_id, chat_message, status)
 VALUES (:to_user_id, :from_user_id, :chat_message, :status)";

$statement = $connect->prepare($query);

if ($statement->execure($data)){

}