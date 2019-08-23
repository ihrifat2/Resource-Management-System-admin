<?php
//Database Connection
require 'dbconnect.php';
//Start Session
session_start();
//Check Admin Authentication
require 'inc/auth.php';
//Getting all the faculty members info from DB
$studentInfoData = array();
$studentInfoQuery = "SELECT * FROM `tbl_userinfo` WHERE `userinfo_role` = 1 ORDER BY `userinfo_id` DESC";
$studentInfoResult = $dbconnect->query($studentInfoQuery);
if ($studentInfoResult) {
    while ($studentInfoRows = $studentInfoResult->fetch_array(MYSQLI_ASSOC)) {
        $studentInfoData[] = $studentInfoRows;
    }
    $studentInfoResult->close();
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
    <title>SB Admin - Faculty Info</title>
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
                    <li class="breadcrumb-item active">Faculty Info</li>
                </ol>
                <!-- DataTables Example -->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        Faculty Info
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>roll</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //print faculty info
                                    foreach ($studentInfoData as $studentInfoRow) {
                                    ?>
                                    <tr>
                                        <td><?php echo $studentInfoRow['userinfo_name']; ?></td>
                                        <td><?php echo $studentInfoRow['userinfo_uname']; ?></td>
                                        <td><?php echo $studentInfoRow['userinfo_rollid']; ?></td>
                                        <td><?php echo $studentInfoRow['userinfo_email']; ?></td>
                                        <?php
                                        if ($studentInfoRow['userinfo_status'] == 0) {
                                        ?>
                                        <td><a class='btn btn-primary' onclick='deletefaculty(<?php echo $studentInfoRow['userinfo_id']; ?>)' href='#'>Block</a></td>
                                        <?php
                                        } else {
                                        ?>
                                        <td><a class='btn btn-primary' onclick='deletefaculty(<?php echo $studentInfoRow['userinfo_id']; ?>)' href='#'>Unblock</a></td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php  
                                    }
                                    ?>
                                </tbody>
                            </table>
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
