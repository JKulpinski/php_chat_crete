<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nati
 * Date: 15.12.2018
 * Time: 18:01
 */


include('DB.php');

session_start();

echo insertData($_SESSION["user_id"], $connect);