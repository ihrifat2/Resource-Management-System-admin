<?php
//Database Connection
require 'dbconnect.php';
//Start Session
session_start();
//Check Admin Authentication
if(isset($_SESSION["admin_id"]) && isset($_SESSION["admin_name"])) {
    header("Location: index.php");
}

//validate user input
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>RMS Admin - Login</title>
    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin.css" rel="stylesheet">
    <script src="assets/js/sweetalert.min.js"></script>
</head>
<body class="bg-dark">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" class="form-control" placeholder="Email address" name="adlogin_email" autofocus="autofocus">
                            <label for="inputEmail">Email address</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" class="form-control" placeholder="Password" name="adlogin_passwd">
                            <label for="inputPassword">Password</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="adlogin_btn">Login</button>
                </form>
                <div class="text-center">
                    <!-- <a class="d-block small mt-3" href="register.html">Register an Account</a>
                    <a class="d-block small" href="forgot-password.html">Forgot Password?</a> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>
<?php
if (isset($_POST['adlogin_btn'])) {
    //Taking input
    $login_email    = validate_input($_POST['adlogin_email']);
    $login_passwd   = validate_input($_POST['adlogin_passwd']);

    //Check any of the input field is empty
    if (empty($login_email) || empty($login_passwd)) {
        $notificationItemArray = array(
            'title'=>'Error!',
            'text'=>'All Fields Are Required.',
            'type'=>'error',
        );
    } else {
        //filter email
        if (filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
            //Getting info from DB
            $sqlQuery       = "SELECT * FROM `tbl_admininfo` WHERE `admin_email` = '$login_email'";
            $result         = mysqli_query($dbconnect, $sqlQuery);
            $rows           = mysqli_fetch_array($result);
            $store_password = $rows['admin_passwd'];
            $admin_id       = $rows['admin_id'];
            $admin_uname    = $rows['admin_username'];
            //check password is match
            $check          = password_verify($login_passwd, $store_password);
            if ($check) {
                //storing info to session
                $_SESSION['admin_id']    = $admin_id;
                $_SESSION['admin_name']  = $admin_uname;
                echo "<script>javascript:document.location='index.php'</script>";
            } else {
                $notificationItemArray = array(
                    'title'=>'Error!',
                    'text'=>'Email Or Password Is Invalid.',
                    'type'=>'error',
                );
            }
        } else {
            $notificationItemArray = array(
                'title'=>'Error!',
                'text'=>'Invalid Email Format.',
                'type'=>'error',
            );
        }
    }
    //storing notification to session
    if(!empty($_SESSION["notification_item"])) {
        if(in_array($RMSNotification["notification"],array_keys($_SESSION["notification_item"]))) {
            foreach($_SESSION["notification_item"] as $k => $v) {
                if($RMSNotification["notification"] == $k) {
                    if(empty($_SESSION["notification_item"][$k]["type"])) {
                        $_SESSION["notification_item"][$k]["type"] = 0;
                    }
                    $_SESSION["notification_item"][$k]["type"] += 'danger';
                }
            }
        } else {
            $_SESSION["notification_item"] = array_merge($_SESSION["notification_item"],$notificationItemArray);
        }
    } else {
        $_SESSION["notification_item"] = $notificationItemArray;
    }
}
//show notification from session
include 'inc/notification.php';
?>