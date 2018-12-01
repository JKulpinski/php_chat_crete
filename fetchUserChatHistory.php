<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nati
 * Date: 01.12.2018
 * Time: 20:49
 */

include('DB.php');

session_start();

echo fetchUserChatHistory($_SESSION["user_id"], $_POST['to_user_id'], $connect);
