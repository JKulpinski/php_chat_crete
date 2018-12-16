<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nati
 * Date: 16.12.2018
 * Time: 16:23
 */

include('DB.php');
session_start();

if ($_POST["action"] == "current_user") {

    $data = array(
        ':chatName' => $_POST['chatName'],
        'login_id_current' => $_SESSION['user_id'],
    );

    $query = "
  INSERT INTO groupchat(chatName, login_id) 
 VALUES (:chatName,:login_id_current); 
 ";

    $statement = $connect->prepare($query);
    $statement->execute($data);

} else {
    $data = array(
        ':chatName' => $_POST['chatName'],
        ':login_id' => $_POST['login_id']
    );

    $query = "
 INSERT INTO groupchat(chatName, login_id) 
 VALUES (:chatName,:login_id); 
 ";

    $statement = $connect->prepare($query);
    $statement->execute($data);
}