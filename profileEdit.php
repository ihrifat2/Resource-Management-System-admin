<?php
//Database Connection
require 'dbconnect.php';
//Start Session
session_start();
//Check Admin Authentication
require 'inc/auth.php';
$adminid = $_SESSION['admin_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin - Student Info</title>
    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin.css" rel="stylesheet">
    <script src="assets/js/sweetalert.min.js"></script>
</head>
<body id="page-top">
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
                    <li class="breadcrumb-item active">Profile Setting</li>
                </ol>
                <!-- DataTables Example -->
                <div class="card card-register mx-auto mt-5">
                    <div class="card-header">Password Change</div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="password" class="form-control" placeholder="Old Password" name="admin_oldpasswd" autofocus="On">
                                    <label>Old Password</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="password" class="form-control" placeholder="New Password" name="admin_newpasswd">
                                    <label>New Password</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="password" class="form-control" placeholder="Confirm Password" name="admin_conpasswd">
                                    <label>Confirm Password</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="admin_btn">Register</button>
                        </form>
                        <div class="text-center">
                            <!-- <a class="d-block small" href="forgot-password.html">Forgot Password?</a> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/js/rms.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="assets/vendor/datatables/jquery.dataTables.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin.min.js"></script>
    <!-- Demo scripts for this page-->
    <script src="assets/js/demo/datatables-demo.js"></script>
</body>
</html>
<?php
if (isset($_POST['admin_btn'])) {
    //Taking input
    $oldpass = $_POST['admin_oldpasswd'];
    $newpass = $_POST['admin_newpasswd'];
    $conpass = $_POST['admin_conpasswd'];
    //Check any of the input field is empty
    if (empty($oldpass) || empty($newpass) || empty($conpass)) {
        $notificationItemArray = array(
            'title'=>'Error!',
            'text'=>'All Fields Are Required.',
            'type'=>'error',
        );
    } else {
        //checking old password is correct
        $passchgQuery   = "SELECT * FROM `tbl_admininfo` WHERE `admin_id` = '$adminid'";
        $passchgResult  = mysqli_query($dbconnect, $passchgQuery);
        $passchgRows    = mysqli_fetch_array($passchgResult);
        $admin_paswd    = $passchgRows['admin_passwd'];
        //check password is match
        $check          = password_verify($oldpass, $admin_paswd);
        if ($check) {
            //check is both password is matched
            if ($newpass == $conpass) {
                //encrypt user password
                $password   = password_hash($conpass, PASSWORD_BCRYPT);
                //storing info to DB
                $sql    = "UPDATE `tbl_admininfo` SET `admin_passwd`='$password' WHERE `admin_id` = '$adminid'";
                $rslt   = mysqli_query($dbconnect, $sql);
                if ($rslt) {
                    $notificationItemArray = array(
                        'title'=>'Success!',
                        'text'=>'Password Changed.',
                        'type'=>'success',
                    );
                } else {
                    $notificationItemArray = array(
                        'title'=>'Error!',
                        'text'=>'Failed To Changed Password.',
                        'type'=>'error',
                    );
                }
            } else {
                $notificationItemArray = array(
                    'title'=>'Error!',
                    'text'=>'New Password And Confirm Password Not Matched.',
                    'type'=>'error',
                );
            }
        } else {
            $notificationItemArray = array(
                'title'=>'Error!',
                'text'=>'Old Password Not Matched.',
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