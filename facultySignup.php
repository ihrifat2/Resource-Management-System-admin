<?php
//Database Connection
require 'dbconnect.php';
//Start Session
session_start();
//Check Admin Authentication
require 'inc/auth.php';

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
    <title>RMS Admin - Faculty Register</title>
    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin.css" rel="stylesheet">
    <script src="assets/js/sweetalert.min.js"></script>
</head>
<body class="bg-dark">
    <!-- Navbar Start -->
    <?php include 'inc/navbar.php'; ?>
    <!-- Navbar End -->
    <div id="wrapper">
        <!-- Sidebar Start -->
        <?php include 'inc/Sidebar.php'; ?>
        <!-- Sidebar End -->
        <div id="content-wrapper">
            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Faculty Register</li>
                </ol>
                <!-- Page Content -->
                <div class="card card-register mx-auto mt-5">
                    <div class="card-header">Faculty Register</div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="text" class="form-control" placeholder="Full Name" name="FS_fullname" autofocus>
                                    <label for="inputEmail">Full Name</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input type="text" class="form-control" placeholder="Username" name="FS_username">
                                            <label for="inputEmail">Username</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input type="text" class="form-control" placeholder="Faculty ID" name="FS_rollid">
                                            <label for="inputEmail">Faculty ID</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="email" class="form-control" placeholder="Email address" name="FS_email">
                                    <label for="inputEmail">Email address</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input type="password" class="form-control" placeholder="Password" name="FS_newpasswd">
                                            <label for="inputPassword">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input type="password" class="form-control" placeholder="Confirm password" name="FS_conpasswd">
                                            <label for="confirmPassword">Confirm password</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="FS_btn">Register</button>
                        </form>
                        <div class="text-center">
                            <!-- <a class="d-block small" href="forgot-password.html">Forgot Password?</a> -->
                        </div>
                    </div>
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
if (isset($_POST['FS_btn'])) {
    //Taking input
    $FS_fullname    = validate_input($_POST['FS_fullname']);
    $FS_username    = validate_input($_POST['FS_username']);
    $FS_rollid      = validate_input($_POST['FS_rollid']);
    $FS_email       = validate_input($_POST['FS_email']);
    $FS_newpasswd   = validate_input($_POST['FS_newpasswd']);
    $FS_conpasswd   = validate_input($_POST['FS_conpasswd']);
    $today = date("Y-m-d");

    //Check any of the input field is empty
    if (empty($FS_fullname) || empty($FS_username) || empty($FS_rollid) || empty($FS_email) || empty($FS_newpasswd) || empty($FS_conpasswd)) {
        $notificationItemArray = array(
            'title'=>'Error!',
            'text'=>'All Fields Are Required.',
            'type'=>'error',
        );
    } else {
        //filter email
        if (filter_var($FS_email, FILTER_VALIDATE_EMAIL)) {
            //check is both password is matched
            if ($FS_newpasswd == $FS_conpasswd) {
                //encrypt user password
                $passwd     = password_hash($FS_newpasswd, PASSWORD_BCRYPT);
                //storing info to DB
                $sqlQuery   = "INSERT INTO `tbl_userinfo`(`userinfo_id`, `userinfo_name`, `userinfo_uname`, `userinfo_rollid`, `userinfo_email`, `userinfo_passwd`, `userinfo_role`, `userinfo_create`) VALUES (NULL,'$FS_fullname','$FS_username','$FS_rollid','$FS_email','$passwd','1','$today')";
                $result = mysqli_query($dbconnect, $sqlQuery);
                if ($result) {
                    $notificationItemArray = array(
                        'title'=>'Success!',
                        'text'=>'Registration Successfull.',
                        'type'=>'success',
                    );
                    // echo "<script>javascript:document.location='index.php'</script>"; 
                } else {
                    $notificationItemArray = array(
                        'title'=>'Error!',
                        'text'=>'An Unexpected Error Occured.',
                        'type'=>'error',
                    );
                }
            } else {
                $notificationItemArray = array(
                    'title'=>'Error!',
                    'text'=>'Password Not Matched.',
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