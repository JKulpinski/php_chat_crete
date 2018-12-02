<?php
$connect = new PDO("mysql:host=localhost;dbname=chat", "root", "");
date_default_timezone_set('Europe/Athens');

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
function fetchUserChatHistory($from_user_id, $to_user_id, $connect)
{
    $query = "
 SELECT * FROM chat_message 
 WHERE (from_user_id = '" . $from_user_id . "' 
 AND to_user_id = '" . $to_user_id . "') 
 OR (from_user_id = '" . $to_user_id . "' 
 AND to_user_id = '" . $from_user_id . "') 
 ORDER BY timestamp DESC
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = '<ul class="list-unstyled">';
    foreach ($result as $row) {
        $user_name = '';
        if ($row["from_user_id"] == $from_user_id) {
            $user_name = '<b class="text-success">You</b>';
        } else {
            $user_name = '<b class="text-danger">' . getUserName($row['from_user_id'], $connect) . '</b>';
        }
        $output .= '
  <li style="border-bottom:1px dotted #ccc">
   <p>' . $user_name . ' - ' . $row["chat_message"] . '
    <div align="right">
     - <small><em>' . $row['timestamp'] . '</em></small>
    </div>
   </p>
  </li>
  ';
    }
    $output .= '</ul>';
    $query = "
 UPDATE chat_message 
 SET status = '0' 
 WHERE from_user_id = '" . $to_user_id . "' 
 AND to_user_id = '" . $from_user_id . "' 
 AND status = '1'
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

function countUnseenMessage($from_user_id, $to_user_id, $connect)
{
    $query = "
 SELECT * FROM chat_message 
 WHERE from_user_id = '$from_user_id' 
 AND to_user_id = '$to_user_id' 
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