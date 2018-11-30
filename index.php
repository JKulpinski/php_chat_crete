<?php
/**
 * Created by IntelliJ IDEA.
 * User: Konasz
 * Date: 29.11.2018
 * Time: 15:27
 */

include ('DB.php');

session_start();
//$cos = password_hash("jonasz",PASSWORD_DEFAULT);

if(!isset($_SESSION['user_id'])){ // if user isn't login yet it redirect him to login page
    header("location:login.php");
}
?>

<!DOCTYPE HTML>
<html lang="en-EN">
<head>
    <meta name="Author" content="Natalia Pasturczak & Jonasz Kulpinski"/>
    <meta name="keywords" content="jquery, html, js"/>
    <meta name="description" content="Chat"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!--show on mobile devices-->
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
    <!--    <link rel="stylesheet" type="text/css" href="style.css"/>-->
    <link rel="icon" href="favicon.ico"/>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    <title>Chat Application using Jquery</title>
    <script src="script.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<div class="container">
    <br/>

    <h3 align="center">Heraklion Chat</a></h3><br/>
    <br/>

    <div class="table-responsive">
        <p align="right">Welcome,  <?php echo $_SESSION['username']; ?> <!--<?php echo $cos ?> -->!
            <br><a href="logout.php" class="btn btn-danger">Logout</a></p>
        <h4 align="center">Users:</h4>
        <div id="user_details"</div>
</div>
</div>
</body>
</html>