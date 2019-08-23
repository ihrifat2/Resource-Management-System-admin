<?php
//Database Connection
require 'dbconnect.php';
$sId = $_POST['sId'];
if ($sId) {
    $stdQuery   = "SELECT * FROM `tbl_userinfo` WHERE `userinfo_id` = '$sId'";
    $stdResult  = mysqli_query($dbconnect, $stdQuery);
    $stdRows    = mysqli_fetch_array($stdResult);
    $std_id     = $stdRows['userinfo_id'];
    $std_Status = $stdRows['userinfo_status'];
    if ($std_id && $std_Status == 0) {
        $stdDltQuery   = "UPDATE `tbl_userinfo` SET `userinfo_status`=1 WHERE `userinfo_id` = '$std_id'";
        $stdDltResult  = mysqli_query($dbconnect, $stdDltQuery);
        if ($stdDltResult) {
            $stdDltDone = 1;
        } else {
            $stdDltDone = 0;
        }
        echo json_encode($stdDltDone);
    } else {
        $stdDltQuery   = "UPDATE `tbl_userinfo` SET `userinfo_status`=0 WHERE `userinfo_id` = '$std_id'";
        $stdDltResult  = mysqli_query($dbconnect, $stdDltQuery);
        if ($stdDltResult) {
            $stdDltDone = 1;
        } else {
            $stdDltDone = 0;
        }
        echo json_encode($stdDltDone);
    }
} else {
    echo "<script>javascript:document.location='404.html'</script>";
}

?>