<?php
/**
 * Created by IntelliJ IDEA.
 * User: Konasz
 * Date: 12.12.2018
 * Time: 18:17
 */

include('DB.php');
session_start();
//take detail info about all users except currently login user
$query = "SELECT * FROM login WHERE user_id !='" . $_SESSION['user_id'] . "'";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$out = '<table class="table table-bordered table-striped">
            <tr>
                <td>Username</td>
                <td>Select</td>
            </tr>';
foreach ($result as $row) {
    $status = '';
    date_default_timezone_set('Europe/Athens');
    $current_timestamp = strtotime(date('Y-m-d H:i:s') . '-10 second');
    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp); //convert unix time

    //we check whether user is online
    $user_last_activity = fetchUserLastActivity($row['user_id'], $connect);
    if ($user_last_activity > $current_timestamp) {
        $status = '<span class="label label-success">Online</span>';
    } else {
        $status = '<span class="label label-danger">Offline</span>';
    }

    $out .= '
    <tr>
        <td>' . $row['username'] . ' ' . countUnseenMessage($row['user_id'], $_SESSION['user_id'], $connect) . ' ' . typingStatus($row['user_id'], $connect) . '</td>
        <td><input type="checkbox" value="$row[\'user_id\']"></td>
    </tr>
    ';
}
$out .= '</table>';

//<td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">START CHAT
//</button></td>

echo $out;