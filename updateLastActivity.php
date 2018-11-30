<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nati
 * Date: 30.11.2018
 * Time: 16:08
 */

//ctrl + shift + enter
include('DB.php');

session_start();

$query = "
UPDATE login_details SET last_activity = now() 
WHERE login_details_id = '".$_SESSION["login_details_id"]."'
";

$statement = $connect->prepare($query);

$statement->execute();