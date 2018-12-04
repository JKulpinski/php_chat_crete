<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nati
 * Date: 04.12.2018
 * Time: 14:30
 */

include('DB.php');

session_start();

$query = "
UPDATE login_details SET is_type = '".$_POST["is_type"]."' WHERE login_details_id = '".$_SESSION["login_details_id"]."'
";

$statement=$connect->prepare($query);
$statement->execute();
