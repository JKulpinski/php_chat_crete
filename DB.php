<?php
date_default_timezone_set('Europe/Athens');
$connect = new PDO("mysql:host=localhost;dbname=chat", "root", "");

function fetchUserLastActivity($user_id, $connect)
{
    $query = "
    SELECT * FROM login_details WHERE user_id = '$user_id'
    ORDER BY last_activity DESC LIMIT 1
    ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach ($result as $row) {
        return $row['last_activity'];
    }
}

// sending a massage
function fetchUserChatHistory($fromUserId, $toUserId, $connect)
{
    $query = "
 SELECT * FROM chat_message
 WHERE (from_user_id = '" . $fromUserId . "'
 AND to_user_id = '" . $toUserId . "')
 OR (from_user_id = '" . $toUserId . "'
 AND to_user_id = '" . $fromUserId . "')
 ORDER BY timestamp DESC
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    //here we are all messages
    $result = $statement->fetchAll();
    $output = '<ul class="list-unstyled">'; //bootstrap class

    foreach ($result as $row) {
        $userName = '';
        if ($row["from_user_id"] == $fromUserId) {
            $userName = '<b class="text">You</b>';
        } else {
            $userName = '<b class="text">' . getUserName($row['from_user_id'], $connect) . '</b>';
        }
        $output .= '<li style="border-bottom:1px dotted #ccc">
               <p>' . $userName . ' - ' . $row["chat_message"] . '
                  <div align="right">
            -<small><em>' . $row['timestamp'] . '</em></small>
            </div>
            </p>
            </li>
            ';
    }
    $output .= '</ul>';
    $query = "
    UPDATE chat_message SET status = '0' WHERE from_user_id = '" . $toUserId . "' AND  to_user_id = '" . $fromUserId . "' AND status = '1'
    ";
    $statement = $connect->prepare($query);
    $statement->execute();
    return $output;
}

function getUserName($userId, $connect)
{
    $query = "SELECT username FROM login WHERE user_id = '$userId'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach ($result as $row) {
        return $row['username'];
    }

}

function countUnseenMessage($fromUserId, $toUserId, $connect)
{
    $query = "
 SELECT * FROM chat_message 
 WHERE from_user_id = '$fromUserId' 
 AND to_user_id = '$toUserId' 
 AND status = '1'
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $count = $statement->rowCount();
    $output = '';
    if ($count > 0) {
        $output = '<span class="label label-success">' . $count . '</span>';
    }
    return $output;
}

//ze ma status piszacego
function typingStatus($userId, $connect)
{
    $query = "
    SELECT is_type FROM login_details WHERE user_id = '" . $userId . "' ORDER BY last_activity DESC LIMIT 1
    ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = '';
    foreach ($result as $row) {
        if ($row["is_type"] == 'y') {
            $output = ' - <small><em><span class="text-muted">Typing...</span></em></small>';
        }
    }
    return $output;
}

function fetchGroupChatHistory($connect)
{
    $query = "
 SELECT * FROM chat_message
 WHERE to_user_id = '0'
 ORDER BY timestamp DESC
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    //here we are all messages
    $result = $statement->fetchAll();
    $output = '<ul class="list-unstyled">'; //bootstrap class

    foreach ($result as $row) {
        $userName = '';
        if ($row["from_user_id"] == $_SESSION["user_id"]) {
            $userName = '<b class="text">You</b>';
        } else {
            $userName = '<b class="text">' .getUserName($row['from_user_id'], $connect).'</b>';
        }
        $output .= '<li style="border-bottom:1px dotted #ccc">
               <p>'.$userName.' - '.$row["chat_message"].'
                  <div align="right">
            -<small><em>'.$row['timestamp'].'</em></small>
            </div>
            </p>
            </li>
            ';
    }
        $output .= '</ul>';
        return $output;
}

function insertData($userId, $connect){
    $query = "
    SELECT chatName FROM groupchat WHERE login_id= '" . $userId . "';
    ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $count = $statement->rowCount();
    $result = $statement->fetchAll();
    $output = '';
        if ($count > 0) {
            foreach ($result as $row) {
            $output .=
                '<button type="button" name=' .$row['chatName']. 'id=' .$row['chatName']. ' class="btn btn-warning">' .$row['chatName']. '</button>';
        }
    }
    return $output;
}