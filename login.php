<?php
/**
 * Created by IntelliJ IDEA.
 * User: Konasz
 * Date: 29.11.2018
 * Time: 15:12
 */
include('DB.php'); //connection database
session_start();

$message = ''; //we store here messages

if(isset($_SESSION['user_id'])){ //if user is already login
    header('location:index.php');
}

if (isset($_POST['login'])) { // when press submit button
    $query = "SELECT * FROM login WHERE username = :username";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':username' => $_POST['username'] // take username value from input
        )
    );
    $count = $statement->rowCount();
    if ($count > 0) { //validation
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            if (password_verify($_POST['password'], $row['password'])) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $sub_query = "INSERT INTO login_details(user_id) VALUES ('".$row['user_id']."')";
                $statement = $connect->prepare($sub_query);
                $statement->execute();
                $_SESSION['login_details_id'] = $connect->lastInsertId();

                header('location:index.php');//redirect to index.php
            } else {
                $message = '<label>Wrong Password!</label>';
            }
        }
    } else {
        $message = '<label>Wrong Username!</label>';
    }
}

?>

<html>
<head>
    <title>Chat Application using PHP Ajax Jquery</title>
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
    <div class="panel panel-default">
        <div class="panel-heading">Chat Application Login</div>
        <div class="panel-body">
            <p class="text-danger"><?php echo $message; ?></p>
            <form method="post">
                <div class="form-group">
                    <label>Enter your Username</label>
                    <input type="text" name="username" class="form-control" required/>
                </div>
                <div class="form-group">
                    <label>Enter your Password</label>
                    <input type="password" name="password" class="form-control" required/>
                </div>
                <div class="form-group">
                    <input type="submit" name="login" class="btn btn-info" value="Login"/>
                </div>
            </form>
        </div>
        </form>
    </div>
</div>
</div>
</body>
</html>