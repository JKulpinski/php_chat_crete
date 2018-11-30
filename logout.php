<?php
/**
 * Created by IntelliJ IDEA.
 * User: Konasz
 * Date: 29.11.2018
 * Time: 17:58
 */
session_start();

session_destroy();

header('location:login.php');