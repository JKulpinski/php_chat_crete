<?php
//odpowiada za wyswietlanie tabeli po zalogowaniu z uzytkownikiem, statusem
// i mozliwoscia czatu z nim
/**
 * Created by IntelliJ IDEA.
 * User: Konasz
 * Date: 29.11.2018
 * Time: 19:20
 */

include ('DB.php');
session_start();
//take detail info about all users except currently login user
$query = "SELECT * FROM login WHERE user_id !='".$_SESSION['user_id']."'";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$out = '<table class="table table-bordered table-striped">
            <tr>
                <td>Username</td>
                <td>Status</td>
                <td>Action</td>
            </tr>';
foreach ($result as $row){
    $out .= '
    <tr>
        <td>'.$row['username'].'</td>
        <td></td>
        <td><button type="button" class="btn btn-info btn-xs
            start_chat" data-touserid="'.$row['user_id'].'"
            data-tousername"'.$row['username'].'">START CHAT
        </button></td>
    </tr>
    ';
}
$out .= '</table>';

echo $out;
