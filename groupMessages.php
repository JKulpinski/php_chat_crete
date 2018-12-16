<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nati
 * Date: 15.12.2018
 * Time: 22:38
 */


include('DB.php');

session_start();

echo insertMessages($_SESSION["user_id"], $connect);