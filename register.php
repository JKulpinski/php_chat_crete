<?php
/**
 * Created by IntelliJ IDEA.
 * User: Konasz
 * Date: 11.12.2018
 * Time: 11:30
 */

include('DB.php');

session_start();

$message = '';

if (isset($_SESSION['user_id'])) {
    header('location:index.php');
}

if (isset($_POST["register"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $check_query = "
    SELECT * FROM login 
    WHERE username = :username
    ";
    $statement = $connect->prepare($check_query);
    $check_data = array(
        ':username' => $username
    );
    if ($statement->execute($check_data)) {
        if ($statement->rowCount() > 0) {
            $message .= '<p><label>Username already exist</label></p>';
        } else {
            if (empty($username)) {
                $message .= '<p><label>Username is required</label></p>';
            }
            if (empty($password)) {
                $message .= '<p><label>Password is required</label></p>';
            } else {
                if ($password != $_POST['confirm_password']) {
                    $message .= '<p><label>Password not match</label></p>';
                }
            }
            if ($message == '') {
                $data = array(
                    ':username' => $username,
                    ':password' => password_hash($password, PASSWORD_DEFAULT)
                );

                $query = "
                INSERT INTO login 
                (username, password) 
                VALUES (:username, :password)
                ";
                $statement = $connect->prepare($query);
                if ($statement->execute($data)) {
                    $message = "<label>Registration Success</label>";
                }
            }
        }
    }
}

?>

<html>
<head>
    <title>Feedback Chat</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<div class="container">
    <br/>

    <h2 align="center">Feedback Chat</a></h2><br/>
    <br/>
    <div class="panel panel-default">
        <div class="panel-heading">Feedback Chat Register</div>
        <div class="panel-body">
            <form method="post">
                <span class="text-danger"><?php echo $message; ?></span>
                <div class="form-group">
                    <label>Enter Username</label>
                    <input type="text" name="username" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Enter Password</label>
                    <input type="password" name="password" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Re-enter Password</label>
                    <input type="password" name="confirm_password" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="register" class="btn btn-info" value="Register"/>
                </div>
                <div align="right">
                    <a class="btn btn-warning" href="login.php">Back to login</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
