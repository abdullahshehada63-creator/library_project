<?php
session_start();
include "conn.php";
?>

<html>
<head>
    <title>Login Page</title>
    <?php
    include "head.php";
    include "navBar.php";  // تأكد من أن ملف navBar.php يحتوي على التعديلات المطلوبة
    ?>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-8 col-sm-4 col-md-4 col-lg-4"></div>
        <div class="col-xs-8 col-sm-4 col-md-4 col-lg-4" style="margin-top: 100px;">
            <div class="panel panel-info">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <center>
                        <form action="" method="post">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required><br>

                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required><br>

                            <input type="submit" name="login" value="Login" class="btn btn-primary">
                        </form>

                        <?php
                        if (isset($_POST['login'])) {
                            $username = mysqli_real_escape_string($conn, $_POST['username']);
                            $password = $_POST['password'];

                            $stmt = $conn->prepare("SELECT user_id, user_name, user_pass, type, block FROM t_user WHERE user_name = ?");
                            $stmt->bind_param("s", $username);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $userData = $result->fetch_assoc();

                                if ($userData['block'] == 1) {
                                    echo "<label style='color:red'>This user is blocked.</label>";
                                } elseif (password_verify($password, $userData['user_pass'])) {
                                    $_SESSION['type'] = $userData['type'];
                                    $_SESSION['id'] = $userData['user_id'];
                                    $_SESSION['name'] = $userData['user_name'];

                                    // التأكد من النوع إذا كان 0 (مسؤول)
                                    if ($_SESSION['type'] === '0') {
                                        header("Location: admin.php");
                                        exit;
                                    } else {
                                        echo "<label style='color:red'>Access denied. Not an admin.</label>";
                                    }
                                } else {
                                    echo "<label style='color:red'>Incorrect password.</label>";
                                }
                            } else {
                                echo "<label style='color:red'>User not found.</label>";
                            }

                            $stmt->close();
                        }
                        ?>
                    </center>
                </div>
            </div>
        </div>
        <div class="col-xs-8 col-sm-4 col-md-4 col-lg-4"></div>
    </div>
</div>
</body>
</html>
